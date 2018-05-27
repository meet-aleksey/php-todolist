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

use \TodoList\Models\Comment;
use \TodoList\Models\User;

class CommentsController extends Controller {

    public function __construct() {
        // Filter::add('add', 'ExceptionToJson');
        Filter::add('AccessFilter');
    }

    public function add(int $id, Comment $model = null, string $close = null) {
        global $entityManager;
        $id = (int)$id;

        if ($id <= 0) {
            throw new \Exception('Task id is requred.');
        }

        $task = $entityManager->getRepository('\TodoList\Models\Task')->findOneById($id);

        if ($task == null) {
            throw new \Exception('Task #' . $id . ' not found.');
        }

        if (!empty($model->text)) {
            $comment = new Comment();
            $comment->user = $entityManager->getRepository('\TodoList\Models\User')->findOneById($this->getSession()['userId']);
            $comment->text = $model->text;
            $comment->itemType = 0;
            $comment->itemId = $id;

            $entityManager->persist($comment);

            if ($close !== null) {
                $task->closed = ($close === 'true');
            }

            $task->comments++;

            $entityManager->persist($task);

            $entityManager->flush();

            return $this->view('~/views/tasks/comment.php', $comment);
        }
        else {
            if ($close !== null) {
                $task->closed = ($close === 'true');
                $entityManager->persist($task);
                $entityManager->flush();
            }

            return $this->content('', 'text/html');
        }

        // return $this->json(array('id' => $comment->id));
    }

}