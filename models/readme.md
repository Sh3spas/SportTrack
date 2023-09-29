Pour la gestion de la base de donnée, nous avons choisit d'utiliser la librairie PDO.  

Ce dossier contiens :
- la classe permettant de se connecter à la base de donnée
- une classe DatabaseException qui concentrera toute les exceptions liées à la base de donnée à afficher à l'utilisateur (sur le site)
- chaque classe de modèle (User, Activity, ActivityEntry) qui correspondent à une table de la base de donnée, ces modèles contiennent des contraintes identiques aux contraintes de la base de donnée pour une double sécurité
- chaque classe DAO (UserDAO, ActivityDAO, ActivityEntryDAO) qui permettent de faire le lien entre les modèles et la base de donnée, elles contiennent les requêtes SQL et les fonctions permettant de les exécuter
- les exceptions liés aux DAO ou à la base de donnée mais qui ne doivent pas être affichées à l'utilisateur (sur le site) sont des PDOExceptions