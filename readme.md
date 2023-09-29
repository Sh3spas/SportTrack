# SportTrack - Application de suivi d'activités sportives

## Introduction
SportTrack est une application web qui permet aux utilisateurs de sauvegarder et gérer leurs données d'activités sportives en utilisant des montres "cardio/gps". L'application offre diverses fonctionnalités telles que la création de comptes utilisateur, la connexion/déconnexion, le chargement de fichiers d'activités sportives et la visualisation des activités enregistrées.

## Prérequis
- PHP 8.1
- SQLite3

## Installation

1. Clonez ce dépôt GitHub sur votre machine locale :
   ```
   git clone https://github.com/BatLeDev/SportTrack.git
   ```

2. Créez la base de données en important le schéma SQL :
   ```
   sqlite3 db/sport_track.db < db/create_db.sql
   ```

## Démarrage du Serveur

1. Démarrez le serveur PHP intégré (assurez-vous d'être dans le répertoire racine du projet) :
   ```
   php -S localhost:8080
   ```

2. Accédez à l'application dans un navigateur en ouvrant `http://localhost:8080` dans la barre d'adresse.

## Tests Unitaires

Pour exécuter les tests unitaires, utilisez les commandes suivantes :

1. Pour tester la connexion à la base de données SQLite :
   ```
   php tests/test_sqlite_connection.php
   ```

2. Pour tester le calcul de distances entre des points GPS :
   ```
   php tests/test_calcul_distance.php
   ```

Si dans la console il apparait des lignes commençant par `[!]` alors les tests ont échoué. Si au contraire il apparait des lignes commençant par `[+]` ou `[-]` alors les tests ont réussi.

## Auteurs
Ce projet a été réalisé par [Baptiste GUERNY (moi)](https://github.com/BatLeDev) et Simon Le CHANU dans le cadre de notre BUT Informatique à l'IUT de Vannes.