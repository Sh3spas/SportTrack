<?php

require_once __ROOT__ . '/controllers/Controller.php';
require_once __ROOT__ . '/models/Activity.php';
require_once __ROOT__ . '/models/ActivityDAO.php';
require_once __ROOT__ . '/models/ActivityEntry.php';
require_once __ROOT__ . '/models/ActivityEntryDAO.php';
require_once __ROOT__ . '/functions/CalculDistanceImpl.php';
require_once __ROOT__ . '/functions/CalculHeartRate.php';

use functions\{
    CalculHeartRate,
    CalculDistanceImpl
};



use models\ {
    Activity,
    ActivityDAO,
    ActivityEntry,
    ActivityEntryDAO
};

// Démarrage de la session si elle n'est pas déjà démarrée
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Cette classe gère l'ajout d'une activité : calcul de la distance, insertion dans la base de donnée,...
 */
class UploadActivityController extends Controller
{
    /**
     * Gère la requête GET.
     * Elle affiche le formulaire d'ajout d'une activité.
     * @param array $request tableau associatif contenant la requête HTTP.
     */
    public function get($request) : void
    {
        if (!isset($_SESSION['email'])) {
            header('Location: /user_connect');
            exit();
        }
        $this->render('activity_add_form', []);
    }

    /**
     * Gère la requête POST.
     * 
     * Elle récupère le fichier JSON, le décode, calcule la distance totale du trajet,
     * la vitesse moyenne, la durée, la fréquence cardiaque min max et moyenne.
     * Elle créé les objets Activity et ActivityEntry et les insère dans la base de données.
     * 
     * @param mixed $request
     * @return void
     */
    public function post($request) : void
    {
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

            $uploadedFile = $_FILES['file']['tmp_name'];
            $fichierContent = file_get_contents($uploadedFile);

            if ($fichierContent !== false) {

                $tableau = json_decode($fichierContent, true);

                if ($tableau !== null) {

                    $calculDistanceImpl = new CalculDistanceImpl();
                    $distanceTotale = $calculDistanceImpl->CalculDistanceTrajet($tableau['data']);

                    $hrCalc = new CalculHeartRate();
                    $hr = $hrCalc->CalculHeartRateAll($tableau['data']);

                    // Calcul de la vitesse moyenne et de la durée de l'activité
                    $heureDebut = $tableau['data'][0]['time'];
                    $heureFin = $tableau['data'][count($tableau['data']) - 1]['time'];
                    $duree = strtotime($heureFin) - strtotime($heureDebut);

                    // Pour afficher la durée au format HH:MM:SS
                    $dureeFormatee = gmdate("H:i:s", $duree);
                    //$vitesseMoy = round($distanceTotale / ($duree / 3600), 2);

                    // Création des objets Activity et ActivityEntry
                    $activity = new Activity();
                    $activity->init(
                        $request['filename'],
                        $tableau['activity']['date'],
                        $heureDebut,
                        $dureeFormatee,
                        $distanceTotale,
                        $hr[0],
                        $hr[1],
                        $hr[2],
                        $_SESSION['email']
                    );

                    $activityDAO = ActivityDAO::getInstance();
                    $activityDAO->insert($activity);

                    $activityEntryDAO = ActivityEntryDAO::getInstance();

                    // Création et insertion de chaque ActivityEntry
                    for ($i = 0; $i < count($tableau['data']); $i++) {
                        $activityEntry = new ActivityEntry();
                        $activityEntry->init(
                            $tableau['data'][$i]['time'],
                            $tableau['data'][$i]['cardio_frequency'],
                            $tableau['data'][$i]['latitude'],
                            $tableau['data'][$i]['longitude'],
                            $tableau['data'][$i]['altitude'],
                            $activity->getIdAct()
                        );

                        $activityEntryDAO->insert($activityEntry);
                    }

                    header('Location: /activity_list');


                } else {
                    // Gestion de l'erreur de décodage JSON
                    echo "Erreur lors du décodage du contenu JSON.";
                }
            } else {
                // Gestion de l'erreur de lecture du fichier
                echo "Erreur lors de la lecture du fichier.";
            }
        } else {
            // Gestion de l'erreur de téléchargement du fichier
            echo "Erreur lors du téléchargement du fichier.";
        }
    }
}
