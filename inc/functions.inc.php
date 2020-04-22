<?php




function getSpeiseKomponenten() {

	try {

		$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me, z.zubereitungsart_bezeichnung as zb FROM `speisekomponente` sk, `menge` m, zubereitungsart z WHERE m.menge_id=sk.menge_id and z.zubereitungsart_id= sk.zubereitungsart_id order By sk.bezeichnung asc";
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
		/*	$sk[$i][0] = $inhalt['speisekomponente_id'];
			$sk[$i][1] = $inhalt['skb'];
			$sk[$i][2] = $inhalt['mb'];
			$sk[$i][3] = $inhalt['me'];
			$sk[$i][4] = $inhalt['zb'];
		*/	
			++$i;

			$ret=$ret."<option value=\"".$inhalt['speisekomponente_id']."\">".$inhalt['skb']." - ".$inhalt['mb']." ".$inhalt['me'] ."</option>\n";


		  }
		  return $ret;        
        }
        //return $ergebnis[0]['domain_name'];

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}
//getSaettigungsBeilage
function getSaettigungsBeilage() {

	try {

		$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me, 
				z.zubereitungsart_bezeichnung as zb FROM `speisekomponente` sk, `menge` m, zubereitungsart z 
				WHERE m.menge_id=sk.menge_id and z.zubereitungsart_id= sk.zubereitungsart_id 
				and speisekategorie_id=1
				order By sk.bezeichnung asc";
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				

			++$i;

			$ret=$ret."<option value=\"".$inhalt['speisekomponente_id']."\">".$inhalt['skb']." - ".$inhalt['mb']." ".$inhalt['me'] ."</option>\n";


		  }
		  return $ret;        
        }

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
   
}

function getGemueseBeilage() {

	try {

		$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me, 
				z.zubereitungsart_bezeichnung as zb FROM `speisekomponente` sk, `menge` m, zubereitungsart z 
				WHERE m.menge_id=sk.menge_id and z.zubereitungsart_id= sk.zubereitungsart_id 
				and speisekategorie_id=2
				order By sk.bezeichnung asc";
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['speisekomponente_id']."\">".$inhalt['skb']." - ".$inhalt['mb']." ".$inhalt['me'] ."</option>\n";


		  }
		  return $ret;        
        }
        //return $ergebnis[0]['domain_name'];

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}


function getHauptBeilage() {

	try {

		$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me, 
				z.zubereitungsart_bezeichnung as zb FROM `speisekomponente` sk, `menge` m, zubereitungsart z 
				WHERE m.menge_id=sk.menge_id and z.zubereitungsart_id= sk.zubereitungsart_id 
				and speisekategorie_id=3 or speisekategorie_id=7
				order By sk.bezeichnung asc";
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['speisekomponente_id']."\">".$inhalt['skb']." - ".$inhalt['mb']." ".$inhalt['me'] ."</option>\n";


		  }
		  return $ret;        
        }
        //return $ergebnis[0]['domain_name'];

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}


function getSuppen() {

	try {

		$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me, 
				z.zubereitungsart_bezeichnung as zb FROM `speisekomponente` sk, `menge` m, zubereitungsart z 
				WHERE m.menge_id=sk.menge_id and z.zubereitungsart_id= sk.zubereitungsart_id 
				and speisekategorie_id=4 
				order By sk.bezeichnung asc";
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['speisekomponente_id']."\">".$inhalt['skb']." - ".$inhalt['mb']." ".$inhalt['me'] ."</option>\n";


		  }
		  return $ret;        
        }
        //return $ergebnis[0]['domain_name'];

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return "leer -1";
    
    
}

function getVorspeisen() {

	try {

		$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me, 
				z.zubereitungsart_bezeichnung as zb FROM `speisekomponente` sk, `menge` m, zubereitungsart z 
				WHERE m.menge_id=sk.menge_id and z.zubereitungsart_id= sk.zubereitungsart_id 
				and speisekategorie_id=5 
				order By sk.bezeichnung asc";
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['speisekomponente_id']."\">".$inhalt['skb']." - ".$inhalt['mb']." ".$inhalt['me'] ."</option>\n";


		  }
		  return $ret;        
        }
        //return $ergebnis[0]['domain_name'];

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return "leer -1";
    
    
}


