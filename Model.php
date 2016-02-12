<?php
//Просто модель
abstract class Model {
    protected static $structure = array();
    protected  $properties = array();


    public function GetProperty($key){
        if($key == 'id'){
            return $this->properties['id'];
        }
        if(isset($this->properties[$key]))  {
            if(isset(static::$structure[$key])){
                if(static::$structure[$key]['access'] == 'public'){
                    return $this->properties[$key];
                }
            }
        }
        return NULL;
    }

    public function SetProperty($key,$value){
        if(isset($this->properties[$key]))  {
            if(isset(self::$structure[$key])){
                if(self::$structure[$key]['access'] == 'public'){
                  $this->properties[$key]=$value;
                }
            }
        }
    }




    public static function Generate($type){
       //Core::Instance();
       DB::Get()->Connect(Config::$db['host'],Config::$db['base'],Config::$db['user'],Config::$db['password']);
        $instance = new $type();
        if(empty($instance::$structure)) return;
        $tableName = get_class($instance);
        $queries = array();

       // $queries[]= array('query' =>'RENAME TABLE IF EXIST  '.$tableName.' TO '.'new_'.$tableName);
       // $queries[]= array('query'=>'DROP TABLE IF EXISTS '.$tableName);


        $queries[]= array('query'=>'CREATE TABLE  '.'new_'.$tableName.'(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID))');

        foreach($instance::$structure as $field=>$fieldData){
            $type=NULL;
            $length = isset($fieldData['length']) ? $fieldData['length'] : 10 ;
            $is_null = isset($fieldData['is_null']) ? $fieldData['is_null'] : 'NOT NULL';
            $description = isset($fieldData['description']) ? $fieldData['description'] : '';
            switch($fieldData['type']){
                case 'int':
                    $type = 'INT';
                    $value = isset($fieldData['value']) ? $fieldData['value'] : 'DEFAULT 0';
                    $unsigned = 'UNSIGNED';
                    $length ='('.$length.')';
                    $description = "COMMENT'$description'";
                    break;
                case 'string':
                    $type = 'VARCHAR';
                    $value = isset($fieldData['value']) ? $fieldData['value'] : '';
                    $length ='('.$length.')';
                    $description = "COMMENT'$description'";
                    break;
                case 'text':
                    $type = 'TEXT';
                    $length =null;
                    $unsigned = null;
                    $description = "COMMENT'$description'";
                    break;
            }
            if($type != NULL) {
                $queries[]=array('query'=>
                    'ALTER TABLE ' .'new_'.$tableName.' ADD '.$field.' '.$type.' '.$length.' '.$unsigned.' '.$is_null.' '.$description,
                );
            }
        }

        foreach($queries as $query){
              echo $query['query']. "\n\n";
        DB::Get()->Query($query['query'],isset($query['variables']) ? $query['variables'] : array());

        }


    }

    public static function Create(array $data = array()) {
        //Получаем имя текущего класса (если вызвали в Author, например)
        $className = get_called_class();
        $model = new $className();
        //Перебираем массив $data, устанавливаем свойства
        foreach($data as $key => $value) {
            $model->properties[$key] = $value;
        }
        return $model;
    }
}

?>