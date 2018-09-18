<?php
class Evaluation
{
    private $id;
    private $start_date;

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
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
    private $end_date;
    private $status;

    public function __construct()
    {
    }
    public static function create($endate, $note){
        try{
            $sql = "INSERT INTO evaluations(end_date, note, status)values(?, ?, ?)";
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $status = 1;
            $query->execute(array($endate, $note, $status));
            return true;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function closeAll(){
        try{

            $sql = "UPDATE evaluations SET status=0 WHERE end_date <= CURRENT_TIMESTAMP";
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return;
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return;
            }
            $query->execute();
        }catch (Exception $exception){
            return;
        }
    }
    public static function getCurrentActive(){
        try{
            $sql = "SELECT * FROM evaluations WHERE status = 1 AND end_date >= CURRENT_TIMESTAMP ORDER BY id";
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return [];
            }
            self::closeAll();
            $query = $conn->prepare($sql);
            if(!$conn){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Evaluation");
            if(zero($records)){
                return [];
            }
            return $records[count($records) - 1];
        }catch (Exception $exception){
            return [];
        }
    }
    public static function getById($id)
    {
        $id = intval($id);
        try {
            $sql = "SELECT * FROM evaluations WHERE id=?";
            $db = new Database();
            $conn = $db->connection();
            if (gettype($conn) !== "object") {
                return [];
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $id);
            if (!$query) {
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Evaluation");
            if (count($records) === 0) {
                return [];
            }
            return $records[0];
        } catch (Exception $e) {
            return [];
        }
    }
    public function getQuestions(){
        try{
            $sql = "SELECT * FROM questions";
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return [];
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return [];
            }
            $query->execute(array($this->id));
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Question");
            if(zero($records)){
                return [];
            }
            return $records;
        }catch (Exception $exception){
//            print_r($exception);
            return [];
        }
    }

    public static function all(){
        try{
            $sql = "SELECT * FROM evaluations";
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
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Evaluation");
            if(count($records)===0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }
    public function close(){
        try{
            $sql = "UPDATE evaluations SET status = 0 WHERE id = ?";
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $query->execute(array($this->id));
            return true;
        }catch (Exception $ex){
            return false;
        }
    }
    public function extend($newdate){
        try{
            $sql = "UPDATE evaluations SET status = 1 , end_date = ? WHERE id = ? ";
            $values = array($newdate, $this->id);
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return false;
            }
            $query->execute($values);
            return true;
        }catch (Exception $ex){
            return false;
        }
    }

    public static function castVote($student, $unit, $lecturer, $average, $evaluation, $responses){
        try{
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
                return false;
            }
            $sql = "INSERT INTO votes(student, lecturer, unit, score, evaluation)VALUES(?, ?, ?, ?, ?)";
            $query =$conn->prepare($sql);
            if(!$query){
                return false;
            }
            $sql1 = "INSERT INTO evaluation_logs(student_id, lecturer, unit_id, evaluation_id)VALUES(?, ?, ?, ?)";
            if(!zero($responses)){
                foreach ($responses as $response){
                    $sql2 = "INSERT INTO responses(lecturer, unit, student,evaluation, value, question)VALUES(?, ?, ?, ?, ?,?)";
                    $query3 = $conn->prepare($sql2);
                    $query3->execute(array($lecturer, $unit, $student, $evaluation, $response[1], $response[0]));
                }
            }
            $query_mark_done = $conn->prepare($sql1);
            $query_mark_done->execute(array($student, $lecturer, $unit, $evaluation));
            if(intval($average) > 0.0) {
                $query->execute(array($student, $lecturer, $unit, $average, $evaluation));
            }
            return true;
        }catch (Exception $ex){
//            print_r($ex);
            return false;
        }
    }

}

