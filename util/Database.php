<?php
class Database{
    private $conn;
    private $host = null;
    private $dbname = null;
    private $username = null;
    private $password = null;
    public function __construct($host = "localhost",$dbname="josephine", $username="root", $password=""){
        $envHost = getenv("DB_HOST");
        $envDbName = getenv("DB_NAME");
        $envDbUser = getenv("DB_USERNAME");
        $envDbPassword = getenv("DB_PASSWORD");
        $this->dbname = $envDbName ? $envDbName : $dbname;
        $this->host = $envHost ? $envHost : $host;
        $this->username = $envDbUser ? $envDbUser : $username;
        $this->password = $envDbPassword ? $envDbPassword : $password;
        // print_r(getenv());
        try{
            $dsn = "pgsql:host=".$this->host.";dbname=".$this->dbname;
            $this->conn = new PDO($dsn, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $ex){
           print_r($ex);
            $this->conn = null;
        }
    }
    public function connection(){
        return $this->conn;
    }
}
