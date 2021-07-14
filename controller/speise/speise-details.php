<?php
/****

hier sollen die Speisedetails entstehen.

gedacht war die Bearbveitung urspünglich in der Datei bearbeite....
Das ist zunächst nebensächlich.

Es handelt sich um das Hauptformular zum Anlegen von Speisen.

Die Frage ist nun, wie liest man die Speise mit ihren Komponenten so aus, dass
man sie in den "details" betrachten 

und unter "bearbeiten" wie der Name schon sagt, die Daten bearbeiten kann.

Sinnig wäre zum Beispiel eine Unterscheidung zwischen den verschiedenen Zugriffsberechtigungen,
wobei der Gast oder Kunde nur die details betrachten darf, der Mitarbeiter die Daten aber bearbeiten kann. 

25.07.2021





***/


   	include 'inc/header.php';
	

   	// neue Tabnavigation 
	echo '<section data-title="Radio und Label">';

    echo '<h1 style="background: orange;
	             padding-left:320px;">Rezept</h1>';
        
    echo '<div class="tabbed" >
		<input checked="checked" id="tab1" type="radio" name="tabs" />
		<input id="tab2" type="radio" name="tabs" />
		<input id="tab3" type="radio" name="tabs" />
		<input id="tab4" type="radio" name="tabs" />
		<input id="tab5" type="radio" name="tabs" />
		
		<div class="nav nav-w" style="width: 1000px;">
			<label for="tab1">Hauptspeise</label>
			<label for="tab2">Suppe</label>
			<label for="tab3">Vorspeise</label>
			<label for="tab4">Dessert</label>
			<label for="tab5">kl.Speise</label>
		</div>
	
		<figure style="width: 1000px;">
			<div class="tab1">
				<div class="lines">
					<h5>Hauptspeise</h5>
					
					<p>';
					

			/**********************************************************************************************************

		      // Formular Hauptspeise	



			**********************************************************************************************************/


			  echo '<div class="form" style="width:1000px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 			
			  echo '<form method="post" action="hauptspeiseEintragen" style="width:60px; padding:10px; margin:10px;">

                <fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">
                <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textformsuppe" type="text" name="speise" placeholder="xxx.xx" required /><br>';
             
             echo "<br>\n";
			// echo "Was soll es f&uuml;r ein Rezept werden?<br>\n";
		

			 $HauptbeilageSelect="\n<select class=\"auswahl2 haupt\" name=\"hauptbeilage\" size=\"5\" multiple>\n";
             $HauptbeilageSelect.=getHauptBeilage()."\n";
             $HauptbeilageSelect.="</select>\n";
			  

			 $SaettigungsbeilageSelect="\n<select class=\"auswahl2 sat\" name=\"saettigungsbeilage\" size=\"5\" multiple>\n";
			 $SaettigungsbeilageSelect.=getSaettigungsBeilage()."\n";
             $SaettigungsbeilageSelect.="</select>\n";
						 
			 $GemuesebeilageSelect="\n<select class=\"auswahl2 gem\" name=\"gemuesebeilage\" size=\"5\" multiple>\n";
             $GemuesebeilageSelect.=getGemueseBeilage()."\n";
             $GemuesebeilageSelect.="</select>\n";
			
			 $SaucebeilageSelect="\n<select class=\"auswahl2 sau\" name=\"saucebeilage\" size=\"5\" multiple>\n";
             $SaucebeilageSelect.=getSaucen()."\n";
             $SaucebeilageSelect.="</select>\n";
			 
			

			 echo "<span class=\"label2 haupt\">Hauptkomponente&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</span>\n";
			 echo "<span class=\"label2 sat\">-&nbsp;&nbsp;&nbsp;S&auml;ttigungsbeilage&nbsp;&nbsp;&nbsp;</span><br>\n";

			 echo $HauptbeilageSelect;
 			 echo $SaettigungsbeilageSelect;
			 
			 echo "<br/><br/>";
			 echo "<span class=\"label2 gem\">Gem&uuml;sebeilage</span>\n";  	
			 echo "<span class=\"label2 sau\">Saucebeilage</span><br>\n";  		
	
			
			 echo $GemuesebeilageSelect;
			 echo $SaucebeilageSelect;

			 echo "<br/><br/>";

				
			 /*
				
				Vielleicht ist die Unterscheidung über die Speiseart 
				hier auch in Fleisch und Fisch sinnvoll 
			
			*/ 
			 	
			 $SpeiseartSelect="\n<select class=\"auswahl2\" name=\"speiseart\" size=\"5\" multiple>\n";
             $SpeiseartSelect.=getSpeiseart()."\n";
             $SpeiseartSelect.="</select>\n";

			 echo "<span class=\"label2 haupt\">Speiseart&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</span>";
			 echo $SpeiseartSelect;	

			 echo "<br/><br/>";
			 echo "<textarea id='editor' name='editor'></textarea>";
			

             echo '</fieldset>';
			  echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';

			echo	'</p>
				</div>
			</div>';

		/* Ende Tab/Bereich Anlegen eines Hauptgerichtes */

		/********************************************************************************************************
			
			 Beginn Tab Anlegen 
			 :Suppe	
			
		********************************************************************************************************/

		echo '<div class="tab2">
				  <div class="lines">
					<h5>Suppe</h5>
					<p>';
					  
			  echo '<div class="form" style="width:940px; text-align:right; padding:10px; margin:10px auto auto auto;">';
		 			
			  echo '<form method="post" action="suppeEintragen" style="width:900px; padding:10px; margin:10px;">

              <fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">
              <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label>
			  <input class="textformsuppe" type="text" name="speise" placeholder="Suppe" required style="width:750px;/><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
              
			 echo "Was soll es f&uuml;r ein Rezept werden?<br>\n";
		

			 $SuppeSelect="\n<select class=\"auswahl2 eyecatch\" name=\"suppe\" size=\"5\" multiple>\n";
             $SuppeSelect.=getSuppen()."\n";
             $SuppeSelect.="</select>\n";
			
			 echo $SuppeSelect;

			 echo "<br><br>\n";
			 				

			  echo "<textarea id='editorSuppe' name='editorSuppe'></textarea>";
  	

			 echo '</fieldset>';

             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '</p>
				</div>
			
			</div>';

  		/********************************************************************************************************
			
			 Beginn Tab Anlegen 
			 :Vorspeise	
			
		********************************************************************************************************/


			echo '<div class="tab3">
				
				<div class="lines">
					<h5>Vorspeise</h5>
					<p>';
					  
			  echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 		
			  echo '<form method="post" action="vorspeiseEintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="speise"  required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
             
			 echo "Was soll es f&uuml;r eine Vorspeise werden?<br>\n";
		
	
			 $VorspeiseSelect="\n<select class=\"auswahl eyecatch\" name=\"vorspeise\" size=\"5\" multiple>\n";
             $VorspeiseSelect.=getVorspeisen()."\n";
             $VorspeiseSelect.="</select>\n";
			
			 echo $VorspeiseSelect;
			 echo "<br><br>\n";
			 
			 echo "<textarea id='editorVorspeise' name='editorVorspeise'></textarea>";
  	
   		     echo '</fieldset>';


             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '
					</p>
				</div>
			
			</div>';

			/********************************************************************************************************
			
			 Beginn Tab Anlegen 
			 :Dessert	
			
			********************************************************************************************************/


			// Dessert
		echo '<div class="tab4">
				<div class="lines">
					<h5>Dessert</h5>
					<p>';
			  echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 		
			  echo '<form method="post" action="dessertEintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="speise"  required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
             
			 echo "Was soll es f&uuml;r ein Dessert werden?<br>\n";
		
	
			 $DessertSelect="\n<select class=\"auswahl eyecatch\" name=\"vorspeise\" size=\"5\" multiple>\n";
             $DessertSelect.=getDessert()."\n";
             $DessertSelect.="</select>\n";
			
			 echo $DessertSelect;
			 echo "<br><br>\n";
			 
			  echo "<textarea id='editorDessert' name='editorDessert'></textarea>";
  	
   		     echo '</fieldset>';


             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '</p>
				</div>
			
			</div>';

			/********************************************************************************************************
			
			 Beginn Tab Anlegen 
			 :kleine Speise, das soll soetwas Sülze oder Bauernfrühstück sein.
			 Das sind nicht immer kleine Speisen, daher ist der Ausdruck nicht glücklich.

			 Im Wesentlichen würde so nur ein Bestandteil auf dem Teller liegen.	
			
			********************************************************************************************************/


			echo '<div class="tab5">
				<div class="lines">
					<h5>Speiseteil</h5>
					<p>';
			  echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 		
			  echo '<form method="post" action="dessertEintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="speise"  required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
             
			 echo "Was soll es f&uuml;r eine Speiseteil werden?<br>\n";
		
	
			 $SpeiseteilSelect="\n<select class=\"auswahl2 eyecatch\" name=\"vorspeise\" size=\"5\" multiple>\n";
             $SpeiseteilSelect.=getBestandteil()."\n";
             $SpeiseteilSelect.="</select>\n";
			
			 echo $SpeiseteilSelect;
			 echo "<br><br>\n";
			 
			  echo "<textarea id='editorSpeiseteil' name='editorSpeiseteil'></textarea>";
  	
   		     echo '</fieldset>';


             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '</p>
				</div>
			
			</div>';




		echo '</figure>
	</div>
</section>';
	
   echo '<script type="text/javascript">';
   echo "	CKEDITOR.replace('editor');";
   echo "	CKEDITOR.replace('editorSuppe');";
   echo "	CKEDITOR.replace('editorVorspeise');";
   echo "	CKEDITOR.replace('editorDessert');";
   echo "	CKEDITOR.replace('editorSpeiseteil');";
   echo "    </script>";
			

     include 'inc/footer.php';