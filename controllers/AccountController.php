<?php
namespace TodoList\Controllers;

use \PhpMvc\Controller as Controller;
use \PhpMvc\Model as Model;
use \PhpMvc\Filter as Filter;

class AccountController extends Controller {

    public function __construct() {
        Filter::add('login', 'UserFilter');
        Filter::add('join', 'UserFilter');
        Filter::add('profile', 'AccessFilter');

        Model::required('login', 'username');
        Model::required('login', 'password');

        Model::display('login', 'username', 'Username or Email', 'The username or email that you used when registering on the site.');
        Model::display('login', 'password', 'Password', 'The password you used when registering on the site.');

        Model::required('join', 'username');
        Model::required('join', 'email');
        Model::required('join', 'password');
        Model::required('join', 'confirmPassword');

        Model::display('join', 'username', 'Username', 'The name will be displayed on the site.');
        Model::display('join', 'email', 'Email', 'We are for some reason collecting the address database. Help us in this. We promise you not to send any letters, even information about your registration on the site.');
        Model::display('join', 'password', 'Password', 'The password will be securely hashed and sprinkled with salt.');
        Model::display('join', 'confirmPassword', 'Confirm password', 'Confirm the password to prevent misprints.');

        Model::compare('join', 'confirmPassword', 'password');
        Model::validation('join', 'email', function($value) {
            return filter_var($value, \FILTER_VALIDATE_EMAIL);
        });

        Model::required('profile', 'username');
        Model::required('profile', 'email');
        Model::compare('profile', 'confirmPassword', 'newPassword');
        Model::validation('profile', 'email', function($value) {
            return filter_var($value, \FILTER_VALIDATE_EMAIL);
        });

        Model::display('profile', 'username', 'Username');
        Model::display('profile', 'email', 'Email');
        Model::display('profile', 'newPassword', 'Change password', 'You can change the password by specifying a new password.');
        Model::display('profile', 'confirmPassword', 'Confirm password');
    }

    /**
     * @param \TodoList\Models\LoginForm $model
     */
    public function login($model) {
        if ($this->isPost() && $this->getModelState()->isValid()) {
            global $entityManager;

            $query = $entityManager->createQuery('SELECT u FROM \TodoList\Models\User AS u WHERE u.username = :username OR u.email = :username');
            $query->setParameter('username', $model->username);
            $user = $query->getOneOrNullResult();

            if ($user == null) {
                throw new \Exception('User not found.');
            }

            if (!password_verify($model->password, $user->password)) {
                throw new \Exception('Invalid password.');
            }

            $this->createSession($user, $model->rememberMe);

            return $this->redirectToAction('index', 'tasks');
        }

        if (empty($model)) {
            $model = new \TodoList\Models\LoginForm();
            $model->rememberMe = true;
        }

        return $this->view($model);
    }

    /**
     * @param \TodoList\Models\JoinForm $model
     */
    public function join($model) {
        if ($this->isPost() && $this->getModelState()->isValid()) {
            global $entityManager;

            $user = new \TodoList\Models\User();
            $user->username = trim($model->username);
            $user->email = trim($model->email);
            $user->password = password_hash($model->password, \PASSWORD_BCRYPT);
            $user->gravatar = md5(strtolower($user->email));

            $entityManager->persist($user);
            $entityManager->flush();

            if ($user->id == 0) {
                throw new \Exception('Could not create user. Please try again.');
            }

            $this->createSession($user, true);

            return $this->redirectToAction('index', 'tasks');
        }

        if (empty($model)) {
            $model = new \TodoList\Models\JoinForm();
        }

        return $this->view($model);
    }

    public function profile($model = null) {
        global $entityManager;
        $query = $entityManager->createQuery('SELECT u FROM \TodoList\Models\User AS u WHERE u.id = :id');
        $query->setParameter('id', $this->getSession()['userId']);
        $user = $query->getOneOrNullResult();

        if ($user == null) {
            return $this->redirectToAction('login');
        }

        if ($this->isPost() && $this->getModelState()->isValid()) {
            $user->username = $model->username;
            $user->email = $model->email;

            if (!empty($model->newPassword)) {
                $user->password = password_hash($model->newPassword, \PASSWORD_BCRYPT);
                $user->gravatar = md5(strtolower($user->email));
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->createSession($user, true);
        }

        if (empty($model)) {
            $model = $user;
        }

        return $this->view($model);
    }

    public function exit() {
        $this->getSession()->clear();
        $this->getResponse()->addCookie('auth', '', -1, '/');
        return $this->redirectToAction('index', 'home');
    }

    private function createSession($user, $remeber = false) {
        $cookiesValue = $user->id . ':' .password_hash($user->id . $user->password . \PhpMvc\AppBuilder::get('cookies_salt'), \PASSWORD_BCRYPT);

        if ($remeber) {
            $this->getResponse()->addCookie('auth', $cookiesValue, time() + 60 * 60 * 24 * 365, '/');
        }

        $session = $this->getSession();

        $session['userId'] = $user->id;
        $session['userName'] = $user->username;
        $session['userGravatar'] = $user->gravatar;
        $session['admin'] = $user->admin;
    }

}