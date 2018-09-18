<?php
class Errors{
    private $errors = [];
    public function __construct()
    {
        $this->errors = [
            104 => "All fields are required",
            404 => "The record you're looking for was not found"
        ];
    }
    public function getByCode($code){
        if(isset($this->errors[$code])){
            return $this->errors[$code];
        }
        return "";
    }
}