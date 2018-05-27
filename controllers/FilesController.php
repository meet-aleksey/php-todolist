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

use \TodoList\Models\File;
use \TodoList\Models\User;

class FilesController extends Controller {

    public function __construct() {
        Filter::add('ExceptionToJson');
        Filter::add('AccessFilter');

        ValidateAntiForgeryToken::disable();
    }

    public function upload() {
        global $entityManager;

        $user = $entityManager->getRepository('\TodoList\Models\User')->findOneById($this->getSession()['userId']);

        if ($user == null) {
            throw new \Exception('User not found.');
        }

        $result = array();
        $files = $this->getRequest()->files();

        if (!is_dir(PHPMVC_UPLOAD_PATH)) {
            mkdir(PHPMVC_UPLOAD_PATH, 0775, true);
        }

        for ($i = 0, $count = count($files['files']['name']); $i < $count; ++$i) {
            $extension = pathinfo($files['files']['name'][$i], \PATHINFO_EXTENSION);
            $name = pathinfo($files['files']['name'][$i], \PATHINFO_FILENAME);
            $filesCounter = 1;

            $path = PHPMVC_UPLOAD_PATH . basename($files['files']['name'][$i]);

            while (file_exists($path)) {
                $path = PHPMVC_UPLOAD_PATH . $name . '.' . $filesCounter . '.' . $extension;
                $filesCounter++;
            }

            if (!move_uploaded_file($files['files']['tmp_name'][$i], $path)) {
                throw new \Exception('The file "' . basename($files['files']['name'][$i]) . '" could not be uploaded.');
            }

            $file = new File();
            $file->user = $user;
            $file->name = basename($path);
            $file->path = $path;
            $file->size = filesize($path);
            $file->md5 = md5_file($path);
            $file->type = $files['files']['type'][$i];

            $entityManager->persist($file);
            $entityManager->flush();

            $result[] = array(
                "id" => $file->id,
                "name" => basename($path)
            );
        }

        return $this->json($result);
    }

    public function delete($id) {
        global $entityManager;
        $id = (int)$id;

        if ($id <= 0) {
            throw new \Exception('The file ID is not specified.');
        }

        $file = $entityManager->getRepository('\TodoList\Models\File')->findOneById($id);

        if ($file == null) {
            throw new \Exception('File #' . $id . ' not found.');
        }

        if ($file->user->id != $this->getSession()['userId']) {
            throw new \Exception('Access is denied. You are not the owner of the file.');
        }

        if (file_exists($file->path)) {
            unlink($file->path);
        }

        $entityManager->remove($file);
        $entityManager->flush();

        return $this->json(true);
    }

}