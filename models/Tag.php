<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tags")
 */
class Tag {

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
     * Group name.
     * 
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    public $value;

    /** 
     * Date created.
     * 
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    public $created;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

}