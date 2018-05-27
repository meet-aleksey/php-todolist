<?php
namespace TodoList\Models;

require_once __DIR__ . '/PageList.php';

class GroupList extends PageList {

    /**
     * The list of groups.
     * 
     * @var Group[]
     */
    public $items;

}