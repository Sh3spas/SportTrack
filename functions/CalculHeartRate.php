<?php

namespace functions;

require_once __DIR__ . "/CalculDistance.php";

class CalculHeartRate
{

    /**
     * Calcule la moyenne, le mini et le maxi de la fréquence cardiaque
     * @param array $parcours tableau associatif contenant les données du parcours
     * @return array tableau contenant le mini, le maxi et la moyenne de la fréquence cardiaque
     */
    public function CalculHeartRateAll(array $parcours): array
    {
        // Calcul de la moyenne, du mini et du maxi de la fréquence cardiaque
        $hrMin = 999;
        $hrMax = 0;
        $hrTot = 0;

        for ($i = 0; $i < count($parcours); $i++) {
            $hrTot += $parcours[$i]['cardio_frequency'];
            if ($parcours[$i]['cardio_frequency'] < $hrMin) {
                $hrMin = $parcours[$i]['cardio_frequency'];
            }
            if ($parcours[$i]['cardio_frequency'] > $hrMax) {
                $hrMax = $parcours[$i]['cardio_frequency'];
            }
        }
        $hrMoy = round($hrTot / count($parcours));
        return [$hrMin, $hrMax, $hrMoy];
    }
}