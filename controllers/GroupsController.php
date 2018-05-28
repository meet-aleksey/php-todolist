<?php
namespace TodoList\Controllers;

use \PhpMvc\Controller;
use \PhpMvc\View;
use \PhpMvc\ViewResult;
use \PhpMvc\OutputCache;
use \PhpMvc\Filter;
use \PhpMvc\Model;

use \TodoList\Models\GroupList;
use \TodoList\Models\Group;

class GroupsController extends Controller {

    public function __construct() {
        Filter::add('AccessFilter');

        Model::use('edit', 'edit');
        Model::required('edit', 'name');
        Model::display('edit', 'name', 'Group name', 'Convenient for you the name of the group.');
        Model::display('edit', 'comment', 'Comment', 'Comment to group.');
    }

    /**
     * @param int $page
     */
    public function index(int $page = 1) {
        global $entityManager;
        $result = new GroupList();
        $result->page = ((int)$page > 0) ? $page : 1;
        $result->limit = 30;

        $repository = $entityManager->getRepository('\TodoList\Models\Group');

        $result->items = $repository->findBy(
            array('userId' => $this->getSession()['userId']),
            array(
                'name' => 'asc',
                'id' => 'asc'
            ),
            $result->limit,
            $result->limit * ($result->page - 1) 
        );

        $result->total = $repository->count(array('userId' => $this->getSession()['userId']));

        return $this->view($result);
    }

    public function edit(int $id = 0, \TodoList\Models\Group $model = null) {
        global $entityManager;
        $id = (int)$id;

        if ($id > 0) {
            $group = $entityManager->getRepository('\TodoList\Models\Group')->findOneById($id);

            if ($group == null) {
                throw new \Exception('Group not found.');
            }

            if ($group->userId != $this->getSession()['userId']) {
                throw new \Exception('Access is denied. You are not the owner of the group.');
            }

            if (!isset($model)) {
                $model = $group;
            }
        }

        if ($this->isPost() && $this->getModelState()->isValid()) {
            if (!isset($group)) {
                $group = new \TodoList\Models\Group();
                $group->userId = $this->getSession()['userId'];
            }

            $group->name = $model->name;
            $group->comment = $model->comment;

            $entityManager->persist($group);
            $entityManager->flush();

            return $this->redirectToAction('index');
        }

        if (!isset($model)) {
            $model = new \TodoList\Models\Group();
        }

        return $this->view($model);
    }

    public function delete(int $id) {
        global $entityManager;

        $group = $entityManager->getRepository('\TodoList\Models\Group')->find($id);

        if ($group == null) {
            throw new \Exception('Group not found.');
        }

        if ($group->userId != $this->getSession()['userId']) {
            throw new \Exception('Access is denied. You are not the owner of the group.');
        }

        $entityManager->remove($group);
        $entityManager->flush();

        return $this->redirectToAction('index');
    }

}