<?php
  header("Access-Control-Allow-Origin: *");
  require 'chotarest/app.php';
  $restapp = new RestfulApp();
  $restapp->run();

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

  // the search query is free-flowing text
  // we need to take out (possible) estab names and / or catgories from this query
  // the rule:
  /* 
    if (search_q has only a name){
        search for estabs by this name (using wildcards)
        return:
          first: the list of estabs with this name
          second: other estabs that belong to the same category as these estabs
    } else if (search_q has on a category){
        return:
          estabs in this category
    } else if (search_q has name and category){
          first: the list of estabs with this name and of this category
          second: other estabs of this category
    }   
   */

  function searchresult($search_q, $areaid) {
    // let's get the list of estab names
    // Note: This could later be client-end functionality
    require_once('objectlayer/establishmentcollection.php');
    $resutls = establishmentcollection::GetSearchResults($search_q, $areaid);
    echo json_encode(array('results' => $resutls));
  }



 ?>
