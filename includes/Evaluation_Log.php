<?php
class Evaluation_Log{
   private $unit_id;
   private $evaluation_id;
   private $student_id;
   private $lecturer;
    /**
     * @return mixed
     */
    public function getUnitId()
    {
        return $this->unit_id;
    }

    /**
     * @return mixed
     */
    public function getEvaluationId()
    {
        return $this->evaluation_id;
    }

    /**
     * @return mixed
     */
    public function getStudentId()
    {
        return $this->student_id;
    }
   public function __construct(){}
   public function getEvaluation(){
     $evaluation = Evaluation::getById($this->evaluation_id);
     return $evaluation;
   }
   public function getUnit(){
     $unit = Unit::getById($this->unit_id);
     return $unit;
   }

    /**
     * @return mixed
     */
    public function getLecturer()
    {
        $lecturer = Lecturer::getById($this->lecturer);
        return $lecturer;
    }
}
