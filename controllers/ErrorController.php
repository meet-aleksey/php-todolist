<?php
namespace TodoList\Controllers;

use \PhpMvc\Controller;
use \PhpMvc\View;
use \PhpMvc\ViewResult;
use \PhpMvc\OutputCache;
use \PhpMvc\Filter;

class ErrorController extends Controller {

    public function __construct() {
        Filter::add('AccessFilter');
    }

    public function index($code, $message, $url) {
        $code = intval($code);

        if ($code < 100 || $code > 599) {
            $code = 500;
        }

        $this->getResponse()->setStatusCode($code);

        $this->setData('code', $code);
        $this->setData('message', $message);
        $this->setData('url', $url);

        return $this->view();
    }

}