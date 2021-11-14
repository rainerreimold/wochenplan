<?php
/*****************************************************************************


 speisekomponenten-aendern

 
 Datum 22.09.2021 

*****************************************************************************/


 include 'inc/header.php';

		 echo '<h1 style="background: olive; color: orange;
	             padding:20px; margin:20px;">'.getSpeiseKomponenteBezeichnung($id).'</h1>';


		 //echo '<div class="eyecatch block">Das Anlegen - Bearbeiten - einer Speisekomponente ist etwas abstrakt.....
		 //	</div>'; 

        /* Jetzt müssen die Daten aus der DB gelesen werden */ 

		 try {
		

  			$sql="SELECT distinct lm.bezeichnung as bez,
				max(lmskv.lm_sk_verbindung_id) as verbId,
				lmskv.initial_id as initialId,
				lmskv.parent_id as parentId,
				lmskv.menge as meng,
				lmskv.einheit as einh	
			 FROM 
				`lm_sk_verbindung` lmskv,
				 `lebensmittel` lm
			 WHERE 
				`speisekomponente_id` = ".$id."
			 and
				lm.lebensmittel_id in (select  lebensmittel_id From lm_sk_verbindung 
				group by initial_id )
			 and 
				lm.lebensmittel_id = lmskv.lebensmittel_id
			 group by lmskv.lebensmittel_id
			 order by lmskv.lm_sk_verbindung_id asc";



		 	//if (DEBUG) echo "<br>".$sql."<br>";
       
	 
         	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
         	$rueckgabe = $db->query($sql);
          
		 	$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
		 
			// print count($ergebnis);
	     
   			// die();

			echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
			echo "<form method=\"post\" action=\"eintragen\" style=\"width:700px; padding:10px; margin:10px;\">";
			
			//Tabellenkopf..

			echo '<table class="editable" border=0 >';
			echo '	<tr>';
			echo '		<th>Bezeichnung</th>';
			echo '		<th>Menge</th>';
			echo '		<th>Einheit</th>';
			echo '		<th>l&ouml;schen</th>';
			echo '	</tr>';
	
		 	foreach ($ergebnis as  $inhalt)
	     	{
	            $lm_sk_verbindung_id			= $inhalt['verbId'];
				$lm_sk_verbindung_initial_id	= $inhalt['initialId'];
				$lm_sk_verbindung_parent_id		= $inhalt['parentId'];
				$bezeichnung 					= $inhalt['bez'];
				$menge							= $inhalt['meng'];
				$einheit						= $inhalt['einh'];
				echo '	<tr>';
				echo '		<td border=1 style="backgroundcolor:white;color:black;"><input type="text" name="bezeichnung[]" value="'.$bezeichnung.'" /></td>';
				echo '		<td border=1 style="backgroundcolor:white;color:black;"><input style="width:100px;" type="text" name="menge[]" value="'.$menge.'" /></td>';	
				echo '		<td border=1 style="backgroundcolor:white;color:black;"><input style="width:100px;" type="text" name="einheit[]" value="'.$einheit.'" /></td>';
				echo '		<td border=1 style="backgroundcolor:white;color:black;">
							<a href="loeschen/'.$lm_sk_verbindung_id.'/'.$lm_sk_verbindung_initial_id.'/'.$lm_sk_verbindung_parent_id.'">
							<span class="glyphicon glyphicon-remove"></span></a></td>';
				echo '	</tr>';
	        }    
	 	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
		echo "<button type=\"submit\">Absenden</button>";
        echo "</form>";
		echo "</div>";
	    $db=null;
		
		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}

		include 'inc/footer.php';