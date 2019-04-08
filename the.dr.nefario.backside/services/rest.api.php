<?php
  header("Access-Control-Allow-Origin: *");
  require 'chotarest/app.php';
  $restapp = new RestfulApp();
  $restapp->run();


  function getestabsearchresult($name, $areaid) {
    require_once('objectlayer/establishmentcollection.php');
    $establishments = new establishmentcollection(array("name" => "$name", "areaid" => $areaid));
    $establishment = $establishments->items[0];
    $relatedestablishments = establishmentcollection::GetRelatedEstablishments($establishment->id, $areaid);
    echo json_encode(array('establishment' => $establishment, 'relatedestablishments' => $relatedestablishments));
  }


 ?>
