<?php
namespace TodoList\Filters;

use \PhpMvc\ActionFilter;
use \PhpMvc\RedirectResult;
use \PhpMvc\RedirectToActionResult;

class AccessFilter extends ActionFilter {

    /**
     * Called before the action method executes.
     * 
     * @param ActionExecutingContext $actionExecutingContext The action executing context.
     * 
     * @return void
     */
    public function actionExecuting($actionExecutingContext) {
        $httpContext = $actionExecutingContext->getHttpContext();
        $session = $httpContext->getSession();

        if (!empty($session['userId'])) {
            return;
        }

        if ($session['userId'] === false) {
            if (!$actionExecutingContext->controllerNameEquals('home')) {
                $actionExecutingContext->setResult(new RedirectToActionResult('login', 'account'));
            }
            return;
        }

        if (($auth = $httpContext->getRequest()->cookies('auth')) !== null) {
            global $entityManager;

            $userId = substr($auth, 0, strpos($auth, ':'));
            $hash = substr($auth, strpos($auth, ':') + 1);

            $query = $entityManager->createQuery('SELECT u FROM \TodoList\Models\User AS u WHERE u.id = :id');
            $query->setParameter('id', $userId);
            $user = $query->getOneOrNullResult();

            if ($user == null || !password_verify($userId . $user->password . \PhpMvc\AppBuilder::get('cookies_salt'), $hash)) {
                $httpContext->getResponse()->addCookie('auth', '', -1, '/');
                $session['userId'] = false;
                $actionExecutingContext->setResult(new RedirectToActionResult('login', 'account'));
                return;
            }
            else {
                $session['userId'] = $user->id;
                $session['userName'] = $user->username;
                $session['userGravatar'] = $user->gravatar;
                $session['admin'] = $user->admin;
            }

            $actionExecutingContext->setResult(new RedirectResult($httpContext->getRequest()->rawUrl()));
        }
        else {
            $session['userId'] = false;

            if (!$actionExecutingContext->controllerNameEquals('home')) {
                $actionExecutingContext->setResult(new RedirectToActionResult('login', 'account'));
            }
        }
    }

}