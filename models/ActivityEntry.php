<?php

namespace models;

class ActivityEntry{
    private int $idAData;
    private string $time;
    private int $heartRate;
    private float $latitude;
    private float $longitude;
    private float $altitude;
    private int $idAct;

    public function  __construct() { }

    public function init($t, $hr, $lat, $long, $alt, $idAct, $idAData = null){
        $this->time = $t;
        $this->heartRate = $hr;
        $this->latitude = $lat;
        $this->longitude = $long;
        $this->altitude = $alt;
        $this->idAct = $idAct;

        if ($idAData != null) {
            $this->idAData = $idAData;
        }
    }

    public function getIdAData(): int { return $this->idAData; }
    public function getTime(): string { return $this->time; }
    public function getHeartRate(): int { return $this->heartRate; }
    public function getLatitude(): float { return $this->latitude; }
    public function getLongitude(): float { return $this->longitude; }
    public function getAltitude(): float { return $this->altitude; }
    public function getIdAct(): int { return $this->idAct; }
    
    public function setIdAData($idAData): void { $this->idAData = $idAData; }
    public function setIdAct($idAct): void { $this->idAct = $idAct; }

    public function __toString() : string {
        return "ActivityEntry : idAData = " . $this->idAData . ", time = " . $this->time . ", heartRate = " . $this->heartRate . ", latitude = " . $this->latitude . ", longitude = " . $this->longitude . ", altitude = " . $this->altitude . ", idAct = " . $this->idAct;
    }
}