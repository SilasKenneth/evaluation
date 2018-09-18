<?php
class School{
    private $id;
    private $name;

    public static function all(){
        try{
            $sql = "SELECT * FROM schools";
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return [];
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "School");
            if(count($records)===0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    public function __construct(){}
    public static function getById($id){
        $id = intval($id);
        try{
            $sql = "SELECT * FROM schools WHERE id=?";
            $db = new Database();
            $conn = $db->connection();
            if (!empty($conn)) {
                if(!$conn){

                }
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $id);
            if(!$query){
                return null;
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "School");
            if (count($records) === 0) {
                return null;
            }
            return $records[0];
        }catch (Exception $ex){
            return null;
        }
    }

    public static function save($name){
        try{
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $sql = "INSERT INTO schools(name)VALUES(?)";
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $query->execute(array($name));
            return true;
        }catch (Exception $ex){
            return false;
        }
    }

}