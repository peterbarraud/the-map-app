<?php
require_once ('datalayer.php');
class objectbase {
    // null implies creating a new object
    public function __construct($data=null) {
        $dataLayer = DataLayer::Instance();
        $dataLayer->GetObjectData($this, $data);
    }
    public function Save(){
        $dataLayer = DataLayer::Instance();
        $dataLayer->Save($this);
    }
    public function Delete()
    {
        $dataLayer = DataLayer::Instance();
        $affected_rows = $dataLayer->Delete($this);
        return $affected_rows;
    }
    public function __toString() {
        ob_start();
        var_dump($this);
        return ob_get_clean(); 
    }
}

?>