<?php  

final class DataLayer {
  private $sql_statement = '';
  public static function Instance()
  {
      static $inst = null;
      if ($inst === null) {
          $inst = new DataLayer();
      }
      return $inst;
  }

  /**
    * Private ctor so nobody else can instance it
    *
    */
  private function __construct()
  {
	  $json_a = json_decode(file_get_contents("datainfo.json"), true);
    $this->conn = new mysqli($json_a['server'],$json_a['username'],$json_a['password'],$json_a['database']);
  }

  public function __destruct()
  {
    $this->conn->Close();
  }

  //get all the fields for an empty data object (useful for create)
  // set all the fields for an existing object
  public function GetObjectData($object, $data){
    if ($data === null){
      $sql_statement = 'select * from ' . get_class($object) . ' where id = null';
      $result = $this->conn->query($sql_statement);
      while ($fieldinfo = $result->fetch_field()) {
        $object->{$fieldinfo->name} = null;
      }
    } else {
      foreach ($data as $fieldname => $fieldvalue){
        $object->{$fieldname} = $fieldvalue;
      }

    }
  }
  


  private static function logit($str=null, $append=1, $not_new_line=null){
    if ($append !== 1){
      if ($not_new_line == null){
        file_put_contents('./logs/getobjectcollection.log', $str . "\n");
      } else {
        file_put_contents('./logs/getobjectcollection.log', $str);
      }
    } else {
      if ($not_new_line == null){
        file_put_contents('./logs/getobjectcollection.log', $str . "\n", FILE_APPEND);
      } else {
        file_put_contents('./logs/getobjectcollection.log', $str, FILE_APPEND);
      }
    }
  }
  // objectname: name of the data object class

  // fields: Array of fields to return in the result ['id', 'name', ...]

  // filter: Array (not associative) of fields and values. Eg: ['id=1', ' and name like '%oke%'].
  // This makes handling of filter much easier. So the caller puts the details into the filter.
  // It breaks a bit of the separation of responsibilty. For example, the client will need to know about the SQL `like` clause.
  // Also the `and` and `or` are put into the filter. Again, this gives a lot more flexibility as to how to set filters
  // Example:
  // for a query like:
    // select * from table where id > 1 and id < 10 and name like 'pok%' or name like 'joh%'
    // filter = ['id > 1', 'and id < 10', "and name like 'pok%'", "or name like 'joh%'"]
    // while you might argue that we've pass the (at least in part) responsibility of building the query to the client
    // But note also that this inforation will, in some way, has come from the client.
  // I, at least, think it's a good price to pay for simplicity. Let's see, we might still change this later

  // sortby: Associative array of fields to order by and sort direction
  // Example:
    // ['id' => 'desc', 'name' => 'asc']
  
  // query: To add more flexibility and access to more elaborate database queries,
  // we've included the ability to create your own query templates
  // These are includes (as an Associative array) into the queries.collection.php
  // easy query has a name (that is passed by the caller) and a set of (optional) templated field-values
  
  // query_data: An Associative array of templated field-values that will be used by the query (above)
  // Example:
    // select * from table where id in [ids] and name like %[name]%;
    // note the templating square brackets
    // query_data = ['ids' = [1, 2, 3], 'name' = 'ker']
    // if the template value is an array, this is converted into a comma separated set of values.
    // So, for the in clause, we pass an array of values
  public function GetObjectCollection($objectname, $fields=null, $filter=null, $sortby=null, $query_name=null, $query_data=null){
  if ($query_name !== null){
      require_once('queries.collection.php');
      $sql_statement = QueryList::$queries[$query_name];
      if ($query_data !== null){
        foreach ($query_data as $name => $value){
          if (is_array($value)){
            $sql_statement = str_replace("[$name]", implode(", ", $value), $sql_statement);
          } else {  // not array
            $sql_statement = str_replace("[$name]", $value, $sql_statement);
          }

        }
      }
      $sql_statement = str_replace("[areaid]", 1, $sql_statement);
      $sql_statement = str_replace("[estab_ids]", "1, 2", $sql_statement);
      self::logit($sql_statement);
      // $sql_statement = "select * from establishment;";
    } else {  // query not given
      if ($fields != null){
        $field_list = implode(',', $fields);
      } else { // fields is given
        $field_list = "*";
      }
      $sql_statement = "select $field_list from $objectname;";
      if ($filter != null){
        $where_filter = implode(' ', $filter);
        $sql_statement = "select $field_list from $objectname where $where_filter;";
      }
    }
    $collection = array();
    self::logit($sql_statement);
    $result = $this->conn->query($sql_statement);
    $table_fields =  $result->fetch_fields();
    while($row = $result->fetch_assoc()) {
      $item = array();
      foreach ($table_fields as $table_field){
        $item[$table_field->name] = $row[$table_field->name];
      }
      array_push($collection, $item);
    }
    $result->free();
    return $collection;
  }
  
