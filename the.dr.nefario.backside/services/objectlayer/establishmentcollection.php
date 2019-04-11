<?php
require_once('objectcollectionbase.php');
class establishmentcollection extends objectcollectionbase {

    public static function GetRelatedEstablishments($eids, $areaid){
        $items = array();
        require_once ('datalayer.php');
        $dataLayer = DataLayer::Instance();
        $objectIds = $dataLayer->GetRelatedEstablishmentObjectIDs($eids, $areaid);
        require_once('establishment.php');
        foreach ($objectIds as $id){
            array_push($items, new establishment($id));
        }
        $length = sizeof($items);
        return array('items' => $items, 'length' => $length);              
    }
}

?>