<?php

class LitheDB
{
  private $conn;
  function __construct($dbname)
  {
    // Create connection
    $this->conn = new mysqli('localhost', 'root', 'password', $dbname);
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
  }

  public function select($table,$checks=NULL)
  {
    //print_r($table);
    $i=0;
    $sql = "SELECT * FROM $table";
    if (isset($checks)) {
      $sql .= " WHERE ";
      foreach ($checks as $key => $value) {
        if ($i>0)
          $sql.=" AND ";
        if (is_string($value)){
          $value="'".$value."'";
          $sql .= $key. " LIKE ".$value;
        }else
          $sql .= $key. "=".$value;
        $i++;
      }
    }
    //print_r($sql);
    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $resArr = array();
        while($row = $result->fetch_assoc()) {
            $resArr[]= $row;
        }
        return $resArr;
    } else {
        return [];
    }
  }

  public function query($sql)
  {
    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $resArr = array();
        while($row = $result->fetch_assoc()) {
            $resArr[]= $row;
        }
        return $resArr;
    } else {
        return [];
    }
  }

  public function select_single($table,$checks=NULL)
  {
    $i=0;
    $sql = "SELECT * FROM $table";
    if (isset($checks)) {
      $sql .= " WHERE ";
      foreach ($checks as $key => $value) {
        if ($i>0)
          $sql.=" AND ";
        if (is_string($value))
          $value="'".$value."'";
        $sql .= $key. "=".$value;
        $i++;
      }
    }

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $resArr = array();
        while($row = $result->fetch_assoc()) {
            return $row;
        }
    } else {
        return [];
    }
  }

  public function insert($table,$data)
  {
    if (!isset($data))
      return false;
    $field="";
    $values="";
    foreach ($data as $key => $value) {
      $field.=$key.",";
      if (is_string($value))
        $value="'".$value."'";
      $values.=$value.",";
    }
    $field=rtrim($field, ",");
    $values=rtrim($values, ",");
    $sql = "INSERT INTO $table ($field) VALUES ($values)";
    if ($this->conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
  }

  public function update($table,$data,$checks)
  {

    if (!isset($data) || !isset($checks))
      return false;
    $sql = "UPDATE $table SET ";
    $i=0;
    foreach ($data as $key => $value) {
      if ($i>0)
        $sql.=", ";
      if (is_string($value))
        $value="'".$value."'";
      $sql.=$key."=".$value;
      $i++;
    }
    $sql .= " WHERE ";
    $i=0;
    foreach ($checks as $key => $value) {
      if ($i>0)
        $sql.=" AND ";
      if (is_string($value))
        $value="'".$value."'";
      $sql.=$key."=".$value;
      $i++;
    }
    if ($this->conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
  }
  public function delete($table,$checks)
  {

    if (!isset($checks))
      return false;
    $sql = "DELETE FROM $table WHERE ";
    $i=0;
    foreach ($checks as $key => $value) {
      if ($i>0)
        $sql.=" AND ";
      if (is_string($value))
        $value="'".$value."'";
      $sql.=$key."=".$value;
      $i++;
    }
    if ($this->conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
  }

  function __destruct()
  {
    $this->conn->close();
  }
}

?>
