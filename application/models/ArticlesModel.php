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

    public function search ($searchString = NULL, $shortForm = TRUE) {
        if ($searchString === NULL)
            return NULL;
        if ($shortForm)
            $sqlQuery = "SELECT id, headline FROM Articles WHERE headline LIKE :searchString";
        else
            $sqlQuery = "SELECT article.id, article.headline, article.created, article.published, article.last_edit,
                                category.name AS category, CONCAT_WS(' ', user.firstname, user.lastname) AS author
                        FROM Articles AS article
                                JOIN Articles_Categories AS category
                                    ON category.id = article.category
                                JOIN Users as user
                                    ON user.id = article.author_id
                        WHERE headline LIKE :searchString
                        ORDER BY article.created
                        DESC LIMIT 10";
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
            $this->bindValue($count++, $value);
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
            $this->bindValue($count++, $value);
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
     * @return  bool    |   array   |   integer
     */
    public function createArticle ($formData = NULL) {
        if ($formData === NULL)
            return FALSE;
        // Extract and reformat the data
        // before insertion to database.
        $data = $this->extractFormData($formData);
        // Create a new row for the new
        // post in the Articles table.
        $sqlQuery = "INSERT INTO Articles (author_id, category, headline, preamble, body, fact, tags, theme, created, published, last_edit) VALUES (:author, :category, :headline, :preamble, :body, :fact, :tags, :theme, :created, :published, :last_edit)";
        // The $data array will also hold other
        // metadata. Retrieve only the values
        // specific for the Articles table.
        $tmpArray = array("author", "category", "headline", "preamble", "body", "fact", "tags", "theme", "created", "published", "last_edit");
        // This retrieves only the key/value-pairs of
        // the $data array with the keynames above.
        $sqlParam = array_intersect_key($data, array_flip($tmpArray));
        // Insert into database and look
        // for errors before continuing.
        $response = $this->writeToDatabase($sqlQuery, $sqlParam);
        if (isset($response["error"]))
            return $response["error"];
        // The images and internal links
        // metadata are to be placed in
        // separate tables.
        if (!empty($data["images"]) && $data["images"] !== array(NULL)) {
            // Set the columns for the images metadata table
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
     * Updates the article in the database,
     * along with the images and links that
     * are to be added to or removed from it
     * or updated with new captions.
     *
     * @param   integer $articleID
     * @param   array   $formData
     * @return  bool    |   array   |   integer
     */
    public function updateArticle ($articleID = NULL, $formData = NULL) {
        if ($articleID === NULL || $formData === NULL)
            return FALSE;
        // Extract and reformat the data
        // before insertion to database.
        $data = $this->extractFormData($formData);
        // Set the query to update the row
        $sqlQuery = "UPDATE Articles SET author_id = :author, category = :category, headline = :headline, preamble = :preamble, body = :body, fact = :fact, tags = :tags, theme = :theme, published = :published, last_edit = :last_edit WHERE id = :id";
        // Unlike createArticle(), this time, created
        // will not be used, and instead last_edit is
        // utilized to set the update time.
        $tmpArray = array("author", "category", "headline", "preamble", "body", "fact", "tags", "theme", "published", "last_edit");
        // This retrieves only the key/value-pairs of
        // the $data array with the keynames above.
        $sqlParam = array_intersect_key($data, array_flip($tmpArray));
        $sqlParam["id"] = $articleID;
        // Insert into database and look
        // for errors before continuing.
        $response = $this->writeToDatabase($sqlQuery, $sqlParam);
        if (isset($response["error"]))
            return $response["error"];
        // The images and internal links
        // metadata are to be placed in
        // separate tables.
        if (!empty($data["images"]) && $data["images"] !== array(NULL)) {
            // Set the columns to fill for the images metadata table
            $columnArray = array("image_id", "article_id", "caption", "type");
            // Add the article id to the images, otherwise there
            // will be a problem with the insertMetadata method.
            foreach($data["images"] AS $key => $item) {
                $data["images"][$key]["article_id"] = $articleID;
            }
            // Insert the data. To make sure there will be no
            // duplicates, pass "caption" as the on duplicate
            // column to be updated.
            $error = $this->insertMetadata("Articles_Images_Metadata", $columnArray, $data["images"], $columnArray[2]);
            if (isset($error["error"]))
                return $error;
        }

        if (!empty($data["links"])) {
            // Create the array for the link metadata.
            $data["links"] = $this->createMetaLinkArray($data["links"], $articleID);
            // Set the columns to fill for the links metadata table
            $columnArray = array("article_id", "linked_article_id");
            // Insert the data. To make sure there will be no
            // duplicates, pass "article_id" as the on duplicate
            // column to be updated.
            $error = $this->insertMetadata("Articles_Metadata_Links", $columnArray, $data["links"], $columnArray[0]);
            if (isset($error["error"]))
                return $error;
        }
        // The delete array holds all the images
        // and links to be deleted.
        if (!empty($data["delete"])) {
            if (!empty($data["delete"]["images"])
            && $data["delete"]["images"] !== array(NULL)) {
                // Set the columns to check the values with.
                $columnArray = array("image_id", "article_id");
                // Set the values with the with the right column name as keys
                foreach($data["delete"]["images"] AS $key => $image) {
                    $valueArray[] = array(
                        $columnArray[0]   => $image,
                        $columnArray[1]   => $articleID
                    );
                }
                // Free the whales
                unset($data["delete"]["images"]);
                // Remove the metadata
                $error = $this->removeMetadata("Articles_Images_Metadata", $columnArray, $valueArray);
                if (isset($error["error"]))
                    return $error;
            }

            if (!empty($data["delete"]["links"])
            && $data["delete"]["links"] !== array(NULL)) {
                // Set the columns to check the values with.
                $columnArray = array("article_id", "linked_article_id");
                // Set the values with the with the right column name as keys
                foreach($data["delete"]["links"] AS $key => $link) {
                    $valueArray[] = array(
                        $columnArray[1]   => $link,
                        $columnArray[0]   => $articleID
                    );
                }
                // Free the whales
                unset($data["delete"]["links"]);
                // Remove the metadata
                $error = $this->removeMetadata("Articles_Metadata_Links", $columnArray, $valueArray);
                if (isset($error["error"]))
                    return $error;
            }
        }
        // If all goes according to plan
        return $articleID;
    }

    /**
     * Extracts and reformats if necessary
     * the information inside $formData.
     *
     * @param   array   $formData
     * @return  array
     */
    private function extractFormData ($formData) {
        // Required fields: Headline, preamble, body text and category.
        // If one of these are missing, do not continue.
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
            "last_edit"         => time(),
            "links"             => (empty($formData["links"])) ? NULL : $formData["links"]
        );
        // Get meta info of the images to be stored in a different database.
        $response["images"]     = $this->mergeImageWithCaption($formData["image-slideshow"], $formData["caption-slideshow"]);
        $response["images"][]   = $this->mergeImageWithCaption($formData["image-cover"], $formData["caption-cover"], "cover");
        // Check if any images are to be removed (only edit mode)
        $response["delete"]     = array(
            "images"            => (empty($formData["image-remove"]))
                                ?   NULL
                                :   $formData["image-remove"],
            "links"             => (empty($formData["link-remove"]))
                                ?   NULL
                                :   $formData["link-remove"],
        );
        // Remove any empty elements from the images and delete.
        $response["images"]     = array_filter($response["images"]);
        $response["delete"]     = array_filter($response["delete"]);
        // Check if the post is supposed to be published on a later date.
        $response["published"]  = (empty($formData["published-date"]))
                                ? NULL
                                : $this->getUnixTimestamp($formData["published-date"], $formData["published-time"]);
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
     * Creates multiple rows in a given table,
     * with the given columns and values.
     *
     * @param   string  $tableName
     * @param   array   $columnArray
     * @param   array   $valueArray
     * @param   string  $duplicateColumn
     * @return  mixed
     */
    private function insertMetadata ($tableName = NULL, $columnArray = NULL, $valueArray = NULL, $duplicateColumn = NULL) {
        // Make sure all the parameters are set and that the number
        // of columns match the number of values supplied.
        if ($tableName === NULL || $columnArray === NULL || $valueArray === NULL)
            return NULL;
        if (count($columnArray) !== count($valueArray[0]))
            return $this->createErrorMessage("Invalid parameter number: number of bound variables does not match number of tokens");
        // The items should all be inserted with one query. Create the
        // query and set the parameter markers based on the array size.
        // 'INSERT INTO X (Col1, Col2, Col3 ...) VALUES (?,?,? ...), (?,?,? ...)'
        $preQuery = "INSERT INTO " . $tableName . " (" . implode(", ", $columnArray) . ") VALUES ";
        // Fill the VALUES portion of query with as many placeholder markers
        // as needed, based on size of the values array and join the array.
        $PDOValue = array_fill(0, count($valueArray), $this->createMarkers(count($valueArray[0])));
        $sqlQuery = $preQuery . implode(",", $PDOValue);
        // If the duplicate parameter is set.
        if ($duplicateColumn !== NULL)
            $sqlQuery = $sqlQuery . " ON DUPLICATE KEY UPDATE {$duplicateColumn} = VALUES({$duplicateColumn})";
        // Prepare the query and replace the placeholders with the
        // actual vales with function bindParameters.
        $this->prepare($sqlQuery);
        $this->bindParameters($columnArray, $valueArray);
        // Insert into table, and check for any errors.
        $error = $this->writeToDatabase();
        return (isset($error["error"])) ? $error : TRUE;
    }

    /**
     * Deletes multiple rows in a given table,
     * with the given columns and values.
     *
     * @param   string  $tableName
     * @param   array   $columnArray
     * @param   array   $valueArray
     * @return  mixed
     */
    private function removeMetadata ($tableName = NULL, $columnArray = NULL, $valueArray = NULL) {
        // Make sure all the parameters are set and that the number
        // of columns match the number of values supplied.
        if ($tableName === NULL || $columnArray === NULL || $valueArray === NULL)
            return NULL;
        if (count($columnArray) !== count($valueArray[0]))
            return $this->createErrorMessage("Invalid parameter number: number of bound variables does not match number of tokens");
        // Create the query as per the design below, with the columns
        // represented by columnArray and values by the valueArray:
        // 'DELETE FROM X  WHERE (Z, Y) IN ( (?,?), (?,?) ... )'
        $sqlQuery = "DELETE FROM {$tableName} WHERE (" . implode(", ", $columnArray) . ") IN ";
        $PDOValue = array_fill(0, count($valueArray), $this->createMarkers(count($valueArray[0])));
        $sqlQuery = $sqlQuery . "(" . implode(", ", $PDOValue) . ")";
        // Prepare the query and replace the placeholders with the
        // actual vales with function bindParameters.
        $this->prepare($sqlQuery);
        $this->bindParameters($columnArray, $valueArray);
        // Insert into table, and check for any errors.
        $error = $this->writeToDatabase();
        return (isset($error["error"])) ? $error : TRUE;
    }

    /**
     * Binds the parameters in a PDO statement,
     * with position as markers position. Uses
     * the columns array to match the values.
     *
     * @param   array   $columnArray
     * @param   array   $valueArray
     */
    private function bindParameters ($columnArray, $valueArray) {
        // Position always starts at 1
        $position = 1;
        foreach ($valueArray AS $key => $value) {
            // Matching the values by keynames from
            // the column arrays makes sure that the
            // right value will fill the right column
            // in the database table.
            foreach ($columnArray AS $key => $column) {
                $this->bindValue($position++, $value[$column]);
            }
        }
    }

    /**
     * Returns a string representing a
     * question mark parameters marker
     * with n number of parameters.
     *
     * @param   integer $count
     * @param   bool    $withBrackets
     * @return  string
     */
    private function createMarkers ($count = 0, $withBrackets = TRUE) {
        $markers = array_fill(0, $count, '?');
        $markers = ($withBrackets) ? '(' . implode(", ", $markers) . ')' : implode(", ", $markers);
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
        $time = (empty($time)) ? "12:00" : $time;
        return  (empty($date)) ? NULL : strtotime($date . " " . $time);
    }
}
?>
