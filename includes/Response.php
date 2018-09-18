<?php
/**
 * Created by PhpStorm.
 * User: projecta
 * Date: 9/13/18
 * Time: 3:10 PM
 */

class Response
{
    private $id;
    private $lecturer;

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
    public function getLecturer()
    {
        return $this->lecturer;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return Unit::getById($this->unit);
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getEvaluation()
    {
        return Evaluation::getById($this->evaluation);
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return Question::getById($this->question);
    }
    private $unit;
    private $student;
    private $value;
    private $evaluation;
    private $question;
    public function __construct(){}
    public static function getByEvalAndLecturerAndUnit($unit, $lecturer, $evaluation){
        try{
            $sql = "SELECT * FROM responses WHERE unit = ? and lecturer = ? and evaluation = ?";
            $db = new Database();
            $conn = $db->connection();
            if(!$conn){
                return [];
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return [];
            }
            $query->execute(array($unit, $lecturer, $evaluation));
            $found = $query->fetchAll(PDO::FETCH_CLASS, "Response");
            return $found;
        }catch (Exception $ex){
            return [];
        }
    }
}