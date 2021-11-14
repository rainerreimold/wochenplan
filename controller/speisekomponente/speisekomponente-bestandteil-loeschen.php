<?php
/*****************************************************************************

 speisekomponenten-bestandteil-loeschen

 Es soll ein einzelner Bestandteil eines Rezeptes für die Erstellung einer
 Speisekomponente gelöscht werden können.

 notwendige Daten:
 Es muss daher die ID der Speisekomponente 
 die ID der Verbindung zwischen Lebensmittel und Speisekomponente
 und letztlich auch die Initial_id der Verbindung bekannt sein, 
 damit man alle Datensätze löschen kann!
 Format:
 "loeschen/'.$lm_sk_verbindung_id.'/'.$lm_sk_verbindung_initial_id.'/'.$lm_sk_verbindung_parent_id.'"
 

 Löschen oder deletable:
 Schliesslich sollte man noch überlegen, ob man ein Flag auf "löschen" setzt
 oder den/die Eintra(e)g(e)


 Das Löschen einer gesamten Speisekomponente soll durch eine separate Funktion 
 ermöglicht werden.


 Datum 22.09.2021 

*****************************************************************************/
