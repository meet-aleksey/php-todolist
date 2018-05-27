<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comments")
 */
class Comment {

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
     * Item type. 0 - task (default).
     * 
     * @ORM\Column(type="integer", options={"default": 0})
     * @var int
     */
    public $itemType;

    /**
     * Item ID.
     * 
     * @ORM\Column(type="integer")
     * @var int
     */
    public $itemId;

    /** 
     * Text of the comment.
     * 
     * @ORM\Column(type="text")
     * @var string
     */
    public $text;

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

    public function __construct()
    {
        $this->itemType = 0;
        $this->created = new \DateTime();
    }

}