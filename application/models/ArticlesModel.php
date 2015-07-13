<?php
/**
 * Articles Model
 *
 * Handles all the data regarding the creation and
 * otherwise manipulation of articles and posts of
 * the Helium Application.
 *
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
        $sqlQuery = "INSERT INTO Articles (authorId, category, headline, preamble, body, fact, theme, created, published) VALUES (:author, :category, :headline, :preamble, :body, :fact, :theme, :created, :published)";
        // The $data variable will also
        // hold the image meta data. Get
        // only the values specific for
        // the Articles table.
        $tmpArray = array("author", "category", "headline", "preamble", "body", "fact", "theme", "created", "published");
        $sqlParam = array_intersect_key($data, array_flip($tmpArray));
        // Insert into database and look
        // for errors before continuing.
        $response = $this->writeToDatabase($sqlQuery, $sqlParam);
        if (isset($response["error"]))
            return $response["error"];
        // The images metadata are to be
        // placed in a separate table.
        if (!empty($data["images"])) {
            // The images will all be inserted
            // with just one query. Prepare the
            // query and create the parameter
            // markers based on the number of
            // images inside the array.
            $preQuery = "INSERT INTO Articles_Images_Metadata (image_id, article_id, caption, type) VALUES ";
            $PDOValue = array_fill(0, count($data["images"]), "(?, ?, ?, ?)");
            $sqlQuery = $preQuery . implode(",", $PDOValue);
            $this->prepare($sqlQuery);
            $count = 1;
            // Loop through the images array
            // and bind the parameters, with
            // $count as position marker.
            foreach ($data['images'] AS $ke => $image) {
                $this->bindValue($count++, $image["image_id"]);
                $this->bindValue($count++, $response);
                $this->bindValue($count++, $image["caption"]);
                $this->bindValue($count++, $image["type"]);
            }
            // Insert into table, and
            // check for any errors.
            $error = $this->writeToDatabase();
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
            "headline"          => utf8_decode($formData["headline"]),
            "preamble"          => utf8_decode($formData["preamble"]),
            "body"              => utf8_decode($formData["body"]),
            "category"          => $formData["category"],
            "fact"              => (empty($formData["fact"])) ? NULL : utf8_decode($formData["fact"]),
            "theme"             => (empty($formData["theme"])) ? NULL : $formData["theme"],
            "created"           => time()
        );
        // Get meta info of the images to be
        // stored in a different database.
        $response['images']     = $this->mergeImageWithCaption($formData['image-slideshow'], $formData['caption-slideshow']);
        $response["images"][]   = $this->mergeImageWithCaption($formData['image-cover'], $formData['caption-cover'], "cover");
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
                    "caption"   => (empty($caption[$key])) ? NULL : utf8_decode($caption[$key]),
                    "type"      => $type
                );
            }
        } else {
            $response = array(
                "image_id"  => $image,
                "caption"   => (empty($caption)) ? NULL : utf8_decode($caption),
                "type"      => $type
            );
        }

        return $response;
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
