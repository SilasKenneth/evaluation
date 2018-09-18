<?php
class Database{
    private $conn;
    private $host = null;
    private $dbname = null;
    private $username = null;
    private $password = null;
    public function __construct($host = "localhost",$dbname="josephine", $username="root", $password=""){
        $this->dbname = $dbname;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        try{
            $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname;
            $this->conn = new PDO($dsn, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $ex){
//            print_r($ex);
            $this->conn = null;
        }
    }
    public function connection(){
        return $this->conn;
    }
}
