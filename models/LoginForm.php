<?php
namespace TodoList\Models;

class LoginForm {

    /** 
     * User name.
     * 
     * @var string
     */
    public $username;

    /** 
     * User password.
     * 
     * @var string
     */
    public $password;

    /** 
     * Indicates the need to use cookies.
     * 
     * @var bool
     */
    public $rememberMe;

}