<?php


namespace core;


abstract class DbModel extends Model 
{
    abstract public static function tableName(): string ; 
    abstract public function attributes(): array; 
    abstract public static function primaryKey(): string;
    abstract public static function getUrlService(): string;
    
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql); 

    } 

    public function prepareJson() 
    {
        $jsonObject = [];
        $attributes = $this->attributes();
        foreach($attributes as $attribute) {
            $jsonObject[$attribute] = $this->{$attribute};
        }
        return json_encode($jsonObject,JSON_PRETTY_PRINT);
    }
    
    public function save()
    {
      
       $payload = $this->prepareJson();

       // print_r($payload);
       // exit;


       // $url = 'localhost:8081/insertPaste';
       $url = static::getUrlService();

       $ch = curl_init($url);

       // Attach encoded JSON string to the POST fields
       curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

       // Set the content type to application/json
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

       // Return response instead of outputting
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

       // Execute the POST request
       $res = curl_exec ($ch);

       $codHTTP = curl_getinfo ($ch, CURLINFO_RESPONSE_CODE);
       $tip = curl_getinfo ($ch, CURLINFO_CONTENT_TYPE);     

       curl_close ($ch);

       if ($codHTTP == 200 && $tip == 'application/json; charset=UTF-8') {
           // header ('Content-Type: ' . $tip); // trimitem tipul MIME corespunzator (adica image/jpeg in acest caz)
           // echo $res; // afisam reprezentarea resursei obtinute (aici, imaginea in format JPEG)
           return true;
         } else {
             return false;
           // http_response_code ($codHTTP); // s-a obtinut altceva, trimitem codul de stare intors de serviciu
           // header ('Content-Type: text/plain');
           // echo 'Status code: ' . $codHTTP;
           
         }

       // $arr = json_decode($res,true);
       // echo '<pre>';
       // print_r($arr);
       // echo '</pre>';

       
   }

    public static function findVersionDetalied($where) {

        $statement = self::prepare("SELECT * FROM  pastes p  JOIN versions v ON v.id=p.id WHERE v.slug = '$where' AND expiration > CURRENT_TIMESTAMP;");
        $statement->execute();
        return $statement->fetchObject();
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