  // public function _GetObjectCollection($objectnamem $filter=null, $sortby=null, $fields=null, $query=null, $query_data=null){
  //   $retval = array();
  //   if ($query !== NULL){

  //   } else {
  //     if ($fields != null){
  //       $field_list = implode(',', $fields);
  //     } else {
  //       $field_list = "*";
  //     }
  //     $sql_statement = "select $field_list from $classname";
  
  //   }
  //   if ($fields != null){
  //     $field_list = implode(',', $fields);
  //   } else {
  //     $field_list = "*";
  //   }
  //   $sql_statement = "select $field_list from $classname";
  //   if ($filter != null){
  //     $sql_statement .= ' where';
  //     // create an array of all the and'ed statements if there are multiple fields in the filter
  //     $ands = array();
  //     foreach ($filter as $fieldname => $fieldvalue){
  //       // checking for the like clause
  //       if (strpos($fieldvalue, '%')){
  //         array_push($ands, " lower($fieldname) like lower('$fieldvalue')");
  //       } else {
  //         array_push($ands, " lower($fieldname) = lower('$fieldvalue')");
  //       }
  //     }
  //     if (sizeof($ands) > 0){
  //       $sql_statement .= implode(' and ', $ands);
  //     }
  //   }
  //   if ($sortby !== null) {
  //     $sql_statement .= " order by $sortby $sortdirection";
  //   }

  //   $sql_statement .= ';';

  //   $result = $this->conn->query($sql_statement);
  //   $table_fields =  $result->fetch_fields();
  //   $collection = array();

  //   while($row = $result->fetch_assoc()) {
  //     $item = array();
  //     foreach ($table_fields as $table_field){
  //       $item[$table_field->name] = $row[$table_field->name];
  //     }
  //     array_push($collection, $item);
  //   }
  //   $result->free();
  //   return $collection;
  // }


  public function GetPriamryEstabObjectCollection($estab_ids, $areaid){
    $retval = array();
    $estab_ids_comma_list = implode(',', $estab_ids);
    $sql_statement = "select e.id as eid, e.name as ename, c.id as cid,
                          c.name as cname from establishment e, category c,
                          est_cat ec  where e.id = ec.estid and
                          c.id = ec.catid and e.areaid = $areaid and e.id in ($estab_ids_comma_list);";
    file_put_contents('./logs/' . __FUNCTION__ . '.log', $sql_statement);
    $result = $this->conn->query($sql_statement);
    $table_fields =  $result->fetch_fields();
    $collection = array();

    while($row = $result->fetch_assoc()) {
      $item = array();
      foreach ($table_fields as $table_field){
        $item[$table_field->name] = $row[$table_field->name];
      }
      array_push($collection, $item);
    }
    $result->free();
    return $collection;                                  
  }


  public function GetRelatedEstabsObjectCollection($cat_id, $areaid){
    $retval = array();
    $sql_statement = "select e.id, e.name, e.address, e.phone, c.name from
                        establishment e, category c, est_cat ec
                        where e.id = ec.estid and c.id = ec.catid and e.areaid = $areaid
                        and c.id = $cat_id;";
    $result = $this->conn->query($sql_statement);
    $table_fields =  $result->fetch_fields();
    $collection = array();
    while($row = $result->fetch_assoc()) {
      $item = array();
      foreach ($table_fields as $table_field){
        $item[$table_field->name] = $row[$table_field->name];
      }
      array_push($collection, $item);
    }
    $result->free();
    return $collection;                                  
  }
  public function __GetRelatedEstablishmentObjectCollection($eids, $areaid){
    $retval = array();
    $eid_comma_list = implode(',', $eids);
    $sql_statement = "select e.id, e.name, e.address, e.phone from
                        establishment e, category c, est_cat ec
                        where e.id = ec.estid and c.id = ec.catid and e.areaid = $areaid and e.id not in ($eid_comma_list)
                        and c.id in (select c.id as cid from establishment e, category c, est_cat ec
                                      where e.id = ec.estid and c.id = ec.catid and e.areaid = $areaid
                                      and e.id in ($eid_comma_list));";
    $result = $this->conn->query($sql_statement);
    $table_fields =  $result->fetch_fields();
    $collection = array();

    while($row = $result->fetch_assoc()) {
      $item = array();
      foreach ($table_fields as $table_field){
        $item[$table_field->name] = $row[$table_field->name];
      }
      array_push($collection, $item);
    }
    $result->free();
    return $collection;                                  
  }
  
