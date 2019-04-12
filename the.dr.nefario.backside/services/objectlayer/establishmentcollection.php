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

    private static function log_search_results($str){
        file_put_contents('./logs/GetSearchResults.log', $str . "\n", FILE_APPEND);
    }
    public static function GetSearchResults($search_q, $areaid){
        file_put_contents('./logs/GetSearchResults.log', "");
        
        require_once ('datalayer.php');
        $dataLayer = DataLayer::Instance();
        $estabsandcats = $dataLayer->GetAllEstabsAndCatsByArea($areaid);
        $estabs = array();
        $cats = array();
        foreach($estabsandcats as $estabsandcat){
          $estabs[$estabsandcat['ename']] = $estabsandcat['eid'];
          $cats[$estabsandcat['cname']] = $estabsandcat['cid'];
        }
        // to allow for free-flowing text
        // 1. split the search_q into words
        //      $words = preg_split ("/\s+/", $search_q);
        // 2. extract out linear combos of words (not the math meaning)
        //      example:
        //          "my hello world" => gives these combos
        //          ["my", "my hello", "my hello world", "hello", "hello world", "world"]
        // 3. use preg_grep to search each linear combo inside both the estab and cat arrays
        // 4. the best result is the closest match
        //      example:
        //          searching for "bike repair" means:
        //              "bike repair" is better than "motor bike repair"
        
        // 1. split the search_q into words
        self::log_search_results($search_q);
        $words = preg_split ("/\s+/", $search_q);
        // $top_of_words_array = ;
        foreach (range(0, sizeof($words)-1) as $i){
            foreach(range(1, sizeof($words) - $i) as $j){
                // self::log_search_results("$i, $j");
                $slice = array_slice($words, $i, $j);
                self::log_search_results(implode(' ', $slice));
            }
            self::log_search_results("=============");
        }
        

        $estab_matches = preg_grep("/$search_q/i", array_keys($estabs));
        return $estabsandcats;
    }
}

?>