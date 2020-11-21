<?php
$database=mysqli_connect("localhost", "root", "", "diana-responsi");
if($database->connect_errno){
    echo "Failed to Connect Databases";
}

class Database {
    // static protected $test;
    public function __construct(Array $arrayData){
        foreach(static::$db_fields as $field){
            if(!property_exists($this,$field)){
                $this->{$field}=$arrayData[$field];
            }
            
        }
    }

    static protected function query($str){
        global $database;
        $result=$database->query($str);
        $data=[];
        while($row=mysqli_fetch_assoc($result)){
            array_push($data,$row);
        }
        return $data;
    }
    static protected function rawQuery($str){
        global $database;
        return $database->query($str);
    }
    static protected function insert($table,Array $data){
        global $database;
        $_keys=array_keys($data);
        $_values=array_values($data);
        $fieldNames=implode(",",$_keys);
        $fieldValues=implode(",",$_values);
        var_dump("insert into $table ($fieldNames) values($fieldValues)");
        return $database->query("insert into $table ($fieldNames) values($fieldValues)");
    }

    public function update(Array $data){
        
        $_arraySql=[];
        foreach($data as $key=>$value){
            array_push($_arraySql,"$key = '$value'");
        }
        $sqlUpdate=implode(",",$_arraySql);
        // var_dump("update ".static::$table." set $sqlUpdate where ".static::$primaryKey."= ". $this->{static::$primaryKey});
        return self::rawQuery("update ".static::$table." set $sqlUpdate where ".static::$primaryKey."= ". $this->{static::$primaryKey});
    }

    static public function findByKey($idKey){
        $result=self::getWhereData(static::$primaryKey." = '$idKey'");
        
        if(count($result)>0){
        return new static($result[0]);
        }
    }

    static public function getWhereData($whereSql,Array $fieldArray=null){
        
        if($fieldArray!=null){
            $_values=array_values($fieldArray);
            $field=implode(",",$_values);
            return self::query("select $field from ".static::$table." where $whereSql");
        }
        return self::query("select * from ".static::$table." where $whereSql");
    }

    static public function getAllData($array=null){
        if($array!=null){
            $_values=array_values($array);
            $field=implode(",",$_values);
            return self::query("select $field from ".static::$table);
        }
       return self::query("select * from ".static::$table);
        
    }
    static public function saveData(Array $data){
        return self::insert(static::$table,$data);
    }
}

?>