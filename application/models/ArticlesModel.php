<?php
/**
 * Articles Model
 *
 * Handles all the data regarding the creation and
 * otherwise manipulation of articles and posts of
 * the Helium Application.
 *
 * @version 1.0
 * @author  Ardalan Samimi
 * @since   Available since 0.10.2
 */
class ArticlesModel extends Model {

    /**
     * Get article with specified id
     * from the database, along with
     * its metadata.
     *
     * @param   integer $articleID
     * @return  array
     */
    public function getArticle ($articleID = NULL) {
        if ($articleID === NULL)
            return FALSE;
        $sqlQuery = "SELECT article.id, article.author_id, article.headline, article.preamble, article.body,
                            article.fact, article.tags, article.theme, article.published, category.id AS category
                    FROM Articles AS article
                            JOIN Articles_Categories AS category
                                ON category.id = article.category
                    WHERE article.id = :id";
        $sqlParam = array("id" => $articleID);
        $response["article"] = $this->readFromDatabase($sqlQuery, $sqlParam, FALSE);
        // Get the published date
        if (!empty($response["article"]["published"])) {
            $response["article"]["published"] = array(
                "date" => date("m/d/Y", $response["article"]["published"]),
                "time" => date("H:i", $response["article"]["published"])
            );
        } else {
            $response["article"]["published"] = array(
                "date" => NULL,
                "time" => NULL
            );
        }
        // Retrieve metadata
        // Images
        $tableName          = "Articles_Images_Metadata AS meta";
        $columns            = array(
            "meta.caption",
            "image.id",
            "image.image_name",
            "image.type"
        );
        $condition          = array("meta.article_id = :id");
        $joins              = array("Articles_Images AS image");
        $joinsCondition     = array("image.id = meta.image_id");
        $tmpArray           = $this->getMetadataOfArticle($tableName, $columns, $condition, $sqlParam, $joins, $joinsCondition);
        // The images are either of type cover
        // or slideshow, below code will sort
        // the types in two different variables.
        $response["slideshow"]  = array_filter($tmpArray, function($value) { return $value["type"] === "slideshow"; });
        $response["cover"]      = array_shift(array_filter($tmpArray, function($value) { return $value["type"] === "cover"; }));
        // Linked articles
        $tableName          = "Articles_Metadata_Links AS meta";
        $columns            = array(
            "meta.linked_article_id AS id",
            "article.headline"
        );
        $joins              = array("Articles AS article");
        $joinsCondition     = array("article.id = meta.linked_article_id");
        $response["links"]  = $this->getMetadataOfArticle($tableName, $columns, $condition, $sqlParam, $joins, $joinsCondition);

        return $response;
    }

    /**
     * Returns the ten most recent
     * articles from the database.
     * TODO: Add paging.
     *
     * @return  array
     */
    public function getArticles () {
        $sqlQuery = "SELECT article.id, article.headline, article.created, article.published, article.last_edit,
                            category.name AS category, CONCAT_WS(' ', user.firstname, user.lastname) AS author
                    FROM Articles AS article
                            JOIN Articles_Categories AS category
                                ON category.id = article.category
                            JOIN Users AS user
                                ON user.id = article.author_id
                    ORDER BY article.created
                    DESC LIMIT 10";
        $response = $this->readFromDatabase($sqlQuery);
        return $response;
    }

    /**
     * Returns all the users (authors)
     * from the database.
     *
     * @return  array
     */
    public function getUsers () {
        $sqlQuery = "SELECT id, CONCAT_WS(' ', firstname, lastname) AS author FROM Users";
        $response = $this->readFromDatabase($sqlQuery);
        $returnValue = array(
            "current"   => Session::get("user_id"),
            "list"      => $response
        );
        return $returnValue;
    }

    /**
     * Returns the articles categories
     * fetched from the database.
     *
     * @return  array
     */
    public function getCategories () {
        $sqlQuery = "SELECT id, name FROM Articles_Categories";
        $response = $this->readFromDatabase($sqlQuery);
        return $response;

    }

    public function search ($searchString = NULL, $shortForm = TRUE) {
        if ($searchString === NULL)
            return NULL;
        if ($shortForm)
            $sqlQuery = "SELECT id, headline FROM Articles WHERE headline LIKE :searchString";
        else
            $sqlQuery = "SELECT article.id, article.headline, article.created, article.published, article.last_edit, category.name AS category, CONCAT_WS(' ', user.firstname, user.lastname) AS author FROM Articles AS article JOIN Articles_Categories AS category ON category.id = article.category JOIN Users as user ON user.id = article.author_id WHERE headline LIKE :searchString ORDER BY article.created DESC LIMIT 10";
        $sqlParam = array("searchString" => '%' . $searchString . '%');
        $response = $this->readFromDatabase($sqlQuery, $sqlParam);
        return $response;
    }

