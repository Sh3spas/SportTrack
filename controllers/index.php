<?php
require_once __ROOT__ . '/controllers/Controller.php';

// Démarrage de la session si elle n'est pas déjà démarrée
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Cette classe gère l'affichage de la page d'accueil.
 */
class IndexController extends Controller
{
    public function get($request)
    {
        $this->render('index', []);
    }
}
