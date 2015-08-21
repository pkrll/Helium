<?php
/**
 * Admin model
 */
use hyperion\core\Model;
class AdminModel extends Model {

    /**
     * Retrieve posts from the database, with a
     * paging function.
     *
     * @param   int     Page to start from when
     *                  fetching rows. Defaults
     *                  to 0.
     * @param   int     Number of rows to fetch.
     *                  Defaults to 10.
     * @return  array
     */
    public function retrievePosts($page = 0, $limit = 10) {
        $sqlQuery = "SELECT a.id, a.category, a.headline, a.created, a.last_edit, CONCAT_WS('', u.firstname, u.lastname) AS name FROM Articles AS a JOIN Users AS u ON u.id = a.author_id";
        $rows = $this->read($sqlQuery);
        return $rows;
    }

}
