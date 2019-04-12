<?php
require_once('objectcollectionbase.php');
class establishmentcollection extends objectcollectionbase {
    public static function GetRelatedEstablishments($eids, $areaid){
        $dataLayer = DataLayer::Instance();
        $datacollection = $dataLayer->GetRelatedEstablishmentObjectCollection($eids, $areaid);
        require_once('establishment.php');
        $items = array();
        foreach ($datacollection as $item) {
            array_push($items, new establishment($item));
        }
        return array('items' => $items, 'length' => sizeof($items));
    }
    public static function GetAllEstablishmentNames($areaid){
        $items = array();
        require_once ('datalayer.php');
        $dataLayer = DataLayer::Instance();
        $estabnames = $dataLayer->GetAllEstablishmentNames($areaid);
        require_once('establishment.php');
        foreach ($objectIds as $id){
            array_push($items, new establishment($id));
        }
        $length = sizeof($items);
        return array('items' => $items, 'length' => $length);              
    }

    public static function GetSearchResults($search_q, $areaid){
        require_once ('datalayer.php');
        $dataLayer = DataLayer::Instance();
        $estabsandcats = $dataLayer->GetAllEstabsAndCatsByArea($areaid);
        $estabs = array();
        $cats = array();
        file_put_contents('./logs/' . __FUNCTION__ . '.log', "$search_q" . "\n");
        foreach($estabsandcats as $estabsandcat){
          $estabs[$estabsandcat['ename']] = $estabsandcat['eid'];
          $cats[$estabsandcat['cname']] = $estabsandcat['cid'];
        }
        foreach($cats as $key => $value){
          file_put_contents('./logs/' . __FUNCTION__ . '.log', $key . '=>' . $value . "\n", FILE_APPEND);
        }
        return $estabsandcats;
    }
}

?>