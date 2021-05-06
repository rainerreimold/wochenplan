<?php

/*******




****/


function getLebensmittelHauptKategorie() {

	try {

		$sql = "SELECT 	lebensmittelhauptkategorie_id as lmid,
						lebensmittelhauptkategorie_hash as lmhash,
						lebensmittelhauptkategorie_bezeichnung as lmbez
		FROM `lebensmittelhauptkategorie` 
		order by lebensmittelhauptkategorie_bezeichnung asc";
        
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
		  
			$selected=$inhalt['lmbez']=='Gem&uuml;se'?" selected":" ";
			$ret=$ret."<option".$selected." value=\"".$inhalt['lmhash']."\">".$inhalt['lmbez']."</option>\n";


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


function getLebensmittelUnterKategorie() {

	try {
	

		$sql = "SELECT 	lebensmittelunterkategorie_id as lmuid,
						lebensmittelunterkategorie_hash as lmhash,
						lebensmittelunterkategorie_bezeichnung as lmbez,
						lebensmittelhauptkategorie_id as lmhid
		FROM `lebensmittelunterkategorie` 
		order by lebensmittelunterkategorie_bezeichnung asc";
        
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
		  
			$selected=$inhalt['lmbez']=='Gem&uuml;se'?" selected":" ";
			$ret=$ret."<option".$selected." value=\"".$inhalt['lmhash']."\">".$inhalt['lmbez']."</option>\n";


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
				
			$ret=$ret."<option value=\"".$inhalt['ingredienz_id']."\" title=\"".$inhalt['beschreibung'] ."\">".$inhalt['bezeichnung'] ."</option>\n";


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


	function zeileDesWochenPlan( $rezbez, $rezid, $zaehl, $last_rezid ) {
    			$wp_id=1;
				echo "\n";
	            echo "<tr style=\"padding:8px;border:1px dotted black;\">";
				echo "\n";
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\">";
	            echo "\n";
			
				//if($zaehl%5==1){
				//	$wt="Mo";
				//}
				switch ($zaehl%7) {
					case 0:
					  $wt="Mo";
					  break;						
					case 1:
					  $wt="Di";
					  break;
					case 2:
					  $wt="Mi";
					  break;
					case 3:
					  $wt="Do";
					  break;
					case 4:
					  $wt="Fr";
					  break;
					case 5:
					  $wt="Sa";
					  break;
				    case 6:
					  $wt="So";
					  break;
				}

	            echo "<a href=\"../rezept/$rezid\">
				 <small><strong style=\"color:black;\">".$wt."</strong></small></td>";
				echo "\n";
				echo "<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">
				  ".$rezbez."</a>";
				echo "\n";
	            
	            
	 
           
               
	            echo "</td>";
			    echo "\n";
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				
				/* ******************************************* */

				echo "\n";	
	          //  if($zaehl%5!=0) {
			//		
			//		echo "<a href=\"wechselhoch/".$wp_id."/".$rezid."/".$last_rezid."/".$wt."\"><span class=\"glyphicon glyphicon-arrow-up\"></span></a>";
			//	}
				echo "\n";
				echo "</td>";
				echo "\n";
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";

				
				if ($zaehl%5!=6) {
				
					echo "<a href=\"wechselrunter/".$wp_id."/".$rezid."/".$last_rezid."/".$wt."\"><span class=\"glyphicon glyphicon-arrow-down\"></span></a>";
				}
				echo "\n";
				echo "<br></td></tr>";
				echo "\n";
			   
      }






function isRecipeExist( $rezept ) {

	try {
		$sql= "SELECT rezept_id FROM `rezept` WHERE bezeichnung=\"".$rezept."\";";

     	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        $db=null;
        
        if ($ergebnis==null) return null;
        	return $ergebnis[0]['rezept_id'];
    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return null;

}

function getLastRezeptId(  ) {

	try {
		$sql= "SELECT rezept_id  FROM `rezept` order by rezept_id desc limit 1;";

     	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        $db=null;
        
        if ($ergebnis==null) return null;
        	return $ergebnis[0]['rezept_id'];
    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return null;

}



function setRezeptInitialId($rezeptId) {
        
        try {
            
            $sql = "update rezept set initial_id=".$rezeptId." where rezept_id=".$rezeptId.";";
        
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



function getBezeichnungSpeisekomponente ($sk_id) {

	try {
		$sql= "SELECT bezeichnung  FROM `speisekomponente` where speisekomponente_id=".$sk_id;

     	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        $db=null;
        
        if ($ergebnis==null) return null;
        	return $ergebnis[0]['bezeichnung'];
    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return null;

}


	
/************************************************************
Parameter: 
  $wt = Wochentag Format mo,di,mi
  $wp_id = WochenplanID für den die Änderung erfolgen soll
  $upOrDown = true -> up false -> down
  
*************************************************************/ 


function wechselPositionSpeiseplan( $wt, $wp_id, $upOrDown) {

  $lwt = strtolower($wt);
  $change_wt = $lwt;
  //echo "Wochentag: ".$lwt."<br>\n";
  //echo "Wechseltag: ".$change_wt."<br>\n";
  //echo "upOrDown: ".$upOrDown."<br>\n";

  if ($upOrDown == 1) {

/**	if ( $lwt == 'mo' ) $change_wt='di';
	elseif ( $lwt == "di") $change_wt='mi';
**/
	//echo "<br><br>".'->lwt: '.$lwt.' == "mi" - wenn gleich dann Bedingung erfüllt'."<br><br>";
	/**** Der Switch Case funktioniert nicht **/
   // echo "2.Wochentag: ".$lwt."<br>\n";
    switch($lwt){
      case 'mo':
          $change_wt='di';
		  break;
      case "di":
          $change_wt='mi';
		  break;
      case "mi":
          $change_wt='do';
		  break;
      case 'do':
          $change_wt='fr';
		  break;
      case 'fr':
          $change_wt='sa';
		  break;
      case 'sa':
          $change_wt='so';
		  break;
      default:
		  $change_wt='unerfüllt';
		  break;      
    } 
   /* */
	//echo "change: ".$change_wt."<br>\n";
  } else {
  /*** */
    switch($lwt) {
      case 'so':
          $change_wt='sa';
		  break;
      case 'sa':
          $change_wt='fr';
		  break;
      case 'fr':
          $change_wt='do';
		  break;
      case 'do':
          $change_wt='mi';
		  break;
      case 'mi':
          $change_wt='di';
		  break;
      case "di":
          $change_wt='mo';
		  break;            
    }
	//echo "\n<br>change: ".$change_wt."<br>\n";
 /*  **/
  }  // end if
  
 


 // echo "change: ".$change_wt."<br>\n";
  try {

	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        		
    $db->beginTransaction();	

    $sql="select @rezept_id_change:=rezept_id_".$lwt." from wochenplan where wochenplan_id=".$wp_id."; 
		update wochenplan set `rezept_id_".$lwt."`=`rezept_id_".$change_wt."`,`rezept_id_".$change_wt."`=@rezept_id_change where wochenplan_id=".$wp_id;
   
    print "SQL: ".$sql."<br>\n";

	die();

	$db->query($sql);
    $db->commit();
	$db=null;
  }
  catch(PDOException $e){
    print "<br>".$e->getMessage();
  }

}


	
function bestellzettelEintragExist($bestellzettel_id, $ingredienz_id) {

	try {
		$sql= "select bestellzetteleintrag_id from bestellzetteleintrag where bestellzettel_id=".$bestellzettel_id." and ingredienz_id =".$ingredienz_id;


     	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        $db=null;
        
        if ($ergebnis==null) return null;
        	return $ergebnis[0]['bestellzetteleintrag_id'];
    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return null;

}




/********************************************************************************************************************************************** */


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
?ltere Funktionen
**/



function getAktuellGenutzteLizenzen($id){
    
    try {
        
        /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
        
        /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
         * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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
    
    /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
     * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
     * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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
        
        /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
         * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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
        
        /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
         * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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
            
            /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
             * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
             * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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
            
            /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
             * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
             * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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
        
        /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
         * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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

         /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
          * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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

         /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
          * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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

         /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
          * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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

         /* Das gef�llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gez�hlt wird.
          * Was wir ben�tigen ist eine �bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zur�ckgegriffen werden.
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
 
    return array( 'ü'=>'�', 'ä'=>'�', 'ö'=>'�', 'Ö'=>'�', 'ß'=>'�', '� '=>'�', 'á'=>'�', 'â'=>'�', 'ã'=>'�', 'ù'=>'�', 'ú'=>'�', 'û'=>'�', 
                  'Ù'=>'�', 'Ú'=>'�', 'Û'=>'�', 'Ü'=>'�', 'ò'=>'�', 'ó'=>'�', 'ô'=>'�', 'è'=>'�', 'é'=>'�', 'ê'=>'�', 'ë'=>'�', 'À'=>'�',
                  '�?'=>'??', 'Â'=>'�', 'Ã'=>'�', 'Ä'=>'�', 'Å'=>'�', 'Ç'=>'�', 'È'=>'�', 'É'=>'�', 'Ê'=>'�', 'Ë'=>'�', 'Ì'=>'�', '�?'=>'??', 
                  'Î'=>'�', '�?'=>'??', 'Ñ'=>'�', 'Ò'=>'�', 'Ó'=>'�', '�??'=>'�', 'Õ'=>'�', 'Ø'=>'�', 'å'=>'�', 'æ'=>'�', 'ç'=>'�', 'ì'=>'�', 
                  'í'=>'�', 'î'=>'�', 'ï'=>'�', 'ð'=>'�', 'ñ'=>'�', 'õ'=>'�', 'ø'=>'�', 'ý'=>'�', 'ÿ'=>'�', '€'=>'�' );
 
 }
    
    
function fixeUmlauteDb() {                  
  
   $umlaute = $this->getUmlauteArray();                  
   foreach ($umlaute as $key => $value){                                        
   
     $sql = "UPDATE table SET tracks = REPLACE(row, '{$key}', '{$value}') WHERE row LIKE '%{$key}%'";                   
   } 
 }
 

/*** 
Die Funktion als Vorlage aus dem Projekt Handwerker-Landkreise

Wichtig ist aber, dass diese PHP-Funktion das Javascript dynamisch nach dem Inhalt der Tabelle Lebensmittelunterkategorie generiert

Autor: Rainer  
Datum:20.04.2021

*/

function pullDownChange() {




/*** für jede Hauptkategorie eine Außenschleife **/
/*
if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "1")
{
	a=0;	
*/
/***  hier eine Innenschleife **/
/*	unterkategorieAuswahl.options[a] = new Option("Altmarkkreis Salzwedel [Salzwedel]");a=a+1;

*/




###################################################################################

return '<script language="Javascript">
			
				// Start 
function update_auswahl()
{
c=0;
kategorieAuswahl = document.forms.verzeichnis.lebensmittelhauptkategorie;
unterkategorieAuswahl = document.forms.verzeichnis.lebensmittelunterkategorie;
unterkategorieAuswahl.options.length = 0; // DropDown Menü entleer	


// Sachsen-Anhalt				
if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "1")
{
	a=0;	
	unterkategorieAuswahl.options[a] = new Option("Altmarkkreis Salzwedel [Salzwedel]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Anhalt-Zerbst [Zerbst]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Aschersleben-Staßfurt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bernburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bitterfeld");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bördekreis [Oschersleben]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Burgenlandkreis [Naumburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Halberstadt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Jerichower Land [Burg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Köthen/Anhalt [Köthen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Mansfelder Land [Eisleben]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Merseburg-Querfurt [Merseburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ohrekreis [Haldensleben]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Quedlinburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Saalkreis [Halle]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Sangerhausen");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Schönebeck");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Stendal");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Weißenfels");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wernigerode");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wittenberg");a=a+1;
	
	unterkategorieAuswahl.options[a] = new Option("Dessau");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Halle [Saale]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Magdeburg");a=a+1;	
}
// Sachsen
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "2")
{	
	a=0;	
	unterkategorieAuswahl.options[a] = new Option("Annaberg [Annaberg-Buchholz]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Aue-Schwarzenberg [Aue]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bautzen");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Chemnitzer Land [Glauchau]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Delitzsch ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Döbeln");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Freiberg");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Kamenz ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Leipziger Land [Leipzig]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Löbau-Zittau [Zittau]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Meißen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Mittlerer Erzgebirgskreis [Marienberg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Mittweida");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Muldentalkreis [Grimma]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Niederschlesischer Oberlausitzkreis [Niesky]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Riesa-Großenhain [Großenhain]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Sächsische Schweiz [Pirna]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Stollberg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Torgau-Oschatz [Torgau]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Vogtlandkreis [Plauen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Weißeritzkreis [Dippoldiswalde]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option(" Zwickauer Land [Werdau]");a=a+1;
	
	unterkategorieAuswahl.options[a] = new Option("Chemnitz");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Dresden");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Görlitz");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Hoyerswerda");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Plauen");a=a+1;
}
// Thüringen
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "3")
{
	a=0;	
	unterkategorieAuswahl.options[a] = new Option("Altenburger Land [Altenburg]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Eichsfeld [Heiligenstadt]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Gotha");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Greiz");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Hildburghausen");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Ilm-Kreis [Arnstadt]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Kyffhäuser-Kreis [Sondershausen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Nordhausen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Saale-Holzland-Kreis [Eisenberg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Saale-Orla-Kreis [Schleiz]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Saalfeld-Rudolstadt [Saalfeld]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Schmalkalden-Meiningen [Meiningen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Sömmerda");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Sonneberg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Unstrut-Hainich-Kreis [Mühlhausen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wartburgkreis [Bad Salzungen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Weimarer Land [Apolda]");a=a+1;
		
	unterkategorieAuswahl.options[a] = new Option("Eisenach");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Erfurt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Gera");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Jena");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Suhl");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Weimar");a=a+1;
	
}
// Bayern
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "4"){
	a=0;		
	unterkategorieAuswahl.options[a] = new Option("Aichach-Friedberg [Aichach]");a=a+1;	 
	unterkategorieAuswahl.options[a] = new Option("Altötting");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Amberg-Sulzbach [Amberg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ansbach");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Aschaffenburg");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Augsburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bad Kissingen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bad Tölz-Wolfratshausen [Bad Tölz]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bamberg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bayreuth");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Berchtesgadener Land [Bad Reichenhall]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Cham");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Coburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Dachau");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Deggendorf");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Dillingen a.d. Donau");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Dingolfing-Landau [Dingolfing]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Donau-Ries [Donauwörth]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ebersberg");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Eichstätt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Erding");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Erlangen-Höchstadt [Erlangen]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Forchheim");a=a+1;	 
	unterkategorieAuswahl.options[a] = new Option("Freising ");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Freyung-Grafenau [Freyung]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Fürstenfeldbruck");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Fürth");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Garmisch-Partenkirchen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Günzburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Haßberge [Haßfurt]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Hof");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kelheim");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kitzingen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kronach");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kulmbach");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Landsberg am Lech ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Landshut");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Lichtenfels ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Lindau (Bodensee)");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Main-Spessart [Karlstadt]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Miesbach");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Miltenberg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Mühldorf am Inn");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("München");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Neuburg-Schrobenhausen [Neuburg an der Donau]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Neumarkt/Oberpfalz");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Neustadt a.d. Waldnaab");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Neustadt/Aisch-Bad Windsheim [Neustadt a.d. Aisch]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Neu-Ulm");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Nürnberger Land [Lauf a.d. Pegnitz]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Oberallgäu [Sonthofen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ostallgäu [Marktoberdorf]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Passau");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Pfaffenhofen a. d. Ilm");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Regen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Regensburg");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Rhön-Grabfeld [Bad Neustadt a.d. Saale]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rosenheim");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Roth");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rottal-Inn [Pfarrkirchen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Schwandorf");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Schweinfurt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Starnberg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Straubing-Bogen [Straubing]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Tirschenreuth");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Traunstein");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Unterallgäu [Mindelheim]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Weilheim-Schongau [Weilheim/Obb.]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Weißenburg-Gunzenhausen [Weißenburg i. Bay.]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wunsiedel/Fichtelgeb.");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Würzburg");a=a+1;
	
	unterkategorieAuswahl.options[a] = new Option("Bayreuth");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Coburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Erlangen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ingolstadt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kempten [Allgäu]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kaufbeuren");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Memmingen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Nürnberg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Schwabach");a=a+1;	
}
//Schleswig-Holstein
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "5"){	
	a=0;		
	unterkategorieAuswahl.options[a] = new Option("Dithmarschen [Heide]");a=a+1;	 
	unterkategorieAuswahl.options[a] = new Option("Herzogtum Lauenburg [Ratzeburg]");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Nordfriesland [Husum]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ostholstein [Eutin]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Pinneberg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Pön");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Rendsburg-Eckernförde [Rendsburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Schleswig-Flensburg [Schleswig]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Segeberg [Bad Segeberg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Steinburg [Itzehoe]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Stormarn [Bad Oldesloe]");a=a+1;
	
	unterkategorieAuswahl.options[a] = new Option("Flensburg");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Hansestadt Lübeck");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Kiel");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Neumünster");a=a+1;
}
//Niedersachsen
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "6"){
	a=0;			
	unterkategorieAuswahl.options[a] = new Option("Ammerland [Westerstede]");	 a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Aurich");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Celle");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Cloppenburg ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Cuxhaven");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Diepholz");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Emsland [Meppen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Friesland [Jever]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Gifhorn ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Goslar");	 a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Göttingen");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Grafschaft Bentheim [Nordhorn]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Hameln-Pyrmont [Hameln]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Hannover");	 a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Harburg [Winsen (Luhe)]");a=a+1;	    		 
	unterkategorieAuswahl.options[a] = new Option("Helmstedt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Hildesheim");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Holzminden");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Leer");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Lüchow-Dannenberg [Lüchow]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Lüneburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Nienburg / Weser [Nienburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Northeim");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Oldenburg [Wildeshausen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Osnabrück");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Osterholz [Osterholz-Scharmbeck]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Osterode am Harz");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Peine");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Rotenburg (Wümme)");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Schaumburg [Stadthagen]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Soltau-Fallingbostel [Fallingbostel]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Stade");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Uelzen");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Vechta");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Verden [Verden (Aller)]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wesermarsch [Brake]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wittmund");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wolfenbüttel");a=a+1;
	
	unterkategorieAuswahl.options[a] = new Option("Braunschweig");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Delmenhorst");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Emden");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Salzgitter");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wilhelmshaven");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wolfsburg");a=a+1;		
	
}
//Bremen
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "7"){	
	a=0;		
	unterkategorieAuswahl.options[a] = new Option("Hansestadt Bremen");a=a+1; }
