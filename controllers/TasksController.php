<?php
namespace TodoList\Controllers;

use \PhpMvc\ValidateAntiForgeryToken;
use \PhpMvc\SelectListItem;
use \PhpMvc\OutputCache;
use \PhpMvc\Controller;
use \PhpMvc\ViewResult;
use \PhpMvc\Filter;
use \PhpMvc\Model;
use \PhpMvc\View;

use \TodoList\Models\FilesInItems;
use \TodoList\Models\ItemsInTags;
use \TodoList\Models\TaskShow;
use \TodoList\Models\TaskList;
use \TodoList\Models\TaskEdit;
use \TodoList\Models\Group;
use \TodoList\Models\Task;
use \TodoList\Models\User;
use \TodoList\Models\File;
use \TodoList\Models\Tag;

class TasksController extends Controller {

    public function __construct() {
        Filter::add('AccessFilter');

        Model::use('edit', 'edit');

        Model::required('edit', array('task', 'title'));
        Model::required('edit', array('task', 'text'));

        Model::display('edit', array('task', 'title'), 'Title', 'The title of the task.');
        Model::display('edit', array('task', 'text'), 'Details', 'The detailed description of the task (plain).');
        Model::display('edit', 'groupId', 'Group', 'The group to which the task belongs.');
        Model::display('edit', 'tags', 'Tags', 'Comma separated list of tags');

        Model::use('show', 'show');
        Model::display('show', array('text'), 'Comment');

        ValidateAntiForgeryToken::disable('upload');
    }

    public function index(int $page = 1, string $search = null, string $state = 'opened') {
        global $entityManager;
        $result = new TaskList();
        $result->page = ((int)$page > 0) ? $page : 1;
        $result->limit = 30;

        $repository = $entityManager->getRepository('\TodoList\Models\Task');

        $query = $repository->createQueryBuilder('t');
        $query->join('\TodoList\Models\User', 'u');
        $query->where('t.user = :user');

        $query->setParameter('user', new User($this->getSession()['userId']));

        if ($state === 'closed') {
            $query->andWhere('t.closed = 1');
        }
        elseif ($state !== 'all') {
            $query->andWhere('t.closed = 0');
        }

        if (!empty($search)) {
            $query->andWhere('(t.title LIKE :search OR t.text LIKE :search)');
            $query->setParameter('search', '%' . $search . '%');
        }

        $query->orderBy('t.created', 'DESC');

        $query->setFirstResult($result->limit * ($result->page - 1));
        $query->setMaxResults($result->limit);

        $result->items = $query->getQuery()->getResult();

        $result->total = $query->select('COUNT(t) as total')->getQuery()->getSingleScalarResult();

        return $this->view($result);
    }

    public function show($id) {
        global $entityManager;
        $id = (int)$id;

        $task = $entityManager->getRepository('\TodoList\Models\Task')->findOneById($id);

        if ($task == null) {
            throw new \Exception('Task #' . $id . ' not found.');
        }

        $model = new TaskShow(
            $task,
            $this->getFiles($task->id),
            $this->getTags($task->id),
            $this->getComments($task->id)
        );

        return $this->view($model);
    }

