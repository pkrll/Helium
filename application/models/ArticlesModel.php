<?php
/**
 * Articles Model
 *
 * Handles all the data regarding the creation and
 * otherwise manipulation of articles and posts of
 * the Helium Application.
 *
 * @version 1.0.1
 * @author  Ardalan Samimi
 * @since   Available since 0.10.2
 */
class ArticlesModel extends Model {

    /**
     * Returns all the users (authors)
     * from the database.
     *
     * @return  array
     */
    public function getUsers () {
        $sqlQuery = "SELECT id, firstname, lastname FROM Users";
        $response = $this->readFromDatabase($sqlQuery);
        $returnValue = array(
            "userID" => Session::get("user_id"),
            "users" => $response
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

    public function search ($searchString = NULL) {
        if ($searchString === NULL)
            return NULL;
        $sqlQuery = "SELECT id, headline FROM Articles WHERE headline LIKE :searchString";
        $sqlParam = array("searchString" => '%' . $searchString . '%');
        $response = $this->readFromDatabase($sqlQuery, $sqlParam);
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
        $sqlQuery = "INSERT INTO Articles (author_id, category, headline, preamble, body, fact, theme, created, published) VALUES (:author, :category, :headline, :preamble, :body, :fact, :theme, :created, :published)";
        // The $data variable will also
        // hold other meta data. Retrieve
        // only the values specific for
        // the Articles table.
        $tmpArray = array("author", "category", "headline", "preamble", "body", "fact", "theme", "created", "published");
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
            "theme"             => (empty($formData["theme"])) ? NULL : $formData["theme"],
            "created"           => time(),
            "links"             => (empty($formData["links"])) ? NULL : $formData["links"]
        );

        // Get meta info of the images to be
        // stored in a different database.
        $response['images']     = $this->mergeImageWithCaption($formData['image-slideshow'], $formData['caption-slideshow']);
        $response["images"][]   = $this->mergeImageWithCaption($formData['image-cover'], $formData['caption-cover'], "cover");
        $response["images"]     = array_filter($response["images"]);
        // Check if the post is supposed to
        // be published on a later date.
        if (empty($formData['published-date'])) {
            $response["published"] = NULL;
        } else {
            $response['published'] = $this->getUnixTimestamp($formData['published-date'], $formData['published-time']);
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
        // markers based on the count of the
        // array
        $preQuery = "INSERT INTO " . $tableName . " (" . implode(", ", $columnArray) . ") VALUES ";
        $PDOValue = array_fill(0, count($valueArray), $this->createMarkers(count($valueArray[0])));
        $sqlQuery = $preQuery . implode(",", $PDOValue);
        $this->prepare($sqlQuery);
        $count = 1;
        // Bind the parameters, with $count as
        // the positions marker. The values array
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
    private function getUnixTimestamp($date = NULL, $time = NULL) {
        if (empty($date))
            return NULL;
        return strtotime($date . " " . $time);
    }
}
?>