function getDessert() {

	try {

		$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me, 
				z.zubereitungsart_bezeichnung as zb FROM `speisekomponente` sk, `menge` m, zubereitungsart z 
				WHERE m.menge_id=sk.menge_id and z.zubereitungsart_id= sk.zubereitungsart_id 
				and speisekategorie_id=6 
				order By sk.bezeichnung asc";
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['speisekomponente_id']."\">".$inhalt['skb']." - ".$inhalt['mb']." ".$inhalt['me'] ."</option>\n";


		  }
		  return $ret;        
        }
        //return $ergebnis[0]['domain_name'];

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return "leer -1";
    
    
}

function getBestandteil() {

	try {

		$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me, 
				z.zubereitungsart_bezeichnung as zb FROM `speisekomponente` sk, `menge` m, zubereitungsart z 
				WHERE m.menge_id=sk.menge_id and z.zubereitungsart_id= sk.zubereitungsart_id 
				and speisekategorie_id=7 
				order By sk.bezeichnung asc";
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['speisekomponente_id']."\">".$inhalt['skb']." - ".$inhalt['mb']." ".$inhalt['me'] ."</option>\n";


		  }
		  return $ret;        
        }
        //return $ergebnis[0]['domain_name'];

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return "leer -1";
    
    
}



function getMengen() {

			try {

		$sql = "SELECT menge_id, bezeichnung, einheit from menge";

        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['menge_id']."\">".$inhalt['bezeichnung'] ." ". $inhalt['einheit'] ."</option>\n";


		  }
		  return $ret;        
        }


    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
 
}


 function getIngredienz() {

	try {

		$sql = "SELECT ingredienz_id, bezeichnung, beschreibung FROM ingredienz WHERE 1";

        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['ingredienz_id']."\"><strong>".$inhalt['bezeichnung'] ."</strong> - <small>". $inhalt['beschreibung'] ."</small></option>\n";


		  }
		  return $ret;        
        }


    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return "-1";

}

// Speisekategorie
 function getSpeisekategorie() {

	try {

		$sql = "SELECT speisekategorie_id, speisekategorie_bezeichnung FROM speisekategorie WHERE 1";

        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['speisekategorie_id']."\">".$inhalt['speisekategorie_bezeichnung'] ."</option>\n";


		  }
		  return $ret;        
        }


    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return "-1";

}


// Zubereitungsart

 function getZubereitungsart() {

	try {

		$sql = "SELECT zubereitungsart_id, zubereitungsart_bezeichnung FROM zubereitungsart WHERE 1";

        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['zubereitungsart_id']."\">".$inhalt['zubereitungsart_bezeichnung'] ."</option>\n";


		  }
		  return $ret;        
        }


    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return "-1";

}








function getAlleRezepte( ) {
	
		try {

		$sql = "SELECT rezept_id, bezeichnung, beschreibung from rezept";

        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			$ret=$ret."<option value=\"".$inhalt['rezept_id']."\">".$inhalt['beschreibung'] ."</option>\n";


		  }
		  return $ret;        
        }
        //return $ergebnis[0]['domain_name'];

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
 

}


function getAlleWochenplaene( ) {
	
		try {

		$sql = "SELECT r.rezept_id as rid, r.bezeichnung as rbez, r.beschreibung as rbes from rezept r, wochenplan w where r.rezept_id=w.rezept_id_mo or r.rezept_id=w.rezept_id_di or r.rezept_id=w.rezept_id_mi or r.rezept_id=w.rezept_id_do or r.rezept_id=w.rezept_id_fr and w.wochenplan_id=1";

        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {

	    
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">W o c h e n p l a n</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">

          </td>
           <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Rezept</td><td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Beschreibung</td></tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $rezept_id=$inhalt['rid'];
	            
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"auspraegung/".$rezept_id."\">".$inhalt['rbez']."</a>";
	            
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">'.$inhalt['rbes'].'</a>)</em></small></small>";
	            echo "</td><td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
	            echo "<br></td></tr>";
			



		  }
		  return $ergebnis;        
        }
        //return $ergebnis[0]['domain_name'];

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
 

}















