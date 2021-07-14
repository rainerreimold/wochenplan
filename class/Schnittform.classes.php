<?php

/********************************************************************************************
 Datei: Schnittform.class.php
 Ziel: Anzeige der Schnittformen

 Autor: R. Reimold
 Datum: 18.07.2021

********************************************************************************************/



class Schnittform {





  public function getSchnittformen()
  {

	try {

		$sql = "SELECT schnittform_id, schnittform_bezeichnung, beschreibung FROM schnittform WHERE 1";
		$dbh = new DB_Mysql_Prod;
        $ergebnis = $dbh->fetch_assoc($sql);
		$var = "<br>
<br><small>Quelle:https://g-wie-gastro.de/abteilungen/kueche/fachkunde/schnittformen.html</small>";	

        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$beschreibung = htmlspecialchars($inhalt['beschreibung']);
			$laenge = strlen ($beschreibung);
			$len_val = strlen ($var);
	
			$besch = substr($beschreibung, 0, $laenge-($len_val+24));	
			$beschreibung = $besch;		
	
			if ($inhalt['schnittform_id']==13)			
				$ret=$ret."<option value=\"13\"  title=\"".$beschreibung."\" selected>".$inhalt['schnittform_bezeichnung'] ."</option>\n";
			else	
				$ret=$ret."<option value=\"".$inhalt['schnittform_id']."\" title=\"".$beschreibung."\">".$inhalt['schnittform_bezeichnung'] ."</option>\n";
		  }
		  return $ret;        
        }
    }
    catch(PDOException $e){
        print $e->getMessage();
    }
    return "-1";
  }

}