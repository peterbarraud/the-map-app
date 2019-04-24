<?php
require_once ('datalayer.php');
class objectcollectionbase {
    public function __construct() {
    }
    public function GetObjectCollection($fields=null, $filter=null, $sortby=null, $query=null, $query_data=null){
        $items = array();
        $dataLayer = DataLayer::Instance();
        $objectname = str_replace('collection', '', get_class($this));
        $datacollection = $dataLayer->GetObjectCollection($objectname, $fields, $filter, $sortby, $query, $query_data);
        require_once($objectname . '.php');
        $type = $objectname;
        foreach ($datacollection as $item) {
            array_push($items, new $type($item));
        }
        return $items;
    }


    // public function GetObjectCollection(){
    //     $this->items = array();
    //     $dataLayer = DataLayer::Instance();
    //     $classname = str_replace('collection', '', get_class($this));
    //     $datacollection = $dataLayer->GetObjectCollection($classname, $filter, $sortby, $sortdirection);
    //     require_once($classname . '.php');
    //     $this->items = array();
    //     $type = $classname;
    //     foreach ($datacollection as $item) {
    //         array_push($this->items, new $type($item));
    //     }
    //     $this->length = sizeof($this->items);
    // }
    // public function getnamescollection(){
    //     $retval = array();
    //     foreach ($this->items as $item){
    //         array_push($retval,$item->name);
    //     }
    //     return $retval;
    // }
    public function __toString() {
        ob_start();
        var_dump($this);
        return ob_get_clean(); 
    }
}

?>