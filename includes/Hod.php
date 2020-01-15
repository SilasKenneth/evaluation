<?php
class Hod{
    private $id;
    private $id_num;
    private $username;
    private $email;
    private $phone;
    private $department;
    private $fullname;
    private $password;

    public static function all(){
        try{
            $sql = "SELECT * FROM hods";
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
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Hod");
            if(count($records)===0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            print_r($ex);
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
    public function getIdNum()
    {
        return $this->id_num;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
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
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }
    public function __construct(){}

    public static function getById($id){
        try{
            $id = intval($id);
            $sql = "SELECT * FROM hods WHERE id=?";
            $db = new Database();
            $conn = $db->connection();
            if (!gettype($conn) === "object"){
                return [];
            }
            $query = $conn->prepare($sql);
            if (!$query){
                return [];
            }
            $query->execute(array($id));
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Hod");
            if(zero($records)){
                return [];
            }
            return $records[0];

        }catch (Exception $ex){
            return [];
        }
    }

    public function getCourses(){
        $courses = Course::getByDepartmentId($this->department);
        return $courses;
    }
    public function getDepartment(){
        $department = Department::getById($this->department);
        return $department;
    }
    public function hash_password(){
        $this->password = hash("SHA512", $this->password);
    }
    public function verify_password($pass){
        return hash("SHA512", $pass) === $this->password;
    }
    public static function login($username_or_email, $password){
        $check = self::getByUsernameOrEmail($username_or_email);
        if(count($check) == 0){
            return false;
        }
        if($check->verify_password($password)){
            return $check;
        }
        return false;
    }
    public static function getByUsernameOrEmail($username_email){
        if(gettype($username_email) !== "string"){
            return [];

        }
        try{
            if(strlen($username_email) < 1){
                return [];
            }
            $final = array();
            array_push($final, $username_email);
            array_push($final, $final[0]);
//            print_r($final);
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
//                print_r(gettype($conn));
                return [];
            }
            $sql = "SELECT * FROM hods WHERE username = ? or email = ?";
//            print_r($final);
            $qr = $conn->prepare($sql);
            $qr->execute($final);
            $records = $qr->fetchAll(PDO::FETCH_CLASS, "Hod");
//            print_r($records);
//            print_r($qr);
            if($qr->rowCount() === 0) {
                return [];
            }
            return $records[0];
        }catch (Exception $e){
//            print_r($e);
            return [];
        }
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    public static function save($fullname, $email, $phone, $id_num, $department, $username, $password){
        try{
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $sql = "INSERT INTO hods(fullname, email, phone, id_num , department, username, password)VALUES(?, ?, ?, ?, ?, ?, ?)";
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $query->execute(array($fullname, $email, $phone, $id_num, $department, $username, $password));
            return true;
        }catch (Exception $ex){
            return false;
        }
    }

}