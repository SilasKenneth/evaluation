<?php
class Question
{
    private $id;
    private $content;
    private $question_type;
    private $evaluation_id;
    private $date_added;
    public function __construct()
    {

    }
    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getQuestionType()
    {
        return $this->question_type;
    }

    public function getEvaluationId()
    {
        return $this->evaluation_id;
    }
    public function getDateAdded()
    {
        return $this->date_added;
    }

    public static function add($quiz_type,  $content){
        try{
            $sql = "insert into questions(question_type, content)values(?, ?)";
            $values = array($quiz_type,  $content);
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
    public static function all(){
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
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Question");
            if(count($records)===0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }

    public static function getById($id){
        try{
            $id = intval($id);
            $sql = "SELECT * FROM questions WHERE id=?";
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
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Question");
            if(zero($records)){
                return [];
            }
            return $records[0];

        }catch (Exception $ex){
            return [];
        }
    }
}