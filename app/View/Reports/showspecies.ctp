<?php
   foreach($species as $s){
      $sname = $s['Specie']['scientific_name'];
      $areas = $sAreas[$sname];
      foreach($areas as $area){
        echo $area['Report']['area'];
      }
      $reports = $sReports[$sname];
      foreach($reports as $report){
        echo $report['Report']['main_photo'];
      }
   }
   foreach($areas as $a) {
      echo $aname = $a['Report']['area'];
      $species = $aSpecies[$aname];
      foreach($species as $s){ 
         echo $s['Specie']['scientific_name'];
      }
      $reports = $aReports[$aname];
      foreach($reports as $report){
          echo $report['Report']['main_photo'];
      }
   }
?>
