<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users",uniqueConstraints={@ORM\UniqueConstraint(name="uniqueName", columns={"username"}),@ORM\UniqueConstraint(name="uniqueEmail", columns={"email"})})
 */
class User {

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
     * User name.
     * 
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    public $username;

    /** 
     * User email address.
     * 
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    public $email;

    /** 
     * User password.
     * 
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    public $password;

    /** 
     * Md5 hash of email.
     * 
     * @ORM\Column(type="string", length=32, nullable=true)
     * @var string
     */
    public $gravatar;

    /** 
     * Is admin.
     * 
     * @ORM\Column(type="boolean", options={"default": false})
     * @var boolean
     */
    public $admin;

    /** 
     * Date created.
     * 
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    public $created;

    public function __construct($id = 0)
    {
        $this->id = $id;
        $this->created = new \DateTime();
        $this->admin = false;
        $this->gravatar = '';
    }

}