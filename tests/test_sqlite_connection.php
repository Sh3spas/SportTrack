<?php
// Pour une meilleur cohérence des fichiers de test, je propose de les nommer tous en test_*.php
// et de les mettre dans un dossier tests/ donc le fichier demandé sqlite_connection_test.php est 
// renommé test_sqlite_connection.php

define('__ROOT__', dirname(dirname(__FILE__)));

// Require all the necessary files
foreach (glob("models/*.php") as $filename) {
    require_once $filename;
}

// Use the necessary classes
use models\{
    SqliteConnection, User, UserDAO, Activity, ActivityDAO,
    ActivityEntry, ActivityEntryDAO, DatabaseException
};

// Test of the database connection
try {
    $dbConnection = SqliteConnection::getInstance()->getConnection();
    echo "Database connection successful!\n";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

/**
 * Test the UserDAO class
 * @return void
 */
function testUserDAO() : void
{
    // Creating a test user
    $user = new User();
    $user->init('simonlechanu@gmail.com', 'password123', 'Baptiste', 'Guerny', '2004-14-9', 'M', 175.0, 65.0);

    // Getting the DAO instance for the user table
    $userDAO = UserDAO::getInstance();

    echo "[+] Testing the insertion of a user\n";
    try {
        $userDAO->insert($user);
        echo "[-] User insertion succeeded\n";
    } catch (Exception $e) {
        echo "[!] User insertion failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the insertion of a user with an existing email\n";
    try {
        $userDAO->insert($user); // Try to insert the same user
        echo "[!] User insertion succeeded but it shouldn't have\n";
    } catch (DatabaseException $e) {
        echo "[-] User insertion failed as expected: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the update of a user\n";
    $user->setWeight(70.0);
    $user->setDateOfBirth('2004-10-12');

    try {
        $userDAO->update($user);
        echo "[-] User update succeeded\n";
    } catch (Exception $e) {
        echo "[!] User update failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the update of a user who doesn't exist\n";
    $user2 = new User();
    $user2->init('baptisteguerny@gmail.com', 'password123', 'Baptiste', 'Guerny', '2004-10-12', 'M', 175.0, 65.0);

    try {
        $userDAO->update($user2);
        echo "[!] User update succeeded but it shouldn't have\n";
    } catch (PDOException $e) {
        echo "[-] User update failed as expected: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the selection of all users\n";
    try {
        $users = $userDAO->findAll();
        print_r($users);
    } catch (Exception $e) {
        echo "[!] Query failed : " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the deletion of a user by email\n";
    try {
        $userDAO->delete($user->getEmail());
        echo "[-] User deletion succeeded\n";
    } catch (Exception $e) {
        echo "[!] User deletion failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the deletion of a user who doesn't exist\n";
    try {
        $userDAO->delete($user->getEmail());
        echo "[!] User deletion succeeded but it shouldn't have\n";
    } catch (PDOException $e) {
        echo "[-] User deletion failed as expected: " . $e->getMessage() . "\n";
    }
}

/**
 * Test the ActivityDAO class
 * @return void
 */
function testActivityDAO(): void
{
    // Creating a test user
    $user = new User();
    $user->init('simonlechanu@gmail.com', 'password123', 'Baptiste', 'Guerny', '2004-14-9', 'M', 175.0, 65.0);

    // Creating a test activity
    $activity = new Activity();
    $activity->init('Running', '2023-09-13', strtotime('2023-09-13 10:00:00'), 3600, 10.5, 120, 160, 140, 'simonlechanu@gmail.com');

    // Getting the DAO instances
    $userDAO = UserDAO::getInstance();
    $activityDAO = ActivityDAO::getInstance();

    echo "[+] Testing the insertion of an activity\n";
    try {
        // Insert the user first
        $userDAO->insert($user);
        // Set the user ID for the activity
        $activity->setEmail($user->getEmail());
        // Insert the activity
        $activityDAO->insert($activity);
        echo "[-] Activity insertion succeeded\n";
    } catch (Exception $e) {
        echo "[!] Activity insertion failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the selection of all activities for a user\n";
    try {
        $activities = $activityDAO->findByUser($user->getEmail());
        print_r($activities);
    } catch (Exception $e) {
        echo "[!] Query failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the update of an activity\n";
    $activity->setName('Jogging');
    $activity->setDistance(8.5);

    try {
        $activityDAO->update($activity);
        echo "[-] Activity update succeeded\n";
    } catch (Exception $e) {
        echo "[!] Activity update failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the update of an activity that doesn't exist\n";
    $activity2 = new Activity();
    $activity2->init('Hiking', '2023-09-14', strtotime('2023-09-14 14:00:00'), 2400, 15.0, 110, 170, 140, 'nonexistentuser@gmail.com');

    try {
        $activityDAO->update($activity2);
        echo "[!] Activity update succeeded but it shouldn't have\n";
    } catch (PDOException $e) {
        echo "[-] Activity update failed as expected: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the deletion of an activity\n";
    try {
        $activityDAO->delete($activity);
        echo "[-] Activity deletion succeeded\n";
    } catch (Exception $e) {
        echo "[!] Activity deletion failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the deletion of an activity that doesn't exist\n";
    try {
        $activityDAO->delete($activity);
        echo "[!] Activity deletion succeeded but it shouldn't have\n";
    } catch (PDOException $e) {
        echo "[-] Activity deletion failed as expected: " . $e->getMessage() . "\n";
    }

    // Supression de l'utilisateur de test pour "nettoyer" la base de données
    $userDAO->delete($user->getEmail());
}

/**
 * Test the ActivityEntryDAO class
 * @return void
 */
function testActivityEntryDAO() : void
{
    // Creating a test user
    $user = new User();
    $user->init('simonlechanu@gmail.com', 'password123', 'Baptiste', 'Guerny', '2004-14-9', 'M', 175.0, 65.0);

    // Creating a test activity
    $activity = new Activity();
    $activity->init('Running', '2023-09-13', strtotime('2023-09-13 10:00:00'), 3600, 10.5, 120, 160, 140, 'simonlechanu@gmail.com');

    // Creating a test activity entry
    $activityEntry = new ActivityEntry();
    $activityEntry->init(strtotime('2023-09-13 10:30:00'), 130, 40.7128, -74.0060, 10.0, 1);

    // Getting the DAO instances
    $userDAO = UserDAO::getInstance();
    $activityDAO = ActivityDAO::getInstance();
    $activityEntryDAO = ActivityEntryDAO::getInstance();

    echo "[+] Testing the insertion of an activity entry\n";
    try {
        // Insert the user first
        $userDAO->insert($user);
        // Set the user ID for the activity
        $activity->setEmail($user->getEmail());
        // Insert the activity
        $activityDAO->insert($activity);
        // Set the activity ID for the activity entry
        $activityEntry->setIdAct($activity->getIdAct());
        // Insert the activity entry
        $activityEntryDAO->insert($activityEntry);
        echo "[-] Activity Entry insertion succeeded\n";
    } catch (Exception $e) {
        echo "[!] Activity Entry insertion failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the selection of all activity entries for an activity\n";
    try {
        $activityEntries = $activityEntryDAO->findAllByIdAct($activity->getIdAct());
        print_r($activityEntries);
    } catch (Exception $e) {
        echo "[!] Query failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the deletion of an activity entry\n";
    try {
        $activityEntryDAO->delete($activityEntry);
        echo "[-] Activity Entry deletion succeeded\n";
    } catch (Exception $e) {
        echo "[!] Activity Entry deletion failed: " . $e->getMessage() . "\n";
    }

    echo "[+] Testing the deletion of an activity entry that doesn't exist\n";
    try {
        $activityEntryDAO->delete($activityEntry);
        echo "[!] Activity Entry deletion succeeded but it shouldn't have\n";
    } catch (PDOException $e) {
        echo "[-] Activity Entry deletion failed as expected: " . $e->getMessage() . "\n";
    }

    // Supression de l'activité et de l'utilisateur de test pour "nettoyer" la base de données
    $activityDAO->delete($activity);
    $userDAO->delete($user->getEmail());
}

testUserDAO();
testActivityDAO();
testActivityEntryDAO();
