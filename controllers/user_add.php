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
 * Cette classe gère l'ajout d'un utilisateur : affichage du formulaire et insertion dans la base de données
 */
class AddUserController extends Controller
{
    /**
     * Gère la requête GET.
     * Elle affiche le formulaire d'ajout d'un utilisateur.
     * @param array $request tableau associatif contenant la requête HTTP.
     */
    public function get($request)
    {
        $this->render('user_add_form', []);
    }

    /**
     * Gère la requête POST.
     * Elle récupère les données du formulaire, créé un objet User et l'insère dans la base de données.
     * @param mixed $request
     * @return void
     */
    public function post($request)
    {
        $user = new User();
        try {
            $user->init(
                $request['email'],
                $request['password'],
                $request['firstname'],
                $request['lastname'],
                $request['dateOfBirth'],
                $request['gender'],
                $request['size'],
                $request['weight'],
            );

            $userDAO = UserDAO::getInstance();
            try {
                $userDAO->insert($user);
                // Afficher a l'utilisateur que son compte a bien été créé
                $this->render('user_add_valid', ['email' => $request['email']]);
            } catch (PDOException $e) {
                $this->render('500', ['error' => $e->getMessage()]); // Renvoie une erreur serveur
            }

        } catch (DatabaseException $e) {
            $this->render('user_add_form', ['error' => $e->getMessage()]);
        }
    }
}
