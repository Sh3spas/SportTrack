<?php
require_once __ROOT__ . '/controllers/Controller.php';

// Démarrage de la session si elle n'est pas déjà démarrée
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Class AProposController
 */
class AProposController extends Controller
{

    public function get($request)
    {
        $this->render('about_us', ["name" => "LE CHANU Simon et GUERNY Baptiste"]);
    }
}