    public function edit(int $id = 0, TaskEdit $model = null) {
        global $entityManager;
        $id = (int)$id;

        if ($id > 0) {
            $task = $entityManager->getRepository('\TodoList\Models\Task')->findOneById($id);

            if ($task == null) {
                throw new \Exception('Task #' . $id . ' not found.');
            }

            if ($task->user->id != $this->getSession()['userId']) {
                throw new \Exception('Access is denied. You are not the owner of the task.');
            }

            if (!isset($model)) {
                $model = new TaskEdit($task);
                $model->tags = $this->getTags($task->id);
            }
        }

        if ($this->isPost() && $this->getModelState()->isValid()) {
            if (!isset($task)) {
                $task = new Task();
                $task->user = $entityManager->getRepository('\TodoList\Models\User')->findOneById($this->getSession()['userId']);
            }

            if ($model->groupId > 0) {
                $task->group = $this->getGroup($model->groupId);
            }

            $task->title = $model->task->title;
            $task->text = $model->task->text;

            $entityManager->persist($task);
            $entityManager->flush();

            // files
            $uploadedFiles = !empty($model->uploadedFiles) ? explode(',', $model->uploadedFiles) : null;
            $removedFiles = !empty($model->removedFiles) ? explode(',', $model->removedFiles) : null;

            // remove links to files
            if (!empty($removedFiles)) {
                $query = $entityManager->createQuery('DELETE FROM \TodoList\Models\FilesInItems f WHERE f.itemType = 0 AND f.itemId = :taskId AND f.fileId IN (:fileId)');
                $query->setParameter('taskId', $task->id);
                $query->setParameter('fileId', $removedFiles);
                $query->execute();

                // add links to files
                $uploadedFiles = array_filter($uploadedFiles, function($fid) {
                    return array_search($fid, $removedFiles) !== false;
                });
            }

            if (!empty($uploadedFiles)) {
                $repository = $entityManager->getRepository('\TodoList\Models\FilesInItems')->findOneById($id);

                foreach ($uploadedFiles as $fid) {
                    $filesInItems = new FilesInItems();
                    $filesInItems->itemType = 0;
                    $filesInItems->itemId = $task->id;
                    $filesInItems->create = new \DateTime();
                    $filesInItems->file = $entityManager->getRepository('\TodoList\Models\File')->findOneById($fid);;

                    $entityManager->persist($filesInItems);
                }

                $entityManager->flush();
            }

            // tags
            $tags = !empty($model->tags) ? explode(',', $model->tags) : null;

            if (empty($tags)) {
                $query = $entityManager->createQuery('DELETE FROM \TodoList\Models\ItemsInTags t WHERE t.itemType = 0 AND t.itemId = :taskId');
                $query->setParameter('taskId', $task->id);
                $query->execute();
            }
            else {
                $repositoryLinks = $entityManager->getRepository('\TodoList\Models\ItemsInTags');
                $repositoryTags = $entityManager->getRepository('\TodoList\Models\Tag');

                $query = $repositoryLinks->createQueryBuilder('t');
                $query->where('t.itemType = 0 AND t.itemId = :taskId');
                $query->setParameter('taskId', $task->id);
    
                $currentTags = $query->getQuery()->getResult();
                $currentTagsString = array_map(function($item) {
                    return strtolower($item->value);
                }, $currentTags);

                array_walk($tags, function($item) {
                    return trim(strtolower($item));
                });

                $tags = array_unique($tags);

                foreach ($tags as $tag) {
                    if (($index = array_search($tag, $currentTags)) === false) {
                        if (($tagInDb = $repositoryTags->findOneBy(array('value' => $tag))) === null) {
                            $tagInDb = new Tag();
                            $tagInDb->value = $tag;
                            $entityManager->persist($tagInDb);
                        }

                        $itemsInTags = new ItemsInTags();
                        $itemsInTags->itemType = 0;
                        $itemsInTags->itemId = $task->id;
                        $itemsInTags->tag = $tagInDb;

                        $entityManager->persist($itemsInTags);
                        $entityManager->flush();

                        unset($currentTags[$index]);
                        unset($currentTagsString[$index]);
                    }
                }

                if (!empty($currentTags)) {
                    $query = $entityManager->createQuery('DELETE FROM \TodoList\Models\ItemsInTags t WHERE t.itemType = 0 AND t.itemId = :taskId AND t.tagId IN (:tagId)');
                    $query->setParameter('taskId', $task->id);
                    $query->setParameter('tagId', array_map(function($item) { return $item->tagId; }, $currentTags));
                    $query->execute();
                }
            }

            return $this->redirectToAction('index');
        }

        if (!isset($model)) {
            $model = new TaskEdit();
        }

        $groups = $this->getGroups();
        $model->groups = array();

        $model->groups[] = new SelectListItem($this->getGroup(0)->name, 0);

        foreach ($groups as $group) {
            $model->groups[] = new SelectListItem($group->name, $group->id);
        }

        if (!isset($model->group)) {
            $model->group = $this->getGroup(0);
        }

        return $this->view($model);
    }

    public function tags($search) {
        global $entityManager;

        $repository = $entityManager->getRepository('\TodoList\Models\Tag');

        $query = $repository->createQueryBuilder('t');
        $query->andWhere('t.value LIKE :search');
        $query->setParameter('search', '%' . $search . '%');

        $query->setMaxResults(10);

        $result = $query->getQuery()->getResult();

        return $this->json($result);
    }

    private function getGroups() {
        global $entityManager;
        $repository = $entityManager->getRepository('\TodoList\Models\Group');

        return $repository->findBy(
            array('userId' => $this->getSession()['userId']),
            array(
                'name' => 'asc',
                'id' => 'asc'
            )
        );
    }

    private function getGroup(int $id) {
        global $entityManager;

        if ($id == 0) {
            $group = new Group();
            $group->name = 'No group';

            return $group;
        }
        else {
            return $entityManager->getRepository('\TodoList\Models\Group')->findOneById($id);
        }
    }

    private function getTags($id) {
        global $entityManager;

        $repository = $entityManager->getRepository('\TodoList\Models\ItemsInTags');

        $query = $repository->createQueryBuilder('i');
        $query->join('\TodoList\Models\Tag', 't');
        $query->where('i.itemType = 0 AND i.itemId = :taskId');
        $query->orderBy('t.value', 'ASC');
        $query->setParameter('taskId', $id);

        return implode(',', array_map(function($item) {
            return strtolower($item->tag->value);
        }, $query->getQuery()->getResult()));
    }

    private function getFiles($id) {
        global $entityManager;

        $repository = $entityManager->getRepository('\TodoList\Models\FilesInItems');

        $query = $repository->createQueryBuilder('i');
        $query->join('\TodoList\Models\File', 'f');
        $query->where('i.itemType = 0 AND i.itemId = :taskId');
        $query->orderBy('f.name', 'ASC');
        $query->setParameter('taskId', $id);

        $result = null;

        $filesInItems = $query->getQuery()->getResult();

        if ($filesInItems != null) {
            $result = array();

            foreach ($filesInItems as $fi) {
                $result[] = $fi->file;
            }
        }

        return $result;
    }

    private function getComments($id) {
        global $entityManager;

        $repository = $entityManager->getRepository('\TodoList\Models\Comment');

        $query = $repository->createQueryBuilder('c');
        $query->where('c.itemType = 0 AND c.itemId = :taskId');
        $query->orderBy('c.created', 'ASC');
        $query->setParameter('taskId', $id);

        return $query->getQuery()->getResult();
    }

    public function delete(int $id) {
        global $entityManager;

        $task = $entityManager->getRepository('\TodoList\Models\Task')->find($id);

        if ($task == null) {
            throw new \Exception('Task #' . $id . ' not found.');
        }

        if ($task->userId != $this->getSession()['userId']) {
            throw new \Exception('Access is denied. You are not the owner of the task.');
        }

        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToAction('index');
    }

}