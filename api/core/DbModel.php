<?php


namespace core;


abstract class DbModel extends Model 
{
    abstract public static function tableName(): string ; 
    abstract public function attributes(): array; 
    abstract public static function primaryKey(): string;
    
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql); 

    } 
    
     public function save()
     {
       
        $tableName  = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($attr) => ":$attr", $attributes); 
      

        $statement = self::prepare("INSERT INTO $tableName ( ".implode(',' , $attributes).") 
               VALUES(".implode(',' , $params) .")"); 
       
        var_dump(get_object_vars($this));
        
         
        foreach($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();

        return true;
    }

    public static function findVersionDetalied($where) {

        $statement = self::prepare("SELECT * FROM versions v JOIN pastes p ON v.id=p.id WHERE v.slug = '$where' AND expiration > CURRENT_TIMESTAMP;");
        $statement->execute();
        return $statement->fetchObject(static::class);
    }


    public static function findOneImproved($tableName, $where)
    {
        $attributes = array_keys($where); 
        $sql =  implode("AND", array_map(fn($attr) => "$attr = :$attr" , $attributes));


        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql AND expiration > CURRENT_TIMESTAMP");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);

    }

    public static function findOne($where)
    {

        $tableName = static::tableName();
        $attributes = array_keys($where); 
        $sql =  implode("AND", array_map(fn($attr) => "$attr = :$attr" , $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);

    }
    
}