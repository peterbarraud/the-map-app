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

  function searchforestbynamelike($name) {
    // select e.id, e.name, e.address, e.phone from establishment e, area a where e.areaid = a.id and a.id = 1 and e.name like 'ABAN%';
    // select * from establishment where id in (select estid from est_cat where catid = (select catid from est_cat where estid = 478)) and areaid = 1 and name not like 'ABAN%';
    // select e.name as ename, e.address, e.phone, c.name, c.id from establishment e, category c, est_cat ec where e.id = ec.estid and c.id = ec.catid and e.areaid = 3 and e.name like 'ABAN%';
    // select e.name as ename, e.address, e.phone, c.name, c.id from establishment e, category c, est_cat ec where e.id = ec.estid and c.id = ec.catid and e.areaid = 3 and c.id in (2, 9, 12);
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
