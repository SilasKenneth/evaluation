<?php
class Result
{
    private $id;
    private $lecturer;
    private $unit;
    private $average;
    private $evaluation;

    /**
     * @return mixed
     */
    public function getLecturer()
    {
        return Lecturer::getById($this->lecturer);
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
    public function getEvaluation()
    {
        return $this->evaluation;
    }
    /**
     * @return mixed
     */
    public function getAverage()
    {
        return $this->average;
    }

    public function getId(){
        return $this->id;
    }
}