function getAuspraegung( $id, $eigenschaft_id) {

	try {

		$sql = "Select wert from  auspraegung where domain_id=".$id." and eigenschaft_id = ".$eigenschaft_id." order by  auspraegung_id DESC limit 1" ;
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        $db=null;
        
        if ($ergebnis==null) return -1;
        return $ergebnis[0]['wert'];
    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    

 }




/***
�ltere Funktionen
**/



function getAktuellGenutzteLizenzen($id){
    
    try {
        
        /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
        
        /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
         * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zurückgegriffen werden.
         *
         */
        
        $sql = "Select tagesaktuelle_lizenzauswertung_innutzung from  liz_tagesaktuelle_lizenzauswertung where tagesaktuelle_lizenzauswertung_produkt_id=".$id;
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        
        //echo
        //echo "<br>";
        $db=null;
        
        
        return $ergebnis[0]['tagesaktuelle_lizenzauswertung_innutzung'];
        
    }
    
    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}



function getGesamtLizenzen($id) {
try {
    
    /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
    
    /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
     * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
     * Es wird daher auf eine solche Funktion zurückgegriffen werden.
     *
     */
    
    $sql = "Select tagesaktuelle_lizenzauswertung_gesamt from  liz_tagesaktuelle_lizenzauswertung where tagesaktuelle_lizenzauswertung_produkt_id=".$id;
    
    $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $rueckgabe = $db->query($sql);
    
    $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
    			
    //echo "<br>";
    $db=null;
    
    
    return $ergebnis[0]['tagesaktuelle_lizenzauswertung_gesamt'];
    
}

catch(PDOException $e){
    print $e->getMessage();
}
return -1;


}




function getTagesAktuelleLizenzAuswertungParentId($id){
    
    try {
        
        /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
        
        /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
         * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zurückgegriffen werden.
         *
         */
        
        $sql = "Select Max(tagesaktuelle_lizenzauswertung_id) from  liz_tagesaktuelle_lizenzauswertung where tagesaktuelle_lizenzauswertung_produkt_id=".$id;
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        
        //echo
        //echo "<br>";
        $db=null;
        
        
        return $ergebnis[0]['Max(tagesaktuelle_lizenzauswertung_id)'];
        
    }
    
    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}


function getTagesAktuelleLizenzAuswertungInitialId($id){
    
    try {
        
        /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
        
        /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
         * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zurückgegriffen werden.
         *
         */
        
        $sql = "Select tagesaktuelle_lizenzauswertung_lizenz_initial_id from  liz_tagesaktuelle_lizenzauswertung where tagesaktuelle_lizenzauswertung_produkt_id=".$id;
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        
        //echo
        //echo "<br>";
        $db=null;
        
        
        return $ergebnis[0]['tagesaktuelle_lizenzauswertung_lizenz_initial_id'];
        
    }
    
    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}


   
    
    
    
function getTagesAktuelleLizenzAuswertungLastId() {
        
        
        
        /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
        try {
            
            /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
            
            /* Das gefï¿½llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezï¿½hlt wird.
             * Was wir benï¿½tigen ist eine ï¿½bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
             * Es wird daher auf eine solche Funktion zurï¿½ckgegriffen werden.
             *
             */
            
            $sql = "Select MAX(tagesaktuelle_lizenzauswertung_id) from  liz_tagesaktuelle_lizenzauswertung";
            
           // echo "<br>".$sql."<br>";
            
            
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
            $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $rueckgabe = $db->query($sql);
            
            $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
            
            
            //echo "<br>";
            $db=null;
            
            
            $erg = $ergebnis[0]['MAX(tagesaktuelle_lizenzauswertung_id)'];
           // echo "<br>".$erg."<br>";
            
            return $erg;
        }
        
        catch(PDOException $e){
            print $e->getMessage();
        }
        return -1;
        
        
    }
    
    function setTagesAktuelleLizenzAuswertungInitialId() {
        
        
        
        $LastAnzahlId = getTagesAktuelleLizenzAuswertungLastId();
        
        //echo "<br>".$LastAnzahlId."<br>";
        
        /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
        try {
            
            /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
            
            /* Das gefï¿½llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezï¿½hlt wird.
             * Was wir benï¿½tigen ist eine ï¿½bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
             * Es wird daher auf eine solche Funktion zurï¿½ckgegriffen werden.
             *
             */
            
            $sql = "update liz_tagesaktuelle_lizenzauswertung set tagesaktuelle_lizenzauswertung_lizenz_initial_id=".$LastAnzahlId." where tagesaktuelle_lizenzauswertung_id=".$LastAnzahlId.";";
        
           // echo "<br>".$sql."<br>";
            
            
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
            
            $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->query($sql);
            
            
            
        }
        
        catch(PDOException $e){
            print $e->getMessage();
            //die();
        }
        return -1;
        
    }
    
    






function getNutzerName($id){
   
    try {
        
        /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
        
        /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
         * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zurückgegriffen werden.
         *
         */
        
        $sql = "Select ad_nutzer_name_vorname from  liz_adnutzer where adnutzer_id=".$id; 
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        
        //echo
        //echo "<br>";
        $db=null;
        
        
        return $ergebnis[0]['ad_nutzer_name_vorname'];
        
    }
    
    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}

function getCountProduktLizenz($id) {
    


	 /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
	 try {

         /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */

         /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
          * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zurückgegriffen werden.
          *
          */

          $sql = "Select Count(*) from liz_lizenz where produkt_id=".$id;

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $rueckgabe = $db->query($sql);

          $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);

          echo 
          //echo "<br>";
          $db=null;
               
          
          return $ergebnis[0]['Count(*)'];

       }
       
       catch(PDOException $e){
              print $e->getMessage();
       }
       return -1;

 
          /*
          die('ENDE !');





          echo "<table border=\"1\">";
          foreach ($ergebnis as  $inhalt)
          {
            echo "<tr><td class=\"odd\">";
             echo "<a href=\"../lizenzen/".$inhalt['hersteller_id']."\">".$inhalt['hersteller_name']."</a><br>";
            echo "</td></tr>";
              }

          }
          catch(PDOException $e){
              print $e->getMessage();
          }
          echo "</table>";
	     $db=null;
         */

 }
 
 
 
 function  getAlleHersteller() {


    try {

         //$sql = "Select lizenzart_id, lizenzart_bezeichnung, lizenzart_beschreibung, lizenzart_version from liz_lizenzart";
         $sql = "SELECT `hersteller_id`, `hersteller_name`, `hersteller_ort` FROM `liz_hersteller` WHERE `hersteller_aktiv`=1;";
                                                                                                                                
         $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $rueckgabe = $db->query($sql);

         $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);



        // Darstellung nur, wenn ein Ergebnis vorhanden ist

        if ($ergebnis){

             $ret="";
             foreach ($ergebnis as  $inhalt)
              {
                $ret=$ret."<option value=\"".$inhalt['hersteller_id']."\">".$inhalt['hersteller_name']." - ".$inhalt['hersteller_ort']."</option>\n";

              }
              return $ret;
              }
            $db=null;

         }


            catch(PDOException $e){
              print $e->getMessage();
            }

    return -1;

}

 
 
 
function  getAlleProdukte() {
    
 
    try {

         $sql = "Select produkt_id, produkt_bezeichnung, produkt_beschreibung, produkt_version from liz_produkt";

         $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $rueckgabe = $db->query($sql);

         $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);



        // Darstellung nur, wenn ein Ergebnis vorhanden ist

        if ($ergebnis){

             $ret="";
             foreach ($ergebnis as  $inhalt)
              {
                $ret=$ret."<option value=\"".$inhalt['produkt_id']."\">".$inhalt['produkt_bezeichnung']." - ".$inhalt['produkt_beschreibung']." ".$inhalt['produkt_version']."</option>\n";
               
              }
              return $ret;
              }
            $db=null;

         }


            catch(PDOException $e){
              print $e->getMessage();
            }
            
    return -1;           

} 


