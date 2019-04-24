<?php
    final class QueryList {
        public static $queries = [
            'estabs_cats_by_area' => "select e.id as eid, e.name as ename, c.id as cid, c.name as cname
                    from establishment e, category c, est_cat ec  where e.id = ec.estid and c.id = ec.catid and e.areaid = [areaid];",
            'related_estabs_by_estab_ids' => "select e.id, e.name, e.address, e.phone from establishment e, category c, est_cat ec
                    where e.id = ec.estid and c.id = ec.catid and e.areaid = [areaid] and e.id in ([estab_ids]);",
            'related_estabs_by_cat_ds' => "select e.id, e.name, e.address, e.phone from establishment e, category c, est_cat ec
                                        where e.id = ec.estid and c.id = ec.catid and e.areaid = [areaid] and c.id in ([category_ids]);"
    
        ];
    
    }


?>