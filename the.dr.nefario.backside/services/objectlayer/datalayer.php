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

  //get all the fields for an object
  public function GetObjectData($object){
    if (!isset($object->id)){
      $object->id = 'null';
    }
    $sql_statement = 'select * from ' . get_class($object) . ' where id = ' . $object->id;
    $result = $this->conn->query($sql_statement);
    $row = $result->fetch_assoc();
    while ($fieldinfo = $result->fetch_field()) {
      $object->{$fieldinfo->name} = $row[$fieldinfo->name];
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

  public function GetObjectIds($classname, $filter=null, $sortby=null, $sortdirection=null){
    $retval = array();
    $sql_statement = "select id from $classname";
    if ($filter != null){
      $sql_statement .= ' where';
      foreach ($filter as $fieldname => $fieldvalue){
        // checking for the like clause
        if (strpos($fieldvalue, '%')){
          $sql_statement .= " $fieldname like '$fieldvalue' and";
        } else {
          $sql_statement .= " $fieldname = '$fieldvalue' and";
        }
      }
    }

    // strip out last "and" but only if it exists
    if (substr($sql_statement, strlen($sql_statement) - 3, 3) === 'and'){
      $sql_statement = substr($sql_statement, 0, strlen($sql_statement) - 4);
   
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
  public function GetRelatedEstablishmentObjectIDs($eid, $areaid){
    $retval = array();
    $sql_statement = "select e.id from
                        establishment e, category c, est_cat ec
                        where e.id = ec.estid and c.id = ec.catid and e.areaid = $areaid and e.id != $eid
                        and c.id in (select c.id as cid from establishment e, category c, est_cat ec
                                      where e.id = ec.estid and c.id = ec.catid and e.areaid = $areaid
                                      and e.id = '$eid');";
    $result = $this->conn->query($sql_statement);
    while($row = $result->fetch_assoc()) {
      array_push($retval, $row['id']);
    }
    return $retval;
                                  
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