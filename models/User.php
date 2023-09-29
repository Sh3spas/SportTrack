<?php

namespace models;
require_once __ROOT__ . '/models/DatabaseException.php';

/**
 * This class represents an user in the same format as in the database."
 * @package models
 */
class User{

    // Each attribute corresponds to a column in the database
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $dateOfBirth;
    private string $gender;
    private float $height;
    private float $weight;


    public function  __construct() { }

    // This method is used to initialize the attributes of an User object
    public function init($e, $p, $fn, $ln, $dob, $g, $h, $w){
        if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
            $this->email = $e;
        } else {
            throw new DatabaseException("L'adresse mail est invalide"); 
            // Les exceptions sont en français car ce sont celles affichées à l'utilisateur
        }

        $this->setPassword($p);
        $this->setFirstName($fn);
        $this->setLastName($ln);
        $this->setDateOfBirth($dob);
        $this->setGender($g);
        $this->setHeight($h);
        $this->setWeight($w);
    }

    // Accessors
    public function  __toString(): string { return $this->firstName. " ". $this->lastName; }
    public function getFullName(): string { return $this->firstName. " ". $this->lastName; }

    // Getters
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getDateOfBirth(): string { return $this->dateOfBirth; }
    public function getGender(): string { return $this->gender; }
    public function getHeight(): float { return $this->height; }
    public function getWeight(): float { return $this->weight; }

    // Setters (with contraints on the values)
    public function setPassword(string $password): void
    {
        if (strlen($password) >= 8) {
            $this->password = $password;
        } else {
            throw new DatabaseException("Le mot de passe doit contenir au moins 8 caractères");
        }
    }

    public function setFirstName(string $firstName): void
    {
        if (strlen($firstName) >= 2) {
            $this->firstName = $firstName;
        } else {
            throw new DatabaseException("Le prénom doit contenir au moins 2 caractères");
        }
    }

    public function setLastName(string $lastName): void
    {
        if (strlen($lastName) >= 2) {
            $this->lastName = $lastName;
        } else {
            throw new DatabaseException("Le nom doit contenir au moins 2 caractères");
        }
    }

    public function setDateOfBirth(string $dateOfBirth): void
    {
        $dateOfBirthTimestamp = strtotime($dateOfBirth); // Convert in timestamp
        $currentTimestamp = time();

        if ($dateOfBirthTimestamp < $currentTimestamp) {
            $this->dateOfBirth = $dateOfBirth;
        } else {
            throw new DatabaseException("La date de naissance doit être antérieure à la date actuelle");
        }
    }

    public function setGender(string $gender): void
    {
        $validGenders = ['M', 'F', 'U']; // U for undefined

        if (in_array($gender, $validGenders)) {
            $this->gender = $gender;
        } else {
            throw new DatabaseException("Le genre n'est pas valide");
        }
    }

    public function setHeight(int $height): void
    {
        if ($height > 0 && $height < 300) {
            $this->height = $height;
        } else {
            throw new DatabaseException("La taille n'est pas bonne");
        }
    }

    public function setWeight(int $weight): void
    {
        if ($weight > 0 && $weight < 500) {
            $this->weight = $weight;
        } else {
            throw new DatabaseException("Le poids n'est pas bon");
        }
    }

    public function __toArrays(){
         return [
            "email" => $this->email,
            "password" => $this->password,
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "dateOfBirth" => $this->dateOfBirth,
            "gender" => $this->gender,
            "height" => $this->height,
            "weight" => $this->weight,
        ];
    }

}