    /**
     * Retrieve the name of the images
     * with given ids, as specified in
     * the parameter.
     *
     * @param   array   $imageArray
     * @return  array
     */
    public function getImagesWithID ($imageArray = NULL) {
        if ($imageArray === NULL)
            return NULL;
        // The query will fetch all at once, by
        // using the exact amount of markers as
        // the size of the array dictates.
        $sqlQuery = "SELECT id, image_name FROM Articles_Images WHERE id IN " . $this->createMarkers(count($imageArray));
        $this->prepare($sqlQuery);
        // Bind the values = set the IDs
        $count = 1;
        foreach ($imageArray AS $value)
            $this->bindvalue($count++, $value);
        $response = $this->readFromDatabase();
        return $response;
    }

    /**
     * Retrieve the headline of the articles
     * with given ids, as specified in the
     * parameter.
     *
     * @param   array   $linksArray
     * @return  array
     */
    public function getLinks ($linksArray = NULL) {
        if ($linksArray === NULL)
            return NULL;
        // The query will fetch all at once, by
        // using the exact amount of markers as
        // the size of the array dictates.
        $sqlQuery = "SELECT id, headline FROM Articles WHERE id IN " . $this->createMarkers(count($linksArray));
        $this->prepare($sqlQuery);
        // Bind the values = set the IDs
        $count = 1;
        foreach ($linksArray AS $value)
            $this->bindvalue($count++, $value);
        $response = $this->readFromDatabase();
        return $response;
    }

    /**
     * Adds the article to the database,
     * along with the images that are to
     * be connected to it in a separate
     * database table.
     *
     * @param   array   $formData
     * @return  bool    |   array
     */
    public function createArticle ($formData = NULL) {
        if ($formData === NULL)
            return FALSE;
        // Extract and reformat the data
        // before insertion to database.
        $data = $this->extractFormData($formData);
        // Create a new row for the new
        // post in the Articles table.
        $sqlQuery = "INSERT INTO Articles (author_id, category, headline, preamble, body, fact, tags, theme, created, published) VALUES (:author, :category, :headline, :preamble, :body, :fact, :tags, :theme, :created, :published)";
        // The $data variable will also
        // hold other meta data. Retrieve
        // only the values specific for
        // the Articles table.
        $tmpArray = array("author", "category", "headline", "preamble", "body", "fact", "tags", "theme", "created", "published");
        $sqlParam = array_intersect_key($data, array_flip($tmpArray));
        // Insert into database and look
        // for errors before continuing.
        $response = $this->writeToDatabase($sqlQuery, $sqlParam);
        if (isset($response["error"]))
            return $response["error"];
        // The images and internal links
        // metadata are to be placed in
        // separate tables.
        $array["images"] = array_filter($array["images"]);
        if (!empty($data["images"]) && $data["images"] !== array(NULL)) {
            // Create the columns for the images metadata table
            $array = array("image_id", "article_id", "caption", "type");
            // Add the article id to the images, otherwise there
            // will be a problem with the insertMetadata method.
            foreach($data["images"] AS $key => $item) {
                $data["images"][$key]["article_id"] = $response;
            }
            // Insert the data
            $error = $this->insertMetadata("Articles_Images_Metadata", $array, $data["images"]);
            if (isset($error["error"]))
                return $error;
        }

        if (!empty($data["links"])) {
            $data["links"] = $this->createMetaLinkArray($data["links"], $response);
            $array = array("article_id", "linked_article_id");
            $error = $this->insertMetadata("Articles_Metadata_Links", $array, $data["links"]);
            if (isset($error["error"]))
                return $error;
        }
        // If all goes according to plan
        return $response;
    }

    /**
     * Extracts and reformats if necessary
     * the information inside $formData.
     *
     * @param   array   $formData
     * @return  array
     */
    private function extractFormData ($formData) {
        // Required fields: Headline, preamble,
        // body text and category. If one of
        // these are missing, do not continue.
        if (empty($formData["headline"]))
            return $response["error"]["message"] = "Headline required";
        if (empty($formData["preamble"]))
            return $response["error"]["message"] = "Preamble required";
        if (empty($formData["body"]))
            return $response["error"]["message"] = "Body text required";
        if (empty($formData["category"]))
            return $response["error"]["message"] = "Category required";
        // Set the return array
        $response = array(
            "author"            => (empty($formData["author"])) ? 0 : $formData["author"],
            "headline"          => $formData["headline"],
            "preamble"          => $formData["preamble"],
            "body"              => $formData["body"],
            "category"          => $formData["category"],
            "fact"              => (empty($formData["fact"])) ? NULL : $formData["fact"],
            "tags"              => (empty($formData["tags"])) ? NULL : $formData["tags"],
            "theme"             => (empty($formData["theme"])) ? NULL : $formData["theme"],
            "created"           => time(),
            "links"             => (empty($formData["links"])) ? NULL : $formData["links"]
        );

        // Get meta info of the images to be
        // stored in a different database.
        $response["images"]     = $this->mergeImageWithCaption($formData["image-slideshow"], $formData["caption-slideshow"]);
        $response["images"][]   = $this->mergeImageWithCaption($formData["image-cover"], $formData["caption-cover"], "cover");
        $response["images"]     = array_filter($response["images"]);
        // Check if the post is supposed to
        // be published on a later date.
        if (empty($formData["published-date"])) {
            $response["published"] = NULL;
        } else {
            $response["published"] = $this->getUnixTimestamp($formData["published-date"], $formData["published-time"]);
        }

        return $response;
    }

