<?php
namespace TodoList\Models;

require_once __DIR__ . '/PageList.php';

class TaskList extends PageList {

    /**
     * @var string
     */
    public $search;

    /**
     * @var string
     */
    public $state;

    /**
     * The list of tasks.
     * 
     * @var Task[]
     */
    public $items;

}