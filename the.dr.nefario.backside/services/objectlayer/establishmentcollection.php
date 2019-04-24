<?php

    require_once('objectcollectionbase.php');
    class establishmentcollection extends objectcollectionbase {
        // $fields=null, $filter=null, $sortby=null, $query=null, $query_data=null

        private function log_search_results($str){
            file_put_contents('./logs/GetSearchResults.log', $str . "\n", FILE_APPEND);
        }
        private function log_sep(){
            file_put_contents('./logs/GetSearchResults.log', "=======\n", FILE_APPEND);
        }

        public function FindEstabs($search_q, $areaid){
            file_put_contents('./logs/GetSearchResults.log', "");
            $this->log_search_results("Search query: " . $search_q);
            
            $estabs = array();
            $cats = array();

            $estabsandcats = parent::GetObjectCollection(null, null, null, 'estabs_cats_by_area', ['areaid' => $areaid]);
            foreach($estabsandcats as $estabsandcat){
                $estabs[$estabsandcat->ename] = $estabsandcat->eid;
                $cats[$estabsandcat->cname] = $estabsandcat->cid;
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
            
            $this->log_sep();
            // 1. split the search_q into words
            $words = preg_split ("/\s+/", $search_q);
            $n = sizeof($words);
            // get the forward linear combinations of search_q
            // for example, for the following search_q:
            // the quick brown
            // the forward linear combinations are:
                // the quick brown
                // the quick
                // quick brown
                // the
                // quick
                // brown
            $estab_ids = array();
            $cat_ids = array();
            foreach (range($n, 1, -1) as $i){
                $end = $i;
                $start = 0;
                while ($end < $n + 1){
                    $item_combo = array_slice($words, $start, $end-$start);
                    $string_combination = implode(" ", $item_combo);
                    $estab_ids += self::get_item_ids($estabs, $string_combination);
                    $cat_ids += self::get_item_ids($cats, $string_combination);
                    $end += 1;
                    $start += 1;
                }
            }
            $primary_estabs = array();
            $related_estabs = array();

            // if estab matches were found, we are going to only use that
            if (sizeof($estab_ids) > 0){
                // $fields=null, $filter=null, $sortby=null, $query=null, $query_data=null
                $estab_comma_list = implode(",", $estab_ids);
                $filter = ["id in ($estab_comma_list)", " and areaid=$areaid"];
                $primary_estabs = parent::GetObjectCollection(null, $filter);
            } else{ // we use cats if and only if we found no estab mathes
                if (sizeof($cat_ids) > 0){
                    $filter = ['areaid' => $areaid, 'category_ids' => $cat_ids];
                    $related_estabs = parent::GetObjectCollection(null, null, null, 'related_estabs_by_cat_ds', $filter);
                }
            }            
            $this->log_search_results("=====");
            // 
            return array('search_q' => $search_q . '<br>', 'primarry_estabs' => $primary_estabs, 'related_estabs' => $related_estabs);
        }

        private static function get_item_ids($name_id_hash, $string_combination){
            $items = array();
            if (preg_grep("/\b$string_combination\b/i", array_keys($name_id_hash))){
                foreach ($name_id_hash as $name => $id){
                    if (preg_match("/\b$string_combination\b/i", $name)){
                        array_push($items, $id);
                    }
                }
            }
            return $items;
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
                    $categorycollection = new categorycollection();
                    $categories = $categorycollection->GetObjectCollection(['id', 'name'], ["name=$category"]);
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