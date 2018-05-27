<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Task {

    /**
     * Unique identificator.
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    public $id;

    /** 
     * Title of the task.
     * 
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    public $title;

    /** 
     * Text of the task.
     * 
     * @ORM\Column(type="text")
     * @var string
     */
    public $text;

    /**
     * Status of the task.
     * 
     * @ORM\Column(type="boolean", options={"default": 0})
     * @var bool
     */
    public $closed;

    /** 
     * Comments count.
     * 
     * @ORM\Column(type="integer", options={"default": 0})
     * @var int
     */
    public $comments;

    /** 
     * Date created.
     * 
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    public $created;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * @var User
     **/
    public $user;

    /**
     * @ORM\ManyToOne(targetEntity="Group", cascade={"persist"})
     * @ORM\JoinColumn(name="groupId", referencedColumnName="id")
     * @var Group
     **/
    public $group;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->closed = false;
        $this->comments = 0;
    }

}