<?php
 include 'inc/header.php';
	        
        

       try {

		// Es werden die id, speise_id, und Positionen ausgelesen.		
		// Das ergibt aber nur Zahlen... Die Speise muss intern ausgelesen werden.
   	    $sql = "select wochenplanspeise_id as wpsid, position as pos, speise_id as spid  from wochenplanspeise where wochenplan_id=1 order by position";
		$oLog = new Log();
     	$oLog->writeSqlLog("##########################\n".$sql."\n");	

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($sql);
          
		$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	    echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	    echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Wochenpl&auml;ne</th></tr>';
		$zaehl=-1;	
	    // Auswertung
		foreach ($ergebnis as  $inhalt)
	    {	
			$wochenplanspeise_id = $inhalt['wpsid'];
			$wochenplan = $inhalt['pos']; // pos
			switch ($wochenplan) {
					case 1:
					  $wt="Montag";
					  break;						
					case 2:
					  $wt="Dienstag";
					  break;
					case 3:
					  $wt="Mittwoch";
					  break;
					case 4:
					  $wt="Donnerstag";
					  break;
					case 5:
					  $wt="Freitag";
					  break;
					case 6:
					  $wt="Samstag";
					  break;
					case 7:
					  $wt="Sonntag";
					  break;
				}
	
			
			$position = $inhalt['pos']; 	// position
			$spid = $inhalt['spid'];		// speise_id
			
			/**************************************

			  bis hierhin ... das SQL Statement muss noch angepasst werden

			***************************************/


	 	    $sql2 = "select speise_id, bezeichnung, aktiv, loeschbar from speise where speise_id=".$spid." and  aktiv=1 and loeschbar=0;";
			$oLog->writeSqlLog("##########################\n".$sql2."\n");
			$rueckgabe2 = $db->query($sql2);         
		  	$ergebnis2 = $rueckgabe2->fetchAll(PDO::FETCH_ASSOC);
	
			
			foreach ($ergebnis2 as  $inhalt2)
		    {
			    ++$zaehl;
				//echo "<tr  style=\"padding:8px;\">";
				//echo "<td colspan=\"3\" style=\"background:darkgrey;a color:orange;\" class=\"odd\">".$wt."</td></tr>";
      			//echo "<a href=\"../speisebestandteil/details/".$inhalt2['speise_id']."\">".$inhalt2['bezeichnung']."</a>";
	            	echo "\n";
				echo "</td>";
				$wp_id=1;
				echo "\n";
	            echo "<tr style=\"padding:8px;border:1px dotted black;\">";
				echo "\n";
				echo "<td style=\"background:lightgrey;a color:orange;width:250px;padding:6px;\" class=\"odd\">";
	            echo "\n";
				echo "$wochenplan&nbsp;";
	            echo "<a href=\"../speise/details/".$inhalt2['speise_id']."\">
				 <small><strong style=\"color:black;\">".$inhalt2['bezeichnung']."</strong></small></td>";
				echo "\n";
				//echo "<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">
				//  ".$rezbez."</a>";
			//	echo "\n";
	           
	          //  echo "</td>";
			    echo "\n";

				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "$position\t";
				/* ******************************************* */

				echo "\n";	
				// Montags brauch ich keinen Pfeil nach oben
	            if($zaehl%7!=0) {
					echo "<a href=\"wechselhoch/".$wochenplanspeise_id."/".$position."\"><span class=\"glyphicon glyphicon-arrow-up\"></span></a>";
				}

				echo "\n";
				echo "</td>\n";
				echo "\n";
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo $spid;
				// Sonntags brauch ich keinen Pfeil nach unten
				if ($zaehl%7!=6) {
				
					echo "<a href=\"wechselrunter/".$wochenplanspeise_id."/".$position."\"><span class=\"glyphicon glyphicon-arrow-down\"></span></a>";
				}
				echo "\n";
				echo "<br>\n</td>\n</tr>\n";
				echo "\n";
				//echo "<br>";		
			}
			echo "<br></td>";

			echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			//echo  $inhalt['rtb'];
			echo "</td>\n";
			
				
			}    
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
		echo "</tr>\n";
	    echo "</table>\n";
	    $db=null;
	    
      
        echo "<br><a href=\"anlegen\">neuen Speiseplan anlegen</a><br>";

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';