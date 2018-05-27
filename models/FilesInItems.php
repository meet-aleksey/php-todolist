<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="files_in_items")})
 */
class FilesInItems {

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
     * @ORM\ManyToOne(targetEntity="File", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="fileId", referencedColumnName="id")
     * @var File
     **/
    public $file;

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