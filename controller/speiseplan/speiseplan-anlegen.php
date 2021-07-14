<?php
/**********************************************************************************************************************

 Projekt: wochenplan
 Datei: speiseplan-alegen.php 
 Ziel: Formular zur Erstellung von Speiseplänen.

 Hier wird die einzelne Funktion aufgrund des zu erwartenden Umfangs in eine separate Datei ausgelagert.

 Autor: Rainer Reimold
 Datum: 04.07.21



**********************************************************************************************************************/
  include 'inc/header.php';
	
	// Im Schritt 0 sollten wohl zunächst alle bereits exitierenden Wochenpläne angezeigt werden?
	
	// $Wochenplaene=getAlleWochenplaene();
	/*
     $i=0;
	 echo '<h1 style="background: red; color:white;
	             padding-left:120px;">Wochenplan</h1>';
     echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 
	 echo '<table width=100%><tr><th> W O C H E N P L A N</th></tr>';	
	 echo '<tr><th>Bezeichnung</th><th>Beschreibung</th></tr>';
	
	 foreach ( $Wochenplaene as $Wochenplan) {

	 	echo '<tr><td>';
	 	echo $Wochenplan[$i]['rid'];
	 	echo '</td></tr>';
	 	$i++;
     }
*/



/** 
ich würde mir hier gern einen Schritt weiter zu gehen wünschen!
Rainer: 04.07.2021


Wenn ich einem "Schema" folge, so könnte ich am Mo und Samstag eine Suppe wählen.
Am Sonntag ein ordentliches Hauptgericht. Braten Klöße
Am Donnerstag eine Süßspeise Eierkuchen/Grißbrei 
Am Mittwoch etwas leichtes, wie ein gefülltes Omelette oder E
Dienstag: Fisch oder Nuggets
Freitag: Currywurst oder Szegediner


 


**/




	// Im Schritt 1 müssen alle Rezepte angezeigt werden.

	// Ich glaube, dass die Auswahl über ein multiple Formular ungünstig ist.
	// Das Auslesen wäre lösbar, aber die Zuordnung zu den Wochentagen wäre schwierig.
	// Das ist zwar im ersten Moment für das Projekt und die Bestellzettel unwichtig, dennoch 
	// stellt die App Vorschläge, aber keine Vorschrift für die möglichen Speisenpläne der Woche dar.
	
		 echo '<h1 style="background: orange; color:black;
	             padding-left:120px;">Rezepte</h1>';
         echo '<div class="form" style="width:1150px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:1100px; padding:10px; margin:10px;" class="artikelform">
           <fieldset style="background:#cfcfcf; width:1050px; text-align:center; padding:10px; margin-right:10px;">
           <legend>5 Rezepte ausw&auml;hlen</legend>';       
   
		     echo '<label>Wochenplan: </label><input class="textform eyecatch" type="text" name="bezeichnung"  required /><br>';

			 // alle Speisen vorselektiert nach einem Schema 04.07.21

			 echo "<br>Montag<br><br>";
	         $RezepteMo="\n<select class=\"auswahl eyecatch\" name=\"rezeptMo\" size=\"5\" >\n";
             $RezepteMo.=getAlleRezepte()."\n";
             $RezepteMo.="</select>\n";
			
  			 echo $RezepteMo;
						
			 echo "<br><br>Dienstag<br><br>";	
			 $RezepteDi="\n<select class=\"auswahl eyecatch\" name=\"rezeptDi\" size=\"5\" >\n";
             $RezepteDi.=getAlleRezepte()."\n";
             $RezepteDi.="</select>\n";
			// echo '<br><br>';
  			 echo $RezepteDi;
		
			 echo "<br><br>Mittwoch<br><br>";	
			 $RezepteMi="\n<select class=\"auswahl eyecatch\" name=\"rezeptMi\" size=\"5\" >\n";
             $RezepteMi.=getAlleRezepte()."\n";
             $RezepteMi.="</select>\n";
			
  			 echo $RezepteMi;
		
		     echo "<br><br>Donnerstag<br><br>";	
			 $RezepteDo="\n<select class=\"auswahl eyecatch\" name=\"rezeptDo\" size=\"5\" >\n";
             $RezepteDo.=getAlleRezepte()."\n";
             $RezepteDo.="</select>\n";
			
  			 echo $RezepteDo;
		
			 echo "<br><br>Freitag<br><br>";	
			 $RezepteFr="\n<select class=\"auswahl eyecatch\" name=\"rezeptFr\" size=\"5\" >\n";
             $RezepteFr.=getAlleRezepte()."\n";
             $RezepteFr.="</select>\n";
			
  			 echo $RezepteFr;
		
			 //echo '<br><br>';
				// Wochenende
	
			 echo "<br><br>Samstag<br><br>";	
			 $RezepteSa="\n<select class=\"auswahl eyecatch\" name=\"rezeptSa\" size=\"5\" >\n";
             $RezepteSa.=getAlleRezepte()."\n";
             $RezepteSa.="</select>\n";
			
  			 echo $RezepteSa;
		

			 echo "<br><br>Sonntag<br><br>";	
			 $RezepteSo="\n<select class=\"auswahl eyecatch\" name=\"rezeptSo\" size=\"5\" >\n";
             $RezepteSo.=getAlleRezepte()."\n";
             $RezepteSo.="</select>\n";
			
  			 echo $RezepteSo;

			echo '<br><br>';
      echo "<br>Beschreibung:<br>";
	  echo "<textarea id='editor' name='editor'></textarea>";

	   echo ' </fieldset>';
	
       echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>';
	    echo '<script type="text/javascript">';
        echo "	CKEDITOR.replace('editor');";
        echo "</script>";

     include 'inc/footer.php';

?>