    /**
     * Create an array out of the two separate
     * images and captions arrays.
     *
     * @param   mixed   $image
     * @param   mixed   $caption
     * @param   string  $type
     * @return  array   |   null
     */
    private function mergeImageWithCaption ($image = NULL, $caption = NULL, $type = "normal") {
        if (empty($image))
            return NULL;
        if (is_array($image)) {
            foreach ($image AS $key => $image) {
                $response[] = array(
                    "image_id"  => $image,
                    "caption"   => (empty($caption[$key])) ? NULL : $caption[$key],
                    "type"      => $type
                );
            }
        } else {
            $response = array(
                "image_id"  => $image,
                "caption"   => (empty($caption)) ? NULL : $caption,
                "type"      => $type
            );
        }

        return $response;
    }

    /**
     * Format the internal links array
     * and add the article id to it.
     *
     * @param   array   $linksArray
     * @param   integer $articleID
     * @return  array
     */
    private function createMetaLinkArray ($linksArray, $articleID) {
        foreach ($linksArray AS $key => $link) {
            $links[] = array(
                "article_id" => $articleID,
                "linked_article_id" => $link
            );
        }
        return $links;
    }

    /**
     * Creates multiple rows in a given
     * table, with the given columns and
     * values.
     *
     * @param   string  $tableName
     * @param   array   $columnArray
     * @param   array   $valueArray
     * @return  mixed
     */
    private function insertMetadata ($tableName = NULL, $columnArray = NULL, $valueArray = NULL) {
        if ($tableName === NULL || $columnArray === NULL || $valueArray === NULL)
            return NULL;
        // Make sure that the number of columns
        // match the number of values supplied.
        if (count($columnArray) !== count($valueArray[0])) {
            return $this->createErrorMessage("Invalid parameter number: number of bound variables does not match number of tokens");
        }
        // The metadata items should all be
        // inserted with one query. Prepare
        // the query, create the parameter
        // markers based on the array size.
        $preQuery = "INSERT INTO " . $tableName . " (" . implode(", ", $columnArray) . ") VALUES ";
        $PDOValue = array_fill(0, count($valueArray), $this->createMarkers(count($valueArray[0])));
        $sqlQuery = $preQuery . implode(",", $PDOValue);
        $this->prepare($sqlQuery);
        $count = 1;
        // Bind the parameters, with $count as
        // the positions marker. The value arrays
        // keys must match the columns array, as
        // they are going to fill those columns.
        foreach ($valueArray AS $key => $value) {
            // Matching the values by keynames from
            // the column arrays makes sure that the
            // right value will fill the right column
            // in the database table.
            foreach ($columnArray AS $column) {
                $this->bindvalue($count++, $value[$column]);
            }
        }
        // Insert into table, and
        // check for any errors.
        $error = $this->writeToDatabase();
        if (isset($error["error"]))
            return $error;
        return TRUE;
    }

    /**
     * Abstract function for retrieving the
     * metadata of given article.
     *
     * @param   string  $tableName
     * @param   array   $columns
     * @param   array   $condition
     * @param   array   $sqlParam
     * @param   array   $joins
     * @param   array   $joinsCondition
     * @return  array
     */
    private function getMetadataOfArticle ($tableName, $columns, $condition, $sqlParam, $joins = NULL, $joinsCondition = NULL) {
        // Create the base of the query.
        $sqlQuery = "SELECT " . implode(", ", $columns) . " FROM " . $tableName;
        // Add the JOIN if there are any.
        if ($joins !== NULL)
            foreach ($joins AS $key => $table)
                $sqlQuery .= " JOIN " . $table . " ON " . $joinsCondition[$key];
        // Continue with the conditions
        // and then execute the query.
        $sqlQuery .= " WHERE " . implode (" AND ", $condition);
        $response = $this->readFromDatabase($sqlQuery, $sqlParam);

        return $response;
    }

    /**
     * Returns a string representing a
     * question mark parameters marker
     * with n number of parameters.
     *
     * @param   integer $count
     * @return  string
     */
    private function createMarkers ($count = 0) {
        $markers = array_fill(0, $count, '?');
        $markers = '(' . implode(", ", $markers) . ')';
        return $markers;
    }

    /**
     * Converts a string date
     * to unix timestamp.
     *
     * @param   string $date
     * @param   string $time
     * @return  string  |   null
     */
    private function getUnixTimestamp ($date = NULL, $time = NULL) {
        if (empty($date))
            return NULL;
        return strtotime($date . " " . $time);
    }
}
?>
