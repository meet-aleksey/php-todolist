<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups_roles")
 */
class GroupRole {

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
     * Group ID.
     * 
     * @ORM\Column(type="integer")
     * @var string
     */
    public $groupId;

    /** 
     * Role name.
     * 
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    public $name;

    /** 
     * Permission. Bit-mask:
     * 0 - none (read-only);
     * 1 - creating new tasks;
     * 2 - editing tasks;
     * 4 - closing tasks;
     * 8 - deleting tasks;
     * 
     * @ORM\Column(type="integer", options={"default": 0})
     * @var boolean
     */
    public $permission;

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
        $this->permissions = 0;
    }

}