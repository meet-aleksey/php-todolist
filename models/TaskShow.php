<?php
namespace TodoList\Models;

class TaskShow {

    /**
     * @var Task
     */
    public $task;

   /**
    * The list of tags.
    
    * @var string
    **/
    public $tags;

    /**
     * @var File
     */
    public $files;

    /**
     * @var Comment
     */
    public $comments;

    public function __construct($task, $files, $tags, $comments)
    {
        $this->task = $task;
        $this->files = $files;
        $this->tags = $tags;
        $this->comments = $comments;
    }

}