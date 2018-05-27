<?php
namespace TodoList\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="files")
 */
class File {

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
     * File name.
     * 
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    public $name;

    /** 
     * File path.
     * 
     * @ORM\Column(type="string", length=500)
     * @var string
     */
    public $path;

    /** 
     * Content type.
     * 
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    public $type;

    /** 
     * File size, in bytes.
     * 
     * @ORM\Column(type="integer")
     * @var int
     */
    public $size;

    /** 
     * MD5 hash of the file.
     * 
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    public $md5;

    /** 
     * Date created.
     * 
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    public $created;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * @var User
     **/
    public $user;

    public function __construct($id = 0)
    {
        $this->id = $id;
        $this->created = new \DateTime();
    }

}