function  getAlleProduktGruppen() {


    try {

         $sql = "SELECT `produkt_gruppe_id`, `bezeichnung`, `kurzform` FROM `liz_produkt_gruppe` WHERE 1";

         $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $rueckgabe = $db->query($sql);

         $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);



        // Darstellung nur, wenn ein Ergebnis vorhanden ist

        if ($ergebnis){

             $ret="<option value=\"-1\"><em> - keine - </em></option>\n";
             foreach ($ergebnis as  $inhalt)
              {
                $ret=$ret."<option value=\"".$inhalt['produkt_gruppe_id']."\">".$inhalt['bezeichnung']." - ".$inhalt['kurzform']."</option>\n";

              }
              return $ret;
              }
            $db=null;

         }


            catch(PDOException $e){
              print $e->getMessage();
            }

    return -1;

}





function  getAlleLizenzArten() {


    try {

         $sql = "Select lizenzart_id, lizenzart_bezeichnung, lizenzart_beschreibung, lizenzart_version from liz_lizenzart";

         $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $rueckgabe = $db->query($sql);

         $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);



        // Darstellung nur, wenn ein Ergebnis vorhanden ist

        if ($ergebnis){

             $ret="";
             foreach ($ergebnis as  $inhalt)
              {
                $ret=$ret."<option value=\"".$inhalt['lizenzart_id']."\">".$inhalt['lizenzart_bezeichnung']." - ".$inhalt['lizenzart_beschreibung']."</option>\n";

              }
              return $ret;
              }
            $db=null;

         }


            catch(PDOException $e){
              print $e->getMessage();
            }

    return -1;

}

 



