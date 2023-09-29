<?php

namespace models;

/**
 * This class represents an activity in the same format as in the database."
 * @package models
 */
class Activity{

    // Each attribute corresponds to a column in the database
    private int $idAct;
    private string $name;
    private string $date;
    private string $startTime;
    private string $duration;
    private float $distance;
    private int $minHeartRate;
    private int $maxHeartRate;
    private int $avgHeartRate;
    private string $email;

    public function  __construct() { }

    // This method is used to initialize the attributes of an Activity object
    public function init(string $n, string $date, string $st, string $dura, float $dist, 
                int $minHR, int $maxHR, int $avgHR, string $email, int $idAct = null) {
        $this->name = $n;
        $this->date = $date;
        $this->startTime = $st;
        $this->duration = $dura;
        $this->distance = $dist;
        $this->minHeartRate = $minHR;
        $this->maxHeartRate = $maxHR;
        $this->avgHeartRate = $avgHR;
        $this->email = $email;

        if ($idAct != null) {
            $this->idAct = $idAct;
        }
    }

    // Getters
    public function getIdAct(): int|false { if (isset($this->idAct)) { return $this->idAct; } else { return false; } }
    public function getName(): string { return $this->name; }
    public function getDate(): string { return $this->date; }
    public function getStartTime(): string { return $this->startTime; }
    public function getDuration(): string { return $this->duration; }
    public function getDistance(): float { return $this->distance; }
    public function getMinHeartRate(): int { return $this->minHeartRate; }
    public function getMaxHeartRate(): int { return $this->maxHeartRate; }
    public function getAvgHeartRate(): int { return $this->avgHeartRate; }
    public function getEmail(): string { return $this->email; }
    
    // Setters
    public function setIdAct(int $idAct): void { $this->idAct = $idAct; }
    public function setName(string $name): void { $this->name = $name; }
    public function setDate(string $date): void { $this->date = $date; }
    public function setStartTime(string $startTime): void { $this->startTime = $startTime; }
    public function setDuration(string $duration): void { $this->duration = $duration; }
    public function setDistance(float $distance): void { $this->distance = $distance; }
    public function setMinHeartRate(int $minHeartRate): void { $this->minHeartRate = $minHeartRate; }
    public function setMaxHeartRate(int $maxHeartRate): void { $this->maxHeartRate = $maxHeartRate; }
    public function setAvgHeartRate(int $avgHeartRate): void { $this->avgHeartRate = $avgHeartRate; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function __toString(): string
    {
        return "Activity [idAct=" . $this->idAct . ", name=" . $this->name . ", date=" .
            $this->date . ", startTime=" . $this->startTime . ", duration=" . $this->duration .
            ", distance=" . $this->distance . ", minHeartRate=" . $this->minHeartRate .
            ", maxHeartRate=" . $this->maxHeartRate . ", avgHeartRate=" . $this->avgHeartRate .
            ", email=" . $this->email . "]";
    }

    public function __toArrays(){
        return [
            "idAct" => $this->idAct,
            "name" => $this->name,
            "date" => $this->date,
            "startTime" => $this->startTime,
            "duration" => $this->duration,
            "distance" => $this->distance,
            "minHeartRate" => $this->minHeartRate,
            "maxHeartRate" => $this->maxHeartRate,
            "avgHeartRate" => $this->avgHeartRate,
            "email" => $this->email
        ];
    }
}
