<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="items_in_tags",uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"itemType","itemId","tagId"})})
 */
class ItemsInTags {

    /**
     * Item type. 0 - task (default).
     * 
     * @ORM\Id
     * @ORM\Column(type="integer", options={"default": 0})
     * @var int
     */
    public $itemType;

    /**
     * Item ID.
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @var int
     */
    public $itemId;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Tag", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="tagId", referencedColumnName="id")
     * @var Tag
     **/
    public $tag;

    /** 
     * Date created.
     * 
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    public $created;

    public function __construct()
    {
        $this->itemType = 0;
        $this->created = new \DateTime();
    }

}