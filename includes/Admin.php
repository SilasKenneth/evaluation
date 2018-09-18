<?php
class Admin
{
    private $id;
    private $username;
    private $fullname;
    private $phone;
    private $email;
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function getPhone()
    {
        return $this->phone;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function __construct()
    {
    }
    public static function getById($admin){
        $admin = intval($admin);
        try{
            $sql = "SELECT * FROM admins WHERE id=?";
            $db = new Database();
            $conn = $db->connection();
            if (gettype($conn) !== "object"){
                return [];
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $admin);
            if(!$query){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Admin");
            if(count($records) === 0){
                return [];
            }
            return $records[0];
        }catch(Exception $e){
            return [];
        }
    }

    public function login($password){
        return $this->confirmPassword($password);
    }

    public function confirmPassword($password){
        $password = hash("SHA512", $password);
        return $password === $this->password;
    }
    public function getByEmailOrUsername($username){
        try{
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return [];
            }
            $sql = "SELECT * FROM admins WHERE username=? or email=?";
            $query = $conn->prepare($sql);
            $query->execute(array($username, $username));
            $found = $query->fetchAll(PDO::FETCH_CLASS, "Admin");
            if(zero($found)){
                return [];
            }
            return $found[0];
        }catch (Exception $ex){
            return [];
        }
    }
}