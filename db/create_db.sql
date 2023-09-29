/* ------------------------------------ */
/*      Database creation script        */
/* ------------------------------------ */
/*       GUERNY Baptiste - Gr 2C2       */
/* ------------------------------------ */

PRAGMA foreign_keys = ON; -- Enable foreign key constraints

CREATE TABLE User (
    email TEXT PRIMARY KEY,
    password TEXT NOT NULL,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL,
    dateOfBirth TEXT NOT NULL,
    gender TEXT NOT NULL CHECK (gender IN ('M', 'F', 'U')),
    height REAL NOT NULL CHECK (height > 0),
    weight REAL NOT NULL CHECK (weight > 0)
);

CREATE TABLE Activity (
    idAct INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    date TEXT NOT NULL CHECK (date <= CURRENT_TIMESTAMP),
    startTime TEXT NOT NULL,
    duration TEXT NOT NULL,
    distance REAL NOT NULL CHECK (distance > 0),
    minHeartRate INTEGER NOT NULL CHECK (minHeartRate > 0),
    maxHeartRate INTEGER NOT NULL CHECK (maxHeartRate > 0),
    avgHeartRate INTEGER NOT NULL CHECK (avgHeartRate > 0),
    email TEXT NOT NULL,
    FOREIGN KEY (email) REFERENCES User(email)
);

CREATE TABLE ActivityEntry (
    idAData INTEGER PRIMARY KEY AUTOINCREMENT,
    time TEXT NOT NULL,
    heartRate INTEGER NOT NULL CHECK (heartRate > 0),
    latitude REAL NOT NULL CHECK (latitude > -90 AND latitude < 90),
    longitude REAL NOT NULL CHECK (longitude > -180 AND longitude < 180),
    altitude REAL NOT NULL CHECK (altitude > 0),
    idAct INTEGER NOT NULL,
    FOREIGN KEY (idAct) REFERENCES Activity(idAct)
);

CREATE TRIGGER validate_email_before_insert_leads 
   BEFORE INSERT ON User
BEGIN
   SELECT
      CASE
	WHEN NEW.email NOT LIKE '%_@__%.__%' THEN
   	  RAISE (ABORT,'Adresse mail invalide')
       END;
END;
