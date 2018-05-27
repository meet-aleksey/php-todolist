<?php
require_once __DIR__ . '/vendor/php-mvc-project/php-mvc/src/index.php';
require_once __DIR__ . '/config/bootstrap.php';

use PhpMvc\AppBuilder;
use PhpMvc\FileCacheProvider;

// config
AppBuilder::useNamespace('TodoList');
// AppBuilder::useCache(new FileCacheProvider());
AppBuilder::useSession();

// custom handlers
AppBuilder::use(function($appContext) {
    $appContext->addPreSend(function(PhpMvc\ActionContext $actionContext) {
        if (stripos($actionContext->getHttpContext()->getRequest()->rawUrl(), '/error/') === false) {
            $response = $actionContext->getHttpContext()->getResponse();
            $statusCode = $response->getStatusCode();
    
            if ($statusCode === 404) {
                $response->addHeader(
                    'Location', 
                    '/error/404?' . http_build_query(array('url' => $actionContext->getHttpContext()->getRequest()->rawUrl()))
                );
            }
        }
    });

    $appContext->addErrorHandler(function(PhpMvc\ErrorHandlerEventArgs $errorHandlerEventArgs) use ($appContext) {
        $errorHandlerEventArgs->setHandled(true);

        $httpContext = $appContext->getConfig('httpContext');
        $response = $httpContext->getResponse();

        $response->addHeader(
            'Location', 
            '/error/500?' .
            http_build_query(array(
                'message' => $errorHandlerEventArgs->getMessage(),
                'url' => $httpContext->getRequest()->rawUrl())
            )
        );

        $response->end();
    });
});

// routes
AppBuilder::routes(function($routes) {
    $routes->ignore('favicon.ico');
    $routes->ignore('content/{*file}');
    $routes->ignore('{*allphp}', array('allphp' => '.*\.php'));

    $routes->add('error', 'error/{code}', array(
        'controller' => 'error',
        'action' => 'index'
    ));

    $routes->add('editGroup', 'groups/edit/{id}', array(
        'controller' => 'groups',
        'action' => 'edit'
    ), array(
        'id' => '\d+'
    ));

    $routes->add('newGroup', 'groups/new', array(
        'controller' => 'groups',
        'action' => 'edit'
    ));

    $routes->add('newTask', 'tasks/new', array(
        'controller' => 'tasks',
        'action' => 'edit'
    ));

    $routes->add('default', '{controller=Home}/{action=index}/{id?}');
});

// custom settings
AppBuilder::set('cookies_salt', 'hmF06iNcGw7AI7EyieqOe37uvj0Jp2Ho');

// build app
AppBuilder::build();