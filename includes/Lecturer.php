<?php
class Lecturer{
    private $id;
    private $email;
    private $id_number;
    private $phone;
    private $name;
    private $status;

    public static function save(string $name, string $phone, string $idnumber, string $email)
    {
        try{
            $sql = "INSERT INTO lecturers(name, phone, id_number,email)VALUES(?, ?, ?, ?)";
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $query->execute(array($name, $phone, $idnumber, $email));
            return true;
        }catch (Exception $ex){
//            print_r($ex);
            return false;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getIdNumber()
    {
        return $this->id_number;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
    public function __construct()
    {
    }

    public static function getById($lecturer)
    {
        $lecturer = intval($lecturer);
        try{
            $sql = "SELECT * FROM lecturers WHERE id=?";
            $db = new Database();
            $conn = $db->connection();
            if (gettype($conn) !== "object"){
                    return [];
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $lecturer);
            if(!$query){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Lecturer");
            if(count($records) === 0){
                return [];
            }
            return $records[0];
        }catch(Exception $e){
            return [];
        }
    }
    public static function all(){
        try{
            $sql = "SELECT * FROM lecturers";
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
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Lecturer");
            if(count($records)===0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }
}