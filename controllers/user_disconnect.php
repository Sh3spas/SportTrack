<?php
require_once __ROOT__ . '/controllers/Controller.php';
require_once __ROOT__ . '/models/User.php';
require_once __ROOT__ . '/models/UserDAO.php';

// Démarrage de la session si elle n'est pas déjà démarrée
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Cette classe gère la déconnexion d'un utilisateur : détruit la session et supprime les variables de session
 */
class DisconnectUserController extends Controller
{

    /**
     * Déconnecte l'utilisateur
     * @param $request
     */
    public function get($request)
    {
        if (!isset($_SESSION['email'])) {
            header('Location: /user_connect');
            exit();
        }
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            unset($_SESSION['email']);
            unset($_SESSION['fullname']);
            session_destroy();
        }
        $this->render('user_disconnect', []);
    }
}
