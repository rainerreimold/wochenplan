<?php
/*****************************************************************************************


Datei: SpeiseZaehler.class.php
 Ziel: Zähler für die Häufigkeit des Einsatzes einer Speisekomponente in einem 
 	   Speiseplan.
   	   Wie häufig wird eine Speisekomponente in einem Speiseplan eingesetzt?

Projekt: Wochenplan		
Autor: Rainer
Datum: 12.06.2021

Tabelle:
  `speiseinplan_id` int(11) NOT NULL,
  `speise_id` int(11) NOT NULL,
  `speiseplan_id` int(11) NOT NULL,
  `zaehler` int(11) NOT NULL,
  `letztereintrag` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP


*****************************************************************************************/



class SpeiseZaehler {

  public function __construct() {}


// für die Zähler muss berücksichtigt werden, dass der Eintrag bereits bestehen kann oder noch nicht.
// es muss also erst festgestellt werden, ob der Eintrag bereits besteht und ermittelt die ID.
// Existiert der Eintrag nicht, dann muss der neue Eintrag eine neue ID erhalten. Über das Replace 
// into statement müsste man eigentlich den MAX(ID) ermitteln, inkremetieren und in den EIntrag einbinden

// Da hier aber ein autoincremtent auf die ID steht, benötigt man dies nicht.
// es genügt daher nur den Eintrag zu senden oder eben nicht.
  
    
  public function inkrementZaehler( $speiseplan_id, $speise_id ) 
  {
    
    // 1. Schritt
    // prüfe ob der EIntrag schon existiert und hole die Id
    // existiert der EIntrag nicht, dann -1
    // beide Parameter können nicht null sein
  	$skz_Id = getId( $speisekomponente_id, $speise_id );
  	
  	try {
		  // einfacher Switch	
		  if  (0 == $skz_Id) {
		  	// Neuanlegen
		  	 $sql = "replace into `speiseinplan` set speiseplan_id = ".$speiseplan_id.", speise_id =".$speise_id."; ";
		  
		  }
		  else {
		    // bestehenden Eintrag updaten 
		     $sql = "update `speiseinplan`  Set zaehler=zaehler+1 where speiseinplan_id =".$skz_Id."; ";
		  }
		  
		  // Bsp. funktioniert: update speiseinplan Set zaehler=zaehler+1 where speiseplan_id=1 and speise_id=1;
		  
	    //$sql = "replace into `speisekomponentezaehler` Set `loeschbar`=(`loeschbar`-1)*-1 where `lebensmittel_id`=".$id.";";
  
         // print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          //echo "<br>".$sql."<br>";
          //die();


          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }
         //die();
        header('location:../zeigeAlleLebensmittel') ;

	}

	// beide Parameter können nicht null sein
	public function getId( $speiseplan_id, $speise_id ) 
	{
		try {
		
			$sql = "SELECT speiseinplan_id from speiseinplan where speiseplan_id= ".$speiseplan_id." and speise_id = ".$speise_id." ";

       		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        	$rueckgabe = $db->query($sql);
        
        	$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        	$db=null;
        	return $ergebnis['speiseinplan_id'];
        
    	}

    	catch(PDOException $e){
        	print $e->getMessage();
    	}
    	return -1;
 
	}
		



}