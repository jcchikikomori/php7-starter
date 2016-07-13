<?php

/**
 * Quick Pagination Class
 *
 * Documentation
 *
 * @author jccultima123 / johncyrillcorsanes@gmail.com
 * @license MIT
 */
class Pagination {

    public $id;     //page id from GET or POST (untested)
    public $start;  //starting line (NOTE: This is different to page id)
    public $limit;  //item limit each page

    /**
     * Pagination constructor.
     * @param int $id   ID from get or POST for Paging
     * @param $limit    Row limit
     * @param $rows     Total rows
     */
    function __construct($id = STARTING_PAGE, $limit = NULL, $rows = NULL)
    {
        //init vars
        $this->id = (!isset($id)) ? STARTING_PAGE : $id;
        $this->start = STARTING_PAGE;
        $this->limit = (!empty($limit)) ? $limit : ITEM_PER_PAGE;

        $this->paginate($this->id, $this->start, $this->limit);
    }

    /**
     * @param int $id
     * @param int $start
     * @param int $limit
     */
    public function paginate($id, $start, $limit) {
        if (isset($id)) {
            $this->id = $id;
            $this->start = ($id - 1) * $limit;
        } else {
            $this->start = $this->id;
        }
    }

    public function getTotalRows($rows) {
        return ceil($rows/$this->limit);
    }

}