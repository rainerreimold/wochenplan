<?php

 //echo "../../wochenplan/class/LetzteAktivitaet.classes.php";
 require_once("./class/LetzteAktivitaet.classes.php");
 require_once("./class/Log.classes.php");
 require_once("./class/Zaehler.classes.php");
 require_once("./class/SpeiseZaehler.classes.php");
 require_once("./class/DatenbankZugriff.classes.php");
 require_once("./class/DB_Mysql_Prod.classes.php");


 define ('PFAD','../../../../../..');

 define ('PATH_CONTROLLERS','controller/');

// define('DEBUG', false);
 
 define('GZIP_COMPRESSION', false);
 define('STORE_PAGE_PARSE_TIME', 30);
 define('DISPLAY_PAGE_PARSE_TIME', true);

 
 
 define('SQLTRACKING', false);
 
 define ('DocPathUrl', dirname(__FILE__)); 


/**
 *
 * DEBUG MODUS an oder .
 *
 */   


  define('DEBUG', false);


/**
 *
 * Pfad, in den die Klassen abgelegt werden sollen.
 *
 */   


 // define('PFAD', '../');

  
  /**
 *
 * Pfad, in den die Klassen abgelegt werden sollen.
 *
 */   


  define('APPNAME', 'wochenplan');






  
/**
 *
 * Pfad, in den die Klassen abgelegt werden sollen.
 *
 */   


  define('CLASS_PATH', 'Classes');



/**
 * DB Zugangsdaten
 *      Host
 *
 */


  define( 'DB_HOST', 'localhost' );



/**
 * DB Zugangsdaten
 *      Name der Datenbank
 */


  define( 'DB_NAME' ,'rezept' );



/**
 * DB Zugangsdaten
 *      User der Datenbank
 */


  define( 'DB_USER', 'root' );




/**
 * DB Zugangsdaten
 *     Passwort der Datenbank
 */


  define( 'DB_PASS', 'root' );


/**
 * DSN
 *
 */  

    



?>