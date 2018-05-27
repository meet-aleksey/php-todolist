<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users_in_groups",uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"userId","groupId"})})
 */
class UserInGroup {

    /** 
     * User ID.
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @var string
     */
    public $userId;

    /** 
     * Group ID.
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @var string
     */
    public $groupId;

    /** 
     * User role in group.
     * 
     * @ORM\Column(type="integer", options={"default": 0})
     * @var int
     */
    public $role;

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
        $this->role = 0;
    }

}