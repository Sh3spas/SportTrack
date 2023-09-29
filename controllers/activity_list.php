<?php
require_once __ROOT__ . '/controllers/Controller.php';
require_once __ROOT__ . '/models/ActivityDAO.php';
require_once __ROOT__ . '/models/Activity.php';

use models\ActivityDAO;

// Démarrage de la session si elle n'est pas déjà démarrée
if (!isset($_SESSION)) {
    session_start();
}

class ListActivityController extends Controller
{

    public function get($request)
    {
        if (!isset($_SESSION['email'])) {
            header('Location: /user_connect');
            exit();
        }
        $useremail = $_SESSION['email'];
        $activityDAO = ActivityDAO::getInstance();

        $activities = $activityDAO->findByUser($useremail);

        $tableActivity=[];

        foreach ($activities as $activity){
            $tableActivity[] = $activity->__toArrays();
        }
        

        $this->render('activity_list', $tableActivity);
    }
}
