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
        self::log_search_results("Search query: " . $search_q);
        $words = preg_split ("/\s+/", $search_q);
        $cat_matches = array();
        $estab_matches = array();
        foreach (range(0, sizeof($words)-1) as $i){
            foreach(range(1, sizeof($words) - $i) as $j){
                // self::log_search_results("$i, $j");
                $slice = array_slice($words, $i, $j);
                $sub_str = implode(' ', $slice);
                self::log_search_results("search sub-str: " . $sub_str);
                $cat_matches = preg_grep("/($sub_str)/i", array_keys($cats));
                $estab_matches = preg_grep("/$sub_str/i", array_keys($estabs));
                self::log_search_results("Results:");
            }
        }
        $cat_ids = array();
        $estab_ids = array();
        foreach($estab_matches as $estab){
            array_push($estab_ids, $estabs[$estab]);
        }
        foreach($cat_matches as $cat){
            array_push($cat_ids, $cats[$cat]);
        }
        // $found_estabs = $dataLayer->GetEstabsObjectCollection($estab_ids, $areaid);
        $related_cats = $dataLayer->GetRelatedCatsObjectCollection($cat_ids, $areaid);
        self::log_search_results("=====");
        // 
        return $related_cats;
    }
    public static function UploadData(){
        require_once('categorycollection.php');
        require_once('category.php');
        require_once('establishment.php');
        require_once('est_cat.php');
        $file = file_get_contents("test-data/estab-data.csv");
        $lines = explode("\n", $file);
        foreach ($lines as $line){
            $items = explode(",", $line);
            $name = array_shift($items);
            $establishment = new establishment();
            $establishment->name = $name;
            $establishment->phone = 999;
            $establishment->address = 999;
            $establishment->areaid = 1;
            $establishment->Save();
            foreach($items as $category){
                $category_id = -1;
                $category = trim($category);
                $categories = new categorycollection(array("name" => "$category"));
                if ($categories->length === 0){
                    $new_category = new category();
                    $new_category->name = $category;
                    $new_category->Save();
                    $category_id = $new_category->id;
                } else {
                    $category_id = $categories->items[0]->id;
                }
                $est_cat = new est_cat();
                $est_cat->catid = $category_id;
                $est_cat->estid = $establishment->id;
                $est_cat->Save();
            }
    }
    }
}

?>