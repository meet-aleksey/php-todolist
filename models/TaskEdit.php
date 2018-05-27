<?php
namespace TodoList\Models;

class TaskEdit {

    /**
     * @var Task
     */
    public $task;

   /**
    * The list of groups to select.
    
    * @var PhpMvc\SelectListItem[]
    **/
    public $groups;

   /**
    * The list of tags.
    
    * @var string
    **/
    public $tags;

    /**
     * Selected group.
     * 
     * @var int
     **/
    public $groupId;

    /**
     * @var int[]
     */
    public $uploadedFiles;

    /**
     * @var int[]
     */
    public $removedFiles;

    public function __construct($task = null)
    {
        $this->task = isset($task) ? $task : new Task();
    }

}