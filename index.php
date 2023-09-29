<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('__ROOT__', dirname(__FILE__));

// Fichier de configuration
require_once __ROOT__ . '/config.php';

// ApplicationController
require_once CONTROLLERS_DIR . '/ApplicationController.php';

// Router
ApplicationController::getInstance()->addRoute('/', CONTROLLERS_DIR . '/index.php');
ApplicationController::getInstance()->addRoute('user_add', CONTROLLERS_DIR . '/user_add.php');
ApplicationController::getInstance()->addRoute('about_us', CONTROLLERS_DIR . '/about_us.php');
ApplicationController::getInstance()->addRoute('user_connect', CONTROLLERS_DIR . '/user_connect.php');
ApplicationController::getInstance()->addRoute('user_disconnect', CONTROLLERS_DIR . '/user_disconnect.php');
ApplicationController::getInstance()->addRoute('activity_add', CONTROLLERS_DIR . '/activity_add.php');
ApplicationController::getInstance()->addRoute('activity_list', CONTROLLERS_DIR . '/activity_list.php');
ApplicationController::getInstance()->addRoute('update', CONTROLLERS_DIR . '/user_update.php');

// Exécute la route en chargant le controlleur qui se chargera d'afficher la vue
// Si la route n'existe pas, on affiche la page 404.
ApplicationController::getInstance()->process();


