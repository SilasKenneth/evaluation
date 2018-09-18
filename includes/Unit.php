<?php
class Unit
{
    private $id;
    private $course;
    private $year_of_study;
    private $semester;
    private $code;
    private $title;
    private $lecturer;
    private $description;
    private $done;

    public static function save($title, $code, $year, $semester, $course,$lecturer)
    {
        try{
            $sql = "INSERT INTO units(title, code, year_of_study, semester, course, lecturer)VALUES(?, ?, ?, ?, ?, ?)";
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $query->execute(array($title, $code, $year, $semester, $course, $lecturer));
            return true;
        }catch (Exception $ex){
            return false;
        }
    }

    public function updates($title, $code, $year, $semester, $course, $lecturer)
    {
        try{
            $sql = 'UPDATE units SET title = ?, code = ?, year_of_study = ?, semester = ?, course=?, lecturer=? WHERE id = ?';
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $query->execute(array($title, $code, $year, $semester, $course, $lecturer, $this->id));
            return true;
        }catch (Exception $ex){
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
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
    public function getYearOfStudy()
    {
        return $this->year_of_study;
    }

    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->done;
    }
    /**
     * @param bool $done
     */
    public function setDone()
    {
        $this->done = true;
    }
    public function __construct(){
        $this->done = false;
    }
    public static function getById($id){
        $id = intval($id);
        try{
            $sql = "SELECT * FROM units WHERE id=?";
            $db = new Database();
            $conn = $db->connection();
            if (!$conn) {
                return [];
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $id);
            if(!$query){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Unit");
                if(count($records) === 0){
                    return [];
                }
            return $records[0];
        }catch (Exception $ex){
            return [];
        }
    }
    public static function getByCourseId($course_id){
        $course_id = intval($course_id);
        try{
            $sql = "SELECT * FROM units WHERE course=?";
            $db = new Database();
            $conn = $db->connection();
            if (!$conn or gettype($conn) !== "object") {
                return null;
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $course_id);
            if(!$query){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Unit");
            if(count($records) === 0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }
    public function getLecturer(){
        $lecturer = Lecturer::getById($this->lecturer);
        return $lecturer;
    }
    public function getCourse(){
        $course = Course::getById($this->course);
        return $course;
    }
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM units WHERE id= ?";
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
            return false;
        }
    }
    public static function all(){
        try{
            $sql = "SELECT * FROM units";
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
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Unit");
            if(count($records)===0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }
}