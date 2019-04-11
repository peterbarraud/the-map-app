<?php
  header("Access-Control-Allow-Origin: *");
  require 'chotarest/app.php';
  $restapp = new RestfulApp();
  $restapp->run();

  // use the query to generate out files of establishments
  // select concat("select name, address, phone from establishment where areaid = ", id, " into OUTFILE 'area-", id, ".csv' FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n';") from area;

  function getallareas(){
    require_once('objectlayer/areacollection.php');
    $establishments = new areacollection();
    echo json_encode($establishments);
  }
  function getestabsearchresult($name, $areaid) {
    require_once('objectlayer/establishmentcollection.php');
    $establishments = new establishmentcollection(array("name" => "$name", "areaid" => $areaid));
    // TODO
    // Next line is presumptous. What if the search for name like returned multiple estabs
    // need to hande passing mutiple eids => GetRelatedEstablishments
    // $establishment = $establishments->items[0];
    $eids = array();
    foreach($establishments->items as $establishment){
      array_push($eids, $establishment->id);
    }
    $relatedestablishments = establishmentcollection::GetRelatedEstablishments($eids, $areaid);
    echo json_encode(array('establishments' => $establishments, 'relatedestablishments' => $relatedestablishments));
  }


 ?>
