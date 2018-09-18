<?php
class Course{
    private $id;

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
    private $name;
    private $department;
    public function __construct(){}
    public static function getById($id){
        $id = intval($id);
        try{
            $sql = "SELECT * FROM courses WHERE id=?";
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return [];
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $id);
            if(!$query){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Course");
            if(count($records)===0){
                return [];
            }
            return $records[0];
        }catch (Exception $ex){
            return [];
        }
    }
    public static function getByDepartmentId($department){
        $department = intval($department);
        try{
            $sql = "SELECT * FROM courses WHERE department=?";
            $db = new Database();
            $conn = $db->connection();
            if (gettype($conn) != "object"){
                return [];
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $department);
            if(!$query){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Course");
            if (!empty($records)) {
                if(!$records){
                    return [];
                }
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }
    /* Get all units for this course */
    public function getUnits(){
        $units = Unit::getByCourseId($this->id);
//        print_r($units);
        return $units;
    }
    /* Return the department of this course */
    public function getDepartment(){
        $department = Department::getById($this->department);
        return $department;
    }
    public static function all(){
        try{
            $sql = "SELECT * FROM courses";
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
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Course");
            if(count($records)===0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }
    public static function save($name, $department){
        try{
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $sql = "INSERT INTO courses(name, department)VALUES(?, ?)";
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $query->execute(array($name, $department));
            return true;
        }catch (Exception $ex){
            return false;
        }
    }
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM courses WHERE id= ?";
            $db = new Database();
            $conn = $db->connection();
            if (gettype($conn) !== "object") {
                return false;
            }
            $query = $conn->prepare($sql);
            if (!$query) {
                return false;
            }
            $query->execute(array($id));
            return true;
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }
    }

}
