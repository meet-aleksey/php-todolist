<?php
namespace TodoList\Filters;

use \PhpMvc\ActionFilter;
use \PhpMvc\RedirectToActionResult;

class UserFilter extends ActionFilter {

    /**
     * Called before the action method executes.
     * 
     * @param ActionExecutingContext $actionExecutingContext The action executing context.
     * 
     * @return void
     */
    public function actionExecuting($actionExecutingContext) {
        if (!empty($actionExecutingContext->getHttpContext()->getSession()['userId'])) {
            $actionExecutingContext->setResult(new RedirectToActionResult('index', 'tasks'));
        }
    }

}