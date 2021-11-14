<?php
 include 'inc/header.php';

		 echo '<h1 style="background: green; color: orange;
	             padding-left:120px;">Speisekomponente</h1>';


		 echo '<div class="eyecatch block">Das Anlegen einer Speisekomponente ist etwas abstrakt. Es geht um das Herstellen einer 
			 Komponente oder eines Speiseteils, welches sp&auml;ter entweder zu einem Bestandteil einer Speise oder eine	
			 Speise insgesamt werden kann.<br>Es kann also sowohl eine Suppe aus Erbsen hergestellt werden, wie auch 
			 Zuckererbsen als Gem&uuml;sebeilage oder Erbsp&uuml;ree als S&auml;ttigungsbeilage.<br><br>

			 Hinzu kommt, dass man das nicht in einem Schritt durchf&uuml;hren k&ouml;nnen wird.<br><br><br>
			 Man muss je nach Rezeptur, die Bestandteile einzeln zusammenf&uuml;gen und so verbinden.<br><br>
	
			Wenn man daher M&ouml;hren als Gem&uuml;sebeilage einer Hauptspeise zubereiten m&ouml;chte, so geh&ouml;ren im ersten Schritt die 
M&ouml;hren, dann aber auch Zwiebeln, Salz, etwas Zucker und ein wenig Pfeffer dazu.<br><br>

			Sollen die M&ouml;hren gebunden werden, dann kann gern auch eine Mehlschwitze in Einzelkomponenten dazugegeben werden oder 
			perspektifisch w&auml;re es nat&uuml;rlich leichter die fertige Komponente Mehrschwitze, bereits fertig in die Verbindung integrieren zu k&ouml;nnen.
				
			<br><br>
			Nur im ersten Schritt wird die Bezeichnung angelegt... 
			Die Beschreibung sollte bis zum letzten Schritt ver&auml;nderbar sein.
			Es muss unterschieden werden, ob die Verbindung fortgesetzt oder abgeschlossen werden soll.
			</div>'; 

         
   
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';

	    

  		 echo "<form method=\"post\" action=\"eintragen\" style=\"width:700px; padding:10px; margin:10px;\">";
         
         echo "<fieldset style=\"background:#cfcfcf; width:900px; text-align:right; padding:10px; margin-right:10px;\">";
         echo "<legend>Speisekomponente anlegen</legend>"; 
		 echo '<label>Bezeichnung: </label><input class="textform eyecatch" type="text" name="bezeichnung" placeholder="!" required /><br>';

		   // Speisekategorie
		  echo '<h2>Speisekategorie</h2>';
		  $SpeisekategorieSelect="\n<select class=\"produktform2\" required=\"required\" name=\"speisekategorie\" size=\"3\" multiple>\n";
          $SpeisekategorieSelect.=getSpeisekategorie()."\n";
          $SpeisekategorieSelect.="</select>\n";
			
		  echo $SpeisekategorieSelect;
		  echo "<br><br>";


         echo '<label>Beschreibung: </label>'."<br>";
	     echo "<textarea id='editor' name='editor'></textarea>";
		 echo "</fieldset>";

  	     echo "<fieldset style=\"background:#cfcfcf; width:900px; text-align:right; padding:10px; margin-right:10px;\">";
 		 echo '<h2>Lebensmittel</h2>';	
		 $LebensmittelSelect="\n<select class=\"produktform\" name=\"lebensmittel[]\" size=\"10\" multiple>\n";
         $LebensmittelSelect.=getLebensmittel()."\n";
         $LebensmittelSelect.="</select>\n";	
		 echo $LebensmittelSelect;
    

		 echo '<label>Menge: </label><input class="textform eyecatch" type="text" name="menge[]" placeholder="!" required /><br>';
         echo '<label>Einheit: </label><select class="produktform2" name="einheit[]">';	
		 echo '<option value="Gramm">Gramm</option>'; 	
		 echo '<option value="Milliliter">Milliliter</option>';
		 echo '<option value="St&uuml;ck">St&uuml;ck</option>';
		 echo '</select>';


		 echo '<h2>Schnittform - Zubereitungsart - Garmethode</h2>'; 
		
   	     $SchnittformsartSelect="\n<select class=\"produktform2\" name=\"schnittform[]\">\n";
		 //$SchnittformsartSelect.="\n<option value=\"0\" selected> - keine - </option>\n";
         $SchnittformsartSelect.=getSchnittform()."\n";
         $SchnittformsartSelect.="</select>\n";	

		 //echo '<h2>Zubereitungsart</h2>';
		 $ZubereitungsartSelect="\n<select class=\"produktform2\" name=\"zubereitungsart[]\">\n";
		 //$ZubereitungsartSelect.="\n<option value=\"0\"> - keine - </option>\n";
         $ZubereitungsartSelect.=getZubereitungsart()."\n";
         $ZubereitungsartSelect.="</select>\n";
		
		 $GarmethodeSelect="\n<select class=\"produktform2\" name=\"garmethode[]\">\n";
		 //$GarmethodeSelect.="\n<option value=\"0\"> - keine - </option>\n";
         $GarmethodeSelect.=getGarmethode()."\n";
         $GarmethodeSelect.="</select>\n";
		

         echo $SchnittformsartSelect;
		 echo $ZubereitungsartSelect;
		 echo $GarmethodeSelect;
		 echo "<br><br>";

		 echo ' <button type=\"reset\">Eingaben l&ouml;schen</button>';
		 echo "<input type=\"button\" value=\"noch eins\" onclick=\"clone_this(this)\">";
		 echo '<button type=\"submit\">Absenden</button>'; 	    
		 echo "</fieldset>";
		
		/************************************************************************************

		*************************************************************************************/


        /*
  	     echo "<fieldset style=\"background:#cfcfcf; width:900px; text-align:right; padding:10px; margin-right:10px;\">";
 
		 echo '<div class="table">';
         echo '<div class="spalte">';


		 // hier biegen wir jetzt in Richtung Lebensmittel ab... allerdings wird das schnell zu unübersichtlich

		 // getIngredenzien()
	

        / * ich glaube wir sollten die Rohlebensmittel in die Kategorien unterteilen...
			z.B: Fleisch / Fisch,   Gemüse,  Eier, Sättigungsbeilage, Sauce, Gewürze, Öle/fette 
		* /
	
		 echo '<h2>Lebensmittel</h2>';	
		 $LebensmittelSelect="\n<select class=\"produktform\" name=\"lebensmittel[]\" size=\"5\" multiple>\n";
         $LebensmittelSelect.=getLebensmittel('Fleisch')."\n";
         $LebensmittelSelect.="</select>\n";	
		 echo $LebensmittelSelect;

		 $LebensmittelSelect="\n<select class=\"produktform\" name=\"lebensmittel[]\" size=\"5\" multiple>\n";
         $LebensmittelSelect.=getLebensmittel('Gem&uuml;se')."\n";
         $LebensmittelSelect.="</select>\n";	
		 echo $LebensmittelSelect;

		 $LebensmittelSelect="\n<select class=\"produktform\" name=\"lebensmittel[]\" size=\"5\" multiple>\n";
         $LebensmittelSelect.=getLebensmittel('Gem&uuml;se')."\n";
         $LebensmittelSelect.="</select>\n";	
		 echo $LebensmittelSelect;

	     echo '</div>';
      
         echo '<div class="spalte">';
   	  
		  // Zubereitungsart

		 echo '<h2>Zubereitungsart</h2>';
		 $ZubereitungsartSelect="\n<select class=\"produktform2\" name=\"zubereitungsart\">\n";
         $ZubereitungsartSelect.=getZubereitungsart()."\n";
         $ZubereitungsartSelect.="</select>\n";
			
		 echo $ZubereitungsartSelect;
		 echo "<br>";
      
		 echo '<h2>Garmethode</h2>'; 
		 $GarmethodeSelect="\n<select class=\"produktform2\" name=\"garmethode\">\n";
         $GarmethodeSelect.=getGarmethode()."\n";
         $GarmethodeSelect.="</select>\n";
			
		 echo $GarmethodeSelect;
		 echo "<br>";

		  // getMengen()
         
		 echo '<h2>Menge</h2>';
 		 $MengenSelect="\n<select class=\"produktform2\" name=\"mengen\" size=\"3\" multiple>\n";
         $MengenSelect.=getMengen()."\n";
         $MengenSelect.="</select>\n";
			
		  echo $MengenSelect;
		  echo "<br><br>";

		  
  

		  // Speisekategorie
		  echo '<h2>Speisekategorie</h2>';
		  $SpeisekategorieSelect="\n<select class=\"produktform2\" name=\"speisekategorie\" size=\"3\" multiple>\n";
          $SpeisekategorieSelect.=getSpeisekategorie()."\n";
          $SpeisekategorieSelect.="</select>\n";
			
		  echo $SpeisekategorieSelect;
		  echo "<br><br>";

		  // evtl Garnitur	

		     echo '</div>';
      echo '<div class="clear"></div>';
      echo '</div>';  
      echo '</div>'; 
	
	


  */
		/************************************************************************************

		*************************************************************************************/


    /*      echo "</fieldset>";
         echo "<br>\n";

               echo "<fieldset style=\"background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;\">
              <button type=\"reset\">Eingaben l&ouml;schen</button>
			  
              <button type=\"submit\">Absenden</button>
            </fieldset> */
       echo "</form>
       </div>
       <br>
       <br>
       <br>
       <br>";
 	 
       echo '<script type="text/javascript">';
   	   echo "	CKEDITOR.replace('editor');
       </script>";

	    echo '<script type="text/javascript">';

       echo "<!--
			function clone_this(objButton)
			{
				if(objButton.parentNode)
    			{
    				tmpNode=objButton.parentNode.cloneNode(true);
   					objButton.form.appendChild(tmpNode);
    				for(j=0;j<objButton.form.lastChild.childNodes.length;++j)
        			{
        				if(objButton.form.lastChild.childNodes[j].type=='text')
            			{
           					objButton.form.lastChild.childNodes[j].value='';
            				break;
            			}
       				}
    				objButton.value='entfernen';
    				objButton.onclick=new Function('f1','this.form.removeChild(this.parentNode)');
					
    			}
			}
			//-->
			</script>";


	 
     include "inc/footer.php";