<?php

final class DataLayer {
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
      file_put_contents('./logs/' . __FUNCTION__ . '.log', $sql_statement);
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
  
  public function GetIdByFieldName($classname, $fieldname, $fieldvalue){
    $retval = null;
    // escape single quotes in field value
    $fieldvalue = str_replace('\'', '\\\'', $fieldvalue);
    $sql_statement = "select id from $classname where $fieldname = '$fieldvalue'";
    $result = $this->conn->query($sql_statement);
    while($row = $result->fetch_assoc()) {
      $retval = $row['id'];
    }
    return $retval;
  }

  // get the data for a given object ($classname)
  // $classname: name of object
  // filter: associative array: fieldname = fieldvalue (also supports wildcards - still WIP)
  // sortby: field (should allow an associative field array for fields and direction)
  // fields: list of fields to retrieve
  public function GetObjectCollection($classname, $filter=null, $sortby=null, $sortdirection=null, $fields=null){
    $retval = array();
    if ($fields != null){
      $field_list = implode(',', $fields);
    } else {
      $field_list = "*";
    }
    $sql_statement = "select $field_list from $classname";
    if ($filter != null){
      $sql_statement .= ' where';
      // create an array of all the and'ed statements if there are multiple fields in the filter
      $ands = array();
      foreach ($filter as $fieldname => $fieldvalue){
        // checking for the like clause
        if (strpos($fieldvalue, '%')){
          array_push($ands, " lower($fieldname) like lower('$fieldvalue')");
        } else {
          array_push($ands, " lower($fieldname) = lower('$fieldvalue')");
        }
      }
      if (sizeof($ands) > 0){
        $sql_statement .= implode(' and ', $ands);
      }
    }
    if ($sortby !== null) {
      $sql_statement .= " order by $sortby $sortdirection";
    }

    $sql_statement .= ';';

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


  public function _GetObjectIds($classname, $filter=null, $sortby=null, $sortdirection=null){
    $retval = array();
    $sql_statement = "select id from $classname";
    if ($filter != null){
      $sql_statement .= ' where';
      // create an array of all the and'ed statements if there are multiple fields in the filter
      $ands = array();
      foreach ($filter as $fieldname => $fieldvalue){
        // checking for the like clause
        if (strpos($fieldvalue, '%')){
          array_push($ands, " lower($fieldname) like lower('$fieldvalue')");
        } else {
          array_push($ands, " lower($fieldname) = lower('$fieldvalue')");
        }
      }
      if (sizeof($ands) > 0){
        $sql_statement .= implode(' and ', $ands);
      }
    }

    if ($sortby !== null) {
      $sql_statement .= " order by $sortby $sortdirection";
    }

    $result = $this->conn->query($sql_statement);
    while($row = $result->fetch_assoc()) {
      array_push($retval, $row['id']);
    }
    return $retval;
  }
  /* select e.id, e.name as ename, e.address, e.phone from
      establishment e, category c, est_cat ec
      where e.id = ec.estid and c.id = ec.catid and e.areaid = 3 and e.id != 1
      and c.id in (select c.id as cid from establishment e, category c, est_cat ec
                      where e.id = ec.estid and c.id = ec.catid and e.areaid = 3
                      and e.name like 'ABAN%'); */
  public function GetRelatedEstablishmentObjectCollection($eids, $areaid){
    $retval = array();
    $eid_comma_list = implode(',', $eids);
    $sql_statement = "select e.id, e.name, e.address, e.phone from
                        establishment e, category c, est_cat ec
                        where e.id = ec.estid and c.id = ec.catid and e.areaid = $areaid and e.id not in ($eid_comma_list)
                        and c.id in (select c.id as cid from establishment e, category c, est_cat ec
                                      where e.id = ec.estid and c.id = ec.catid and e.areaid = $areaid
                                      and e.id in ($eid_comma_list));";
    file_put_contents(__FUNCTION__ . '.log', $sql_statement);
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