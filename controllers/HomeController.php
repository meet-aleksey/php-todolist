<?php
namespace TodoList\Controllers;

use \PhpMvc\Controller;
use \PhpMvc\View;
use \PhpMvc\ViewResult;
use \PhpMvc\Filter;

class HomeController extends Controller {

    public function __construct() {
        Filter::add('AccessFilter');
        Filter::add('UserFilter');
    }

    public function index() {
        return $this->view();
    }

}