<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Group {

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
     * Owner ID.
     * 
     * @ORM\Column(type="integer")
     * @var int
     */
    public $userId;

    /** 
     * Group name.
     * 
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    public $name;

    /** 
     * Comment.
     * 
     * @ORM\Column(type="string", length=500)
     * @var string
     */
    public $comment;

    /** 
     * Tasks count.
     * 
     * @ORM\Column(type="integer", options={"default": 0})
     * @var int
     */
    public $tasks;

    /** 
     * Date created.
     * 
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    public $created;

    public function __construct()
    {
        $this->tasks = 0;
        $this->created = new \DateTime();
    }

}