//Hamburg
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "8"){
	a=0;			
	unterkategorieAuswahl.options[a] = new Option("Hansestadt Hamburg");a=a+1;	
}
// Nordrheinwestfalen
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "9"){		
	a=0;
	unterkategorieAuswahl.options[a] = new Option("Aachen");a=a+1;	 
	unterkategorieAuswahl.options[a] = new Option("Borken");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Coesfeld ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Düren");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ennepe-Ruhr-Kreis [Schwelm]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Euskirchen ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Gütersloh");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Heinsberg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Herford");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Hochsauerlandkreis [Meschede]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Höxter");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kleve");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Lippe [Detmold]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Märkischer Kreis [Lüdenscheid]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Mettmann");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Minden-Lübbecke [Minden]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Oberbergischer Kreis [Gummersbach]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Olpe");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Paderborn");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Recklinghausen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rheinisch-Bergischer-Kreis [Bergisch-Gladbach]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rhein-Erft-Kreis [Bergheim]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rhein-Kreis Neuss [Grevenbroich]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rhein-Sieg-Kreis [Siegburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Siegen-Wittgenstein [Siegen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Soest");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Steinfurt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Unna");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Viersen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Warendorf");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wesel");a=a+1;
	
	
	unterkategorieAuswahl.options[a] = new Option("Bielefeld");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bonn");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bochum");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bottrop");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Düsseldorf");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Dortmund");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Duisburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Essen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Gelsenkirchen");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Hagen [Westfalen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Hamm [Westfalen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Herne");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Köln");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Krefeld");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Leverkusen");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Mönchengladbach");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Mülheim [Ruhr]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Münster [Westfalen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Oberhausen [Rheinland]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Remscheid");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Solingen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wuppertal");a=a+1;

}
//Mecklenburg-Vorpommern
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "10"){
	a=0;			
	unterkategorieAuswahl.options[a] = new Option("Bad Doberan");a=a+1;	 
	unterkategorieAuswahl.options[a] = new Option("Demmin");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Güstrow ");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Ludwigslust");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Mecklenburg-Strelitz [Neustrelitz]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Müritz [Waren]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Nordvorpommern [Grimmen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Nordwestmecklenburg [Grevesmühlen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ostvorpommern [Anklam]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Parchim");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rügen [Bergen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Uecker-Randow [Pasewalk]");a=a+1;
	
	unterkategorieAuswahl.options[a] = new Option("Hansestadt Greifswald");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Hansestadt Rostock");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Hansestadt Stralsund");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Hansestadt Wismar");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Neubrandenburg");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Schwerin");a=a+1;

}
//Berlin
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "11"){	
	a=0;		
	unterkategorieAuswahl.options[a] = new Option("Berlin");a=a+1;	 
}
//Brandenburg
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "12"){
	a=0;			
	unterkategorieAuswahl.options[a] = new Option("Barnim [Eberswalde]");a=a+1;	 
	unterkategorieAuswahl.options[a] = new Option("Dahme-Spreewald [Lübben]");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Elbe-Elster [Herzberg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Havelland [Rathenow]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Märkisch-Oderland [Seelow]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Oberhavel [Oranienburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Oberspreewald-Lausitz [Senftenberg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Oder-Spree [Beeskow]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ostprignitz-Ruppin [Neuruppin]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Potsdam-Mittelmark [Belzig]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Prignitz [Perleberg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Spree-Neiße [Forst]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Teltow-Fläming [Luckenwalde]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Uckermark [Prenzlau]");a=a+1;
	
	
	unterkategorieAuswahl.options[a] = new Option("Brandenburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Cottbus");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Frankfurt [Oder]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Potsdam");a=a+1;

	
}
//Hessen
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "13"){
	a=0;			
	unterkategorieAuswahl.options[a] = new Option("Bergstraße [Heppenheim]");a=a+1;	 
	unterkategorieAuswahl.options[a] = new Option("Darmstadt-Dieburg [Darmstadt]");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Fulda");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Gießen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Groß-Gerau");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Hersfeld-Rotenburg [Bad Hersfeld]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Hochtaunuskreis [Bad Homburg v. d. Höhe]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kassel");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Lahn-Dill-Kreis [Wetzlar]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Limburg-Weilburg [Limburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Main-Kinzig-Kreis [Hanau]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Main-Taunus-Kreis [Hofheim / Ts.]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Marburg-Biedenkopf [Marburg-Cappel]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Neuwied");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Odenwaldkreis [Erbach / Odw.]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Offenbach [Dietzenbach]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rheingau-Taunus-Kreis [Bad Schwalbach]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Schwalm-Eder-Kreis [Homberg / Efze]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Vogelsbergkreis [Lauterbach]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Waldeck-Frankenberg [Korbach]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Werra-Meißner-Kreis [Eschwege]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wetteraukreis [Friedberg]");a=a+1;
	
	unterkategorieAuswahl.options[a] = new Option("Darmstadt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Frankfurt am Main");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Wiesbaden");a=a+1;
			
}
//Rheinlandpfalz
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "14"){	
	a=0;	
	unterkategorieAuswahl.options[a] = new Option("Ahrweiler [Bad Neuenahr-Ahrweiler]"); a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Altenkirchen ");a=a+1;	    	 
	unterkategorieAuswahl.options[a] = new Option("Alzey-Worms [Alzey]");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Bad Dürkheim");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bad Kreuznach");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bernkastel-Wittlich [Wittlich]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Birkenfeld");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bitburg-Prüm [Bitburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Cochem-Zell [Cochem]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Daun");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Donnersbergkreis [Kirchheimbolanden]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Daun");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Germersheim ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kaiserslautern");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Kusel");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Mainz-Bingen [Ingelheim]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Mayen-Koblenz [Koblenz]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rhein-Hunsrück-Kreis [Simmern]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rhein-Lahn-Kreis [Bad Ems]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rhein-Pfalz-Kreis [Ludwigshafen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Südliche Weinstraße [Landau]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Südwestpfalz [Pirmasens]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Trier-Saarburg [Trier]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Westerwaldkreis [Montabaur]");a=a+1;
	
	unterkategorieAuswahl.options[a] = new Option("Frankenthal [Pfalz]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Koblenz");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Landau [Pfalz]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Neustadt [Weinstraße]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Speyer");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Worms");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Zweibrücken");a=a+1;	
	

}
//Saarland
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "15"){
	a=0;		
	unterkategorieAuswahl.options[a] = new Option("Merzig-Wadern [Merzig]");a=a+1;	 
	unterkategorieAuswahl.options[a] = new Option("Neunkirchen [Ottweiler]");a=a+1;    	 
	unterkategorieAuswahl.options[a] = new Option("Saarlouis");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Saarpfalz-Kreis [Homburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("St. Wendel");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Stadtverband Saarbrücken [Saarbrücken]");a=a+1;
	
	
	unterkategorieAuswahl.options[a] = new Option("St.Ingbert");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Völklingen");a=a+1;
	
}
//Baden-Würtemberg
else if (kategorieAuswahl.options[kategorieAuswahl.selectedIndex].value == "16"){	
	a=0;	
	unterkategorieAuswahl.options[a] = new Option("Alb-Donau-Kreis [Ulm]");a=a+1;	 
	unterkategorieAuswahl.options[a] = new Option("Biberach");a=a+1;;	    	 
	unterkategorieAuswahl.options[a] = new Option("Böblingen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Bodenseekreis [Friedrichshafen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Breisgau-Hochschwarzwald [Freiburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Calw");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Emmendingen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Enzkreis [Pforzheim]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Esslingen ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Freudenstadt");a=a+1;		 
	unterkategorieAuswahl.options[a] = new Option("Göppingen ");a=a+1;   	 
	unterkategorieAuswahl.options[a] = new Option("Heidenheim");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Heilbronn");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Hohenlohekreis [Künzelsau]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Karlsruhe");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Konstanz");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Lörrach");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ludwigsburg ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Main-Tauber-Kreis [Tauberbischofsheim]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Neckar-Odenwald-Kreis [Mosbach]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ortenaukreis [Offenburg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ostalbkreis [Aalen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rastatt");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Ravensburg");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rems-Murr-Kreis [Waiblingen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Reutlingen");a=a+1;	
	unterkategorieAuswahl.options[a] = new Option("Rhein-Neckar-Kreis [Heidelberg]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Rottweil");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Schwäbisch-Hall");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Schwarzwald-Baar-Kreis [Villingen-Schwenningen]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Sigmaringen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Tübingen");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Tuttlingen ");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Waldshut");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Zollernalbkreis [Balingen]");a=a+1;
	
	
	unterkategorieAuswahl.options[a] = new Option("Baden-Baden");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Freiburg [Breisgau]");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Mannheim");a=a+1;
	unterkategorieAuswahl.options[a] = new Option("Stuttgart");a=a+1;

	 
}
}
// ENDE
 </script>
';
}



?>