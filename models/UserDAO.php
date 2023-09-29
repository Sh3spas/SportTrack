<?php

namespace models;
use PDO;

require_once __ROOT__ . '/models/SqliteConnection.php';
use models\SqliteConnection;


/**
 * This class is used to get, insert, update and delete users from the database. Only one instance of this class.
 * @package models
 */
class UserDAO {
    private static UserDAO $dao;

    private function __construct() {}

    /**
     * Creates an instance of UserDAO if it doesn't exist and returns it.
     * @return UserDAO the unique instance of UserDAO
     */
    public static function getInstance(): UserDAO
    {
        if(!isset(self::$dao)) {
            self::$dao= new UserDAO();
        }
        return self::$dao;
    }
    
    /**
     * Returns all the users from the database.
     * Return an empty array if no user is found.
     * @return array an array of User objects
     */
    public function findAll(): array
    {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM User order by firstName, lastName";
        $stmt = $dbc->query($query);
        $results = $stmt->fetchALL(PDO::FETCH_CLASS, 'models\User');
        return $results;
    }

    /**
     * Returns an user from the database from his email.
     * @param string $email the email of the user to find
     * @return User the user found, or null if no user is found
     * @throws \PDOException if an error occurs while executing the SQL statement
     */
    public function find(string $email): User|false
    {
        $dbc = SqliteConnection::getInstance()->getConnection();
        // prepare the SQL statement
        $query = "SELECT * FROM User WHERE email = :email";
        $stmt = $dbc->prepare($query);
        $stmt->bindValue(':email', $email);

        // execute the prepared statement
        $stmt->execute();

        // fetch the user if found
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'models\User');
        $user = $stmt->fetch();

        return $user;
    }


    /**
     * Insert an user into the database from an User object.
     * @param User $user the user to insert
     * @throws DatabaseException if the user already exists in the database
     * @throws \PDOException if an error occurs while executing the SQL statement
     */
    public function insert(User $user): void
    {
        if ($user instanceof User) { // check if the parameter is an User object
            $dbc = SqliteConnection::getInstance()->getConnection();

            if ($this->find($user->getEmail())) { // check if the user already exists in the database
                throw new DatabaseException("Cet utilisateur existe déjà dans la base de données.");
            }

            // prepare the SQL statement
            $query = "INSERT INTO User (email, password, firstName, lastName, dateOfBirth, gender, height, weight)
                  VALUES (:e, :p, :fn, :ln, :dob, :g, :h, :w)";

            $stmt = $dbc->prepare($query);

            // bind the paramaters
            $stmt->bindValue(':e', $user->getEmail());
            $stmt->bindValue(':p', $user->getPassword());
            $stmt->bindValue(':fn', $user->getFirstName());
            $stmt->bindValue(':ln', $user->getLastname());
            $stmt->bindValue(':dob', $user->getDateOfBirth());
            $stmt->bindValue(':g', $user->getGender());
            $stmt->bindValue(':h', $user->getHeight());
            $stmt->bindValue(':w', $user->getWeight());

            // execute the prepared statement
            $stmt->execute(); // Can throw a PDOException not caught here
        }
    }

    /**
     * Updates an user from the database from an User object.
     * @param User $user the user to update
     * @throws \PDOException if no user with this email exists in the database
     * @throws \PDOException if an error occurs while executing the SQL statement
     */
    public function update(User $user): void
    {
        if ($user instanceof User) {
            $dbc = SqliteConnection::getInstance()->getConnection();

            if (!$this->find($user->getEmail())) { // check if the user exists in the database
                throw new \PDOException("model.UserDAO.delete : User with email ". $user->getEmail() .
                "not found in the database.");
            }

            // prepare the SQL statement
            $query = "UPDATE User SET
                  password = :password,
                  firstname = :firstname,
                  lastname = :lastname,
                  dateOfBirth = :dateOfBirth,
                  gender = :gender,
                  height = :height,
                  weight = :weight
                  WHERE email = :email";

            $stmt = $dbc->prepare($query);

            $params = [
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':firstname' => $user->getFirstName(),
                ':lastname' => $user->getLastName(),
                ':dateOfBirth' => $user->getDateOfBirth(),
                ':gender' => $user->getGender(),
                ':height' => $user->getHeight(),
                ':weight' => $user->getWeight()
            ];

            // execute the prepared statement
            $stmt->execute($params);
        }
    }

    /**
     * Deletes an user from the database from his email.
     * @param string $email the email of the user to delete
     * @throws \PDOException if an error occurs while executing the SQL statement
     * @throws \PDOException if no user with this email exists in the database
     */
    public function delete(string $email): void
    {
        $dbc = SqliteConnection::getInstance()->getConnection();

        // prepare the SQL statement
        $query = "DELETE FROM User WHERE email = :email";
        $stmt = $dbc->prepare($query);
        $stmt->bindValue(':email', $email);

        // execute the prepared statement
        $stmt->execute();

        // check if the user has been deleted
        if ($stmt->rowCount() === 0) {
            throw new \PDOException("model.UserDAO.delete : User with email $email not found in the database.");
        }
    }
}