  public function GetAllEstabsAndCatsByArea($areaid){
    $retval = array();
    $sql_statement = "select e.id as eid, e.name as ename, c.id as cid, c.name as cname
                        from establishment e, category c, est_cat ec  where e.id = ec.estid
                        and c.id = ec.catid and e.areaid = $areaid;";
    $result = $this->conn->query($sql_statement);
    $table_fields =  $result->fetch_fields();
    $collection = array();

    while($row = $result->fetch_assoc()) {
      $item = array();
      foreach ($table_fields as $table_field){
        $item[$table_field->name] = $row[$table_field->name];
      }
      array_push($collection, $item);
    }
    $result->free();
    return $collection;                                  
  }

  public function Save($object){
    //   insert if object id is null
      if ($object->id == null){
        $field_list = '';
        $value_list = '';
        foreach($object as $field => $value) {
          if ($field != 'id'){
            $field_list .= $field . ', ';
            if (datalayer::field_is_timestamp($field)){
              $value_list .= 'now(), ';
            } else if (datalayer::field_is_boolean($field)){
              if ($value){
                $value_list .= '"1", ';  
              } else {
                $value_list .= 'null, ';  
              }
            } else {
              $value_list .= '"' . $value . '", ';
            }
          }
        }
        $field_list = rtrim(rtrim($field_list),',');
        $value_list = rtrim(rtrim($value_list),',');
        $execute_sql = 'insert into ' . get_class($object) . '(' . $field_list . ') values (' . $value_list . ');';
        $this->conn->query($execute_sql);
        $object->id = $this->conn->insert_id;
      } else { // else update
        $set_list = '';
        foreach($object as $field => $value) {
          if ($field != 'id'){
            if (datalayer::field_is_timestamp($field)){
              $value = 'now()';
            } else if (datalayer::field_is_boolean($field)){
                if ($value){
                  $value = '"1"';
                } else {
                  $value = 'null';
                }            
            } else {
              if (isset($value)){
                $value = '"' . $value . '"';
              }
              else {
                $value = '""';					  
              }            
            }
            $set_list .= $field . ' = ' . $value . ', ';
          }
        }
        $set_list = rtrim(rtrim($set_list),',');
        $execute_sql = 'update ' . get_class($object) . ' set ' . $set_list . ' where id = ' . $object->id . ';';
        $this->conn->query($execute_sql);
      }

  }

  public function Delete($object)
  {
    // TODO
    // for now we're going to simply delete but we need to put in code to check if this component is being used
    // or should we have a isUsed function (property) for an object?
    // a check is not required since the foreign key constraint will stop this delete from happening
    // however, it would be a good idea to send back info to the user that the delete will not happend
    $execute_sql = 'delete from ' . get_class($object) . ' where id = ' . $object->id;
    $this->conn->query($execute_sql);
    return $this->conn->affected_rows;
  }
  public function GetTableList(){
    $retval = array();
    $result = $this->conn->query('show tables;');
    while($row = $result->fetch_array()) {
      array_push($retval, $row[0]);
    }
    return $retval;
  }

  public function AddObjectColumns($object, $columns_to_add, $column_to_add_after){
    $sql_statement = 'alter table ' . get_class($object);
    foreach ($columns_to_add as $column_name){
      $sql_statement .= " add column $column_name text after $column_to_add_after,";
    }
    $sql_statement = rtrim($sql_statement, ',');
    $this->conn->query($sql_statement);
  }
  // We need to force NULL value in timestamp fields
  // but the system mandates that timestamp fields must end with _ts
  private static function field_is_timestamp($fieldname){
    $retval = 1;  // default to 
    $length = strlen('_ts');
    if ($length == 0) {
        $retval = 1;
    } else { 
      $retval = substr($fieldname, -$length) === '_ts' ? 1 : 0;
    }
    return $retval;    
  }
  // this is how the system will handle boolean values
  // the table field must be a char(1) type
  // true = ''
  // false = NULL
  // example:
  //  defaultstatus_bool char(1) DEFAULT NULL,
  // but the system mandates that boolean fields must end with _bool
  private static function field_is_boolean($fieldname){
    $retval = 1;  // default to 
    $length = strlen('_bool');
    if ($length == 0) {
        $retval = 1;
    } else { 
      $retval = substr($fieldname, -$length) === '_bool' ? 1 : 0;
    }
    return $retval;    
  }

}
    

?>