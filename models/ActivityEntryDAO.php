<?php

namespace models;
use PDO;

require_once __ROOT__ . '/models/SqliteConnection.php';
use models\SqliteConnection;

/**
 * This class is used to get, insert, update and delete activities entries
 * from the database. Only one instance of this class.
 * @package models
 */
class ActivityEntryDAO {
    private static ActivityEntryDAO $dao;

    private function __construct() {}

    /**
     * Creates an instance of ActivityEntryDAO if it doesn't exist and returns it.
     * @return ActivityEntryDAO the unique instance of ActivityEntryDAO
     */
    public static function getInstance(): ActivityEntryDAO
    {
        if (!isset(self::$dao)) {
            self::$dao = new ActivityEntryDAO();
        }
        return self::$dao;
    }

    /**
     * Returns all the activities entries from the database.
     * @param int $idAct the id of the activity
     * @return array an array of ActivityEntry objects
     */
    public function findAllByIdAct(int $idAct): array
    {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM ActivityEntry WHERE idAct = :idAct";

        $stmt = $dbc->prepare($query);
        $stmt->bindValue(':idAct', $idAct);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_CLASS, 'models\ActivityEntry');
        return $results;
    }

    /**
     * Return the activity entry by this id from the database.
     * @param int $idAData the id of the activity entry
     * @return ActivityEntry the activity entry selected
     * @throws DatabaseException if this activity entry doesn't exist in the database
     * @throws \PDOException if an error occurs while executing the query
     */
    public function findById(int $idAData) : ActivityEntry
    {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM ActivityEntry WHERE idAData = :idAData";

        $stmt = $dbc->prepare($query);
        $stmt->bindValue(':idAData', $idAData);
        $stmt->execute();

        $result = $stmt->fetchObject('models\ActivityEntry');

        if (!$result) {
            throw new DatabaseException("models.ActivityEntryDAO.findById : ActivityEntry with id "
                . $idAData . " not found in the database.");
        }

        return $result;
    }

    /**
     * Inserts an activity entry into the database from an ActivityEntry object.
     * @param ActivityEntry $activityEntry the activity entry to insert
     * @throws \PDOException if an error occurs while inserting the activity entry
     */
    public function insert(ActivityEntry $activityEntry): void
    {
        if ($activityEntry instanceof ActivityEntry) { // check if the parameter is an ActivityEntry object
            $dbc = SqliteConnection::getInstance()->getConnection();

            // prepare the SQL statement
            $query = "INSERT INTO ActivityEntry
                  (time, heartRate, latitude, longitude, altitude, idAct)
                  VALUES (:time, :heartRate, :latitude, :longitude, :altitude, :idAct)";

            $stmt = $dbc->prepare($query);
            $stmt->bindValue(':time', $activityEntry->getTime());
            $stmt->bindValue(':heartRate', $activityEntry->getHeartRate());
            $stmt->bindValue(':latitude', $activityEntry->getLatitude());
            $stmt->bindValue(':longitude', $activityEntry->getLongitude());
            $stmt->bindValue(':altitude', $activityEntry->getAltitude());
            $stmt->bindValue(':idAct', $activityEntry->getIdAct());

            // execute the prepared statement and check if an error occurs
            $stmt->execute();
            $idAData = $dbc->lastInsertId();
            $activityEntry->setIdAData($idAData);
        }
    }

    /**
     * Updates an activity entry from the database from an ActivityEntry object.
     * @param ActivityEntry $activityEntry the activity entry to update
     * @throws \PDOException if no activity entry with this id exists in the database
     * @throws \PDOException if an error occurs while executing the SQL statement
     */
    public function update(ActivityEntry $activityEntry): void
    {
        if ($activityEntry instanceof ActivityEntry) { // check if the parameter is an ActivityEntry object
            $dbc = SqliteConnection::getInstance()->getConnection();
            if(!$activityEntry->getIdAData()){
                throw new \PDOException("models.ActivityEntryDAO.update : ActivityEntry not found in the database.");
            }
            if(!$this->findById($activityEntry->getIdAData())){
                throw new \PDOException("models.ActivityEntryDAO.update : ActivityEntry with id "
                    . $activityEntry->getIdAData() . " not found in the database.");
            }

            // prepare the SQL statement
            $query = "UPDATE ActivityEntry SET
                    time = :time,
                    heartRate = :heartRate,
                    latitude = :latitude,
                    longitude = :longitude,
                    altitude = :altitude
                    WHERE idAData = :idAData";
                
            $stmt = $dbc->prepare($query);

            $params = [
                ':time' => $activityEntry->getTime(),
                ':heartRate' => $activityEntry->getHeartRate(),
                ':latitude' => $activityEntry->getLatitude(),
                ':longitude' => $activityEntry->getLongitude(),
                ':altitude' => $activityEntry->getAltitude(),
                ':idAData' => $activityEntry->getIdAData()
            ];
            
            // execute the prepared statement
            $stmt->execute($params);
        }
    }

    /**
     * Deletes an activity entry from the database from an ActivityEntry object.
     * @param ActivityEntry $activityEntry the activity entry to delete
     * @throws \PDOException if no activity entry with this id exists in the database
     * @throws \PDOException if an error occurs while executing the SQL statement
     */
    public function delete(ActivityEntry $activityEntry): void
    {
        if ($activityEntry instanceof ActivityEntry) { // check if the parameter is an ActivityEntry object
            $dbc = SqliteConnection::getInstance()->getConnection();

            // prepare the SQL statement
            $query = "DELETE FROM ActivityEntry WHERE idAData = :idAData";
            $stmt = $dbc->prepare($query);

            // bind the parameter
            $stmt->bindValue(':idAData', $activityEntry->getIdAData());

            // execute the prepared statement
            $stmt->execute();

            // check if the user has been deleted
            if ($stmt->rowCount() === 0) {
                throw new \PDOException("models.ActivityEntryDAO.delete : ActivityEntry with id "
                    . $activityEntry->getIdAData() . " not found in the database.");
            }
        }
    }
}
