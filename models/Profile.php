<?php
namespace TodoList\Models;

class Profile {

    /** 
     * User name.
     * 
     * @var string
     */
    public $username;

    /** 
     * Email.
     * 
     * @var string
     */
    public $email;

    /** 
     * Password to change.
     * 
     * @var string
     */
    public $newPassword;

    /** 
     * Confirm password.
     * 
     * @var string
     */
    public $confirmPassword;

}