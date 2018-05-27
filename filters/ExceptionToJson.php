<?php
namespace TodoList\Filters;

use \PhpMvc\ActionFilter;
use \PhpMvc\JsonResult;

class ExceptionToJson extends ActionFilter {

    /**
     * Called when an exception occurs.
     * 
     * @param ExceptionContext $exceptionContext The context of action exception.
     * 
     * @return void
     */
    public function exception($exceptionContext) {
        $exceptionContext->getHttpContext()->getResponse()->setStatusCode(500);
        $exceptionContext->setResult(new JsonResult(array('message' => $exceptionContext->getException()->getMessage())));
    }

}