function getLastLizenzId() {



	 /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
	 try {

         /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */

         /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
          * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zurückgegriffen werden.
          *
          */

          $sql = "Select MAX(lizenz_id) from liz_lizenz";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $rueckgabe = $db->query($sql);

          $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);

          echo
          //echo "<br>";
          $db=null;


          return $ergebnis[0]['MAX(lizenz_id)'];

       }

       catch(PDOException $e){
              print $e->getMessage();
       }
       return -1;


 }
 
 
 function getLastAnzahlLizenzId() {



	 /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
	 try {

         /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */

         /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
          * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zurückgegriffen werden.
          *
          */

          $sql = "Select MAX(anzahl_lizenz_id) from liz_anzahl_lizenz";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $rueckgabe = $db->query($sql);

          $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);

          echo
          //echo "<br>";
          $db=null;


          return $ergebnis[0]['MAX(anzahl_lizenz_id)'];

       }

       catch(PDOException $e){
              print $e->getMessage();
       }
       return -1;


 }

 function SetAnzahlLizenz_InitialId() {



     $LastAnzahlLizenzId = getLastAnzahlLizenzId();

	 /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
	 try {

         /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */

         /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
          * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zurückgegriffen werden.
          *
          */

          $sql = "update liz_anzahl_lizenz set anzahl_lizenz_initial_id=".$LastAnzahlLizenzId." where anzahl_lizenz_id=".$LastAnzahlLizenzId.";";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );

          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);



       }

       catch(PDOException $e){
              print $e->getMessage();
              //die();
       }
       return -1;

  }





 
 function getStringAsUTF8($string) {
 
    if(mb_detect_encoding($string) != 'UTF-8') {          $string = utf8_encode($string); }
    return $string; 
 }
 
 
 
 function getUmlauteArray() { 
 
    return array( 'Ã¼'=>'ü', 'Ã¤'=>'ä', 'Ã¶'=>'ö', 'Ã–'=>'Ö', 'ÃŸ'=>'ß', 'Ã '=>'à', 'Ã¡'=>'á', 'Ã¢'=>'â', 'Ã£'=>'ã', 'Ã¹'=>'ù', 'Ãº'=>'ú', 'Ã»'=>'û', 
                  'Ã™'=>'Ù', 'Ãš'=>'Ú', 'Ã›'=>'Û', 'Ãœ'=>'Ü', 'Ã²'=>'ò', 'Ã³'=>'ó', 'Ã´'=>'ô', 'Ã¨'=>'è', 'Ã©'=>'é', 'Ãª'=>'ê', 'Ã«'=>'ë', 'Ã€'=>'À',
                  'Ã�'=>'�?', 'Ã‚'=>'Â', 'Ãƒ'=>'Ã', 'Ã„'=>'Ä', 'Ã…'=>'Å', 'Ã‡'=>'Ç', 'Ãˆ'=>'È', 'Ã‰'=>'É', 'ÃŠ'=>'Ê', 'Ã‹'=>'Ë', 'ÃŒ'=>'Ì', 'Ã�'=>'�?', 
                  'ÃŽ'=>'Î', 'Ã�'=>'�?', 'Ã‘'=>'Ñ', 'Ã’'=>'Ò', 'Ã“'=>'Ó', 'Ã�?'=>'Ô', 'Ã•'=>'Õ', 'Ã˜'=>'Ø', 'Ã¥'=>'å', 'Ã¦'=>'æ', 'Ã§'=>'ç', 'Ã¬'=>'ì', 
                  'Ã­'=>'í', 'Ã®'=>'î', 'Ã¯'=>'ï', 'Ã°'=>'ð', 'Ã±'=>'ñ', 'Ãµ'=>'õ', 'Ã¸'=>'ø', 'Ã½'=>'ý', 'Ã¿'=>'ÿ', 'â‚¬'=>'€' );
 
 }
    
    
function fixeUmlauteDb() {                  
  
   $umlaute = $this->getUmlauteArray();                  
   foreach ($umlaute as $key => $value){                                        
   
     $sql = "UPDATE table SET tracks = REPLACE(row, '{$key}', '{$value}') WHERE row LIKE '%{$key}%'";                   
   } 
 }
 

?>