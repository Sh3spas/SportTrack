<?php

namespace models;
use PDO;

require_once __ROOT__ . '/models/SqliteConnection.php';
use models\SqliteConnection;

/**
 * This class is used to get, insert, update and delete activities from the database. Only one instance of this class.
 * @package models
 */
class ActivityDAO {
    private static ActivityDAO $dao;

    private function __construct() {}

    /**
     * Creates an instance of ActivityDAO if it doesn't exist and returns it.
     * @return ActivityDAO the unique instance of ActivityDAO
     */
    public static function getInstance(): ActivityDAO
    {
        if (!isset(self::$dao)) {
            self::$dao = new ActivityDAO();
        }
        return self::$dao;
    }

    /**
     * Returns all the activities from the database.
     * @param string $email the email of the user
     * @return array an array of Activity objects
     */
    public function findByUser(string $email): array
    {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM Activity WHERE email = :email";

        $stmt = $dbc->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_CLASS, 'models\Activity');
        return $results;
    }

    /**
     * Return the activity by this id from the database.
     * @param string $idAct the id of the activity
     * @return Activity the activity selected
     * @throws DatabaseException if this activity doesn't exist in the database
     * @throws \PDOException if an error occurs while executing the query
     */
    public function findById(int $idAct) : Activity
    {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM Activity WHERE idAct = :idAct";

        $stmt = $dbc->prepare($query);
        $stmt->bindValue(':idAct', $idAct);
        $stmt->execute();

        $activity = $stmt->fetchObject('models\Activity');

        if (!$activity) {
            throw new DatabaseException("models.ActivityDAO.findById : Activity with ID $idAct not found in the database.");
        }

        return $activity;
    }
    
    /**
     * Inserts an activity into the database from an Activity object.
     * @param Activity $activity the activity to insert
     * @throws \PDOException if an error occurs while inserting the activity
     */
    public function insert(Activity $activity): void
    {
        if ($activity instanceof Activity) { // Check if the parameter is an Activity object
            $dbc = SqliteConnection::getInstance()->getConnection();

            // Prepare the SQL statement
            $query = "INSERT INTO Activity
                  (name, date, startTime, duration, distance, minHeartRate, maxHeartRate, avgHeartRate, email)
                  VALUES (:n, :d, :sT, :dura, :dist, :minHR, :maxHR, :avgHR, :e)";
            $stmt = $dbc->prepare($query);

            // Create an array with the parameter values
            $params = [
                ':n' => $activity->getName(),
                ':d' => $activity->getDate(),
                ':sT' => $activity->getStartTime(),
                ':dura' => $activity->getDuration(),
                ':dist' => $activity->getDistance(),
                ':minHR' => $activity->getMinHeartRate(),
                ':maxHR' => $activity->getMaxHeartRate(),
                ':avgHR' => $activity->getAvgHeartRate(),
                ':e' => $activity->getEmail()
            ];

            // Execute the prepared statement
            $stmt->execute($params);
            $idAct = $dbc->lastInsertId();
            $activity->setIdAct($idAct);
        }

    }

    /**
     * Updates an activity into the database from an Activity object.
     * @param Activity $activity the activity to update
     * @throws \PDOException if no activity with this id exists in the database
     * @throws \PDOException if an error occurs while executing the SQL statement
     */
    public function update(Activity $activity): void
    {
        if ($activity instanceof Activity) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            if (!$activity->getIdAct()) {
                throw new \PDOException("model.ActivityDAO.update : Activity not found in the database.");
            }
            if (!$this->findById($activity->getIdAct())) { // check if the user exists in the database
                throw new \PDOException("model.UserDAO.delete : Activity with email " . $activity->getIdAct() .
                    "not found in the database.");
            }

            // prepare the SQL statement
            $query = "UPDATE Activity SET
                  name = :name,
                  date = :date,
                  startTime = :startTime
                  WHERE idAct = :idAct";

            $stmt = $dbc->prepare($query);

            $params = [
                ':idAct' => $activity->getIdAct(),
                ':name' => $activity->getName(),
                ':date' => $activity->getDate(),
                ':startTime' => $activity->getStartTime(),
            ];

            // execute the prepared statement
            $stmt->execute($params);
        }
    }
    
    /**
     * Deletes an activity into the database from an Activity object.
     * @param Activity $activity the activity to delete
     * @throws \PDOException if no activity with this id exists in the database
     * @throws \PDOException if an error occurs while executing the SQL statement
     */
    public function delete(Activity $activity): void
    {
        if ($activity instanceof Activity) {
            $dbc = SqliteConnection::getInstance()->getConnection();

            // prepare the SQL statement
            $query = "DELETE FROM Activity WHERE idAct = :idAct";
            $stmt = $dbc->prepare($query);

            // bind the parameter
            $stmt->bindValue(':idAct', $activity->getIdAct());

            // execute the prepared statement
            $stmt->execute();

            // check if the user has been deleted
            if ($stmt->rowCount() === 0) {
                throw new \PDOException("model.ActivityDAO.delete : Activity named "
                    . $activity->getName() . " not found in the database.");
            }
        }
    }
}
