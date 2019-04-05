<?php
header("Access-Control-Allow-Origin: *");
  require 'chotarest/app.php';
  $restapp = new RestfulApp();
  $restapp->run();

  function validateuser($username, $password){
    require_once('objectlayer/appusercollection.php');
    $filter = array('username' => $username, 'password' => $password);
    $users = new appusercollection($filter);
    echo json_encode($users);
  }

  function getestablishmentbyname($name) {
    require_once('objectlayer/establishmentcollection.php');
    $establishments = new establishmentcollection(array("name" => $name));
    echo json_encode($establishments);
  }

  function getestablishmentbycategoryname($name) {
    require_once('objectlayer/establishmentcollection.php');
    $establishments = new establishmentcollection(array("name" => $name));
    echo json_encode($establishments);
  }

  function getappuserbyid($id) {
    require_once('objectlayer/appuser.php');
    $user = new appuser($id);
    echo json_encode($user);
  }


 ?>
