<?php
require_once __ROOT__ . '/controllers/Controller.php';
require_once __ROOT__ . '/models/User.php';
require_once __ROOT__ . '/models/UserDAO.php';

use models\{
    User,
    UserDAO,
    DatabaseException
};  


// Démarrage de la session si elle n'est pas déjà démarrée
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Class userUpdateController
 */
class userUpdateController extends Controller
{

    public function get($request)
    {
        if (!isset($_SESSION['email'])) {
            header('Location: /user_connect');
            exit();
        }

        $user = $_SESSION['user'];

        $tableau = $user->__toArrays();
        $this->render('user_update', $tableau);


    }

    public function post($request){
        if (!isset($_SESSION['email'])) {
            header('Location: /user_connect');
            exit();
        }

        $user = new User();
        try {
            $user->init(
                $_SESSION['email'],
                $request['password'],
                $request['firstname'],
                $request['lastname'],
                $request['dateOfBirth'],
                $request['gender'],
                $request['height'],
                $request['weight'],
            );

            $userDAO = UserDAO::getInstance();
            try {
                $userDAO->update($user);
                $_SESSION['user'] = $user;
                // Afficher a l'utilisateur que son compte a bien été créé
                $user = $_SESSION['user'];
                $tableau = $user->__toArrays();
                $tableau["message"] = "Information mise a jours !";
                $this->render('user_update', $tableau);
            } catch (PDOException $e) {
                $this->render('500', ['error' => $e->getMessage()]); // Renvoie une erreur serveur
            }

        } catch (DatabaseException $e) {
            $this->render('user_add_form', ['error' => $e->getMessage()]);
        }
    }
}
