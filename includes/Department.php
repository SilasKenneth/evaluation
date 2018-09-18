<?php

class Department{
    private $id;
    private $school;
    private $name;
    private $units_array = array();
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

    /**
     * @param $id
     * @return null
     */
    public static function getById($id){
        try{
            $id = intval($id);
            $sql = "SELECT * FROM departments WHERE id=?";
            $db = new Database();
            $conn = $db->connection();
            if (!gettype($conn) === "object"){
                return [];
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $id);
            if (!$query){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Department");
            if(count($records) === 0){
                return [];
            }
            return $records[0];

        }catch (Exception $ex){
            return [];
        }
    }
    public function getSchool(){
        $school = School::getById($this->school);
        return $school;
    }
    public function getCourses(){
        $courses = Course::getByDepartmentId($this->id);
        return $courses;
    }
    public function getUnits(){
        $result = [];
        $courses = $this->getCourses();
        if(zero($courses)){
            return [];
        }

        foreach ($courses as $course){
            $result = array_merge($course->getUnits(), $result);
        }
        foreach ($result as $item) {
            array_push($this->units_array, $item->getId());
        }
        return $result;
    }
    public static function all(){
        try{
            $sql = "SELECT * FROM departments";
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
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Department");
            if(count($records)===0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }

    public static function save($name, $school){
        try{
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $sql = "INSERT INTO departments(name, school)VALUES(?, ?)";
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $query->execute(array($name, $school));
            return true;
        }catch (Exception $ex){
            return false;
        }
    }

    public function getResults($evaluation){
        try{
            $units = $this->getUnits();
            $sql = "SELECT lecturer, unit, avg(score) as average FROM votes WHERE evaluation = ? GROUP BY lecturer, unit";
            $db = new Database();
            $conn = $db->connection();
            if(!$conn){
                return [];
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return [];
            }
            $query->execute(array($evaluation));
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Result");
            if(zero($records)){
                return [];
            }
            $results = [];
            foreach ($records as $record){
                if(in_array($record->getUnit()->getId(), $this->units_array)){
                    array_push($results, $record);
                }
            }
            return $results;
        }catch (Exception $ex){
            return [];
        }
    }

}
