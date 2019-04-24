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

  function findestabs($search_q, $areaid) {
    // let's get the list of estab names
    // Note: This could later be client-end functionality
    require_once('objectlayer/establishmentcollection.php');
    $establishmentcollection = new establishmentcollection();
    $resutls = $establishmentcollection->FindEstabs($search_q, $areaid);
    echo json_encode(array('results' => $resutls));
  }

  function getdatafortest(){
    require_once('objectlayer/categorycollection.php');
    $categorycollection = new categorycollection();
    $resutls = $categorycollection->GetObjectCollection(['id', 'name'], ["name='stationer'"]);;
    echo json_encode(array('results' => $resutls));
  }

  function uploadestabdata(){
    require_once('objectlayer/establishmentcollection.php');
    establishmentcollection::UploadData();
    echo json_encode(array('status' => 'done'));

  }

 ?>
