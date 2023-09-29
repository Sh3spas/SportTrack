<?php

require_once __ROOT__ . '/controllers/Controller.php';
require_once __ROOT__ . '/models/User.php';
require_once __ROOT__ . '/models/UserDAO.php';

use models\{
    UserDAO,
};

// Démarrage de la session si elle n'est pas déjà démarrée
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Cette classe gère la connexion d'un utilisateur : affichage du formulaire, vérification des données et connexion
 */
class ConnectUserController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     * @param $request
     */
    public function get($request)
    {
        $this->render('user_connect_form', []);
    }

    /**
     * Vérifie les données du formulaire et connecte l'utilisateur
     * @param $request
     */
    public function post($request)
    {
        $userDAO = UserDAO::getInstance();
        try {
            $user = $userDAO->find($request['email']);
            if ($user) {
                if ($user->getPassword() == $request['password']) {

                    $_SESSION['user'] = $user;
                    $_SESSION['email'] = $user->getEmail();
                    $_SESSION['fullname'] = $user->__toString();

                    $this->render('user_connect_valid', ['email' => $request['email']]);
                } else {
                    $this->render('user_connect_form', ['error' => 'Mot de passe incorrecte']);
                }
            } else {
                $this->render('user_connect_form', ['error' => "Cet utilisateur n'existe pas"]);
            }

        } catch (PDOException $e) {
            $this->render('500', ['error' => $e->getMessage()]);
        }
    }

}
