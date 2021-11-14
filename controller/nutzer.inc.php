<?php
/**********************************************************************************************

Projekt: rezept/wochenplan
Datei: nutzer.inc.php
Aufgabe: controller für die Eingabe eigener nutzer-speiseplaene

Hinweis:

Autor: Rainer Reimold * 0151/28872748 * rainerreimold@gmx.de
Datum: 23.09.2021

**********************************************************************************************/



session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Rezepte - Verwaltung von Ingredenzien';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;


static $db;

function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	
	//$oDbName = new  DBInformation();

	//Aber die Übersicht ist doch nicht die action sondern der
	//controller.....
    
    /* Den Header können wir leider nicht mehr zentral einbinden,
       da sonst die header location nicht mehr funktioniert. 
      
         include 'inc/header.php';
	 */
    
    if ( $action == '') {
	

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>Rezept</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

    else if ( $action == 'speiseplan-anlegen') {

		require_once("nutzer/nutzer-speiseplan-anlegen.php"); 
    }
}