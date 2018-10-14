<?php
class Student {
    private $id;
    private $firstname;
    private $surname;
    private $lastname;
    private $registration_no;
    private $course;
    private $year_of_study;
    private $status;
    private $phone;
    private $email;
    private $username;
    private $password;
    private $semester;
    private $values = array();
    private $has_empty = true;
    /**
     * @return mixed
     */
    public function __construct(){}
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getRegistrationNo()
    {
        return $this->registration_no;
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }

    
    public static function getById($lecturer)
    {
        $lecturer = intval($lecturer);
        try{
            $sql = "SELECT * FROM students WHERE id=?";
            $db = new Database();
            $conn = $db->connection();
            if (gettype($conn) !== "object"){
                return [];
            }
            $query = $conn->prepare($sql);
            $query->bindParam(1, $lecturer);
            if(!$query){
                return [];
            }
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Student");
            if(count($records) === 0){
                return [];
            }
            return $records[0];
        }catch(Exception $e){
            return [];
        }
    }
    public function getMyCompletedEvaluations(){
       try{
         $sql = "SELECT * FROM evaluation_logs where evaluation_id=(SELECT max(id) FROM evaluations WHERE evalutions.status=1) and student_id = ?";
         $db = new Database();
         $conn = $db->connection();
         if(gettype($conn) !== "object"){
           return [];
         }
         $query = $conn->prepare($sql);
         if(!$query){
           return false;
         }
         $query->execute(array($this->id));
         $records = $query->fetchAll(PDO::FETCH_CLASS, "Evaluation_Log");
         return $records;
       }catch(Exception $ex){
         return [];
       }
    }

    // Get the units the student does for the current semester and year
    public function getMyUnits(){
        try{
          $db = new Database();
          $conn = $db->connection();
          if(gettype($conn) !== "object"){
            return [];
          }
          $sql = "SELECT * FROM units where course = ? and  year_of_study=? and semester=?";
          $query = $conn->prepare($sql);
          $course = $this->course;
          $year = $this->year_of_study;
          $sem = $this->semester;
          if(!$query){
            return [];
          }
          $query->execute(array($course, $year, $sem));
          $records = $query->fetchAll(PDO::FETCH_CLASS, "Unit");
          if(zero($records)){
              return [];
          }
          $res = [];
          foreach($records as $record){
              if(zero($record->getLecturer())){
                  continue;
              }
              array_push($res, $record);
          }
          return $res;
        }catch(Exception $ex){
           return [];
        }
    }
    //TODO: Refactor this to take array as argument instead of a long list
    public function create($fn, $sn, $ln, $rg, $cr, $ye, $sem, $status, $ph, $email, $username, $password){
        $this->password = $password;
        $this->username = $username;
        $this->email = $email;
        $this->phone = $ph;
        $this->status = $status;
        $this->semester = $sem;
        $this->year_of_study = $ye;
        $this->course = $cr;
        $this->registration_no = $rg;
        $this->lastname = $ln;
        $this->surname = $sn;
        $this->firstname = $fn;
        $this->hash_password();
        $password = $this->password;
        $this->values = [$fn, $sn, $ln, $rg, $cr, $ye, $sem, $status, $ph, $email, $username, $password];
        foreach ($this->values as $field){
            if(!$field || trim($field)=== "" || is_null($field)){
                $this->has_empty = true;
                return;
            }
        }
        $this->has_empty = false;
    }
    public function hash_password(){
        $this->password = hash("SHA512", $this->password);
    }
    public function verify_password($pass){
        return hash("SHA512", $pass) === $this->password;
    }
    public function save(){
        if($this->has_empty){
            $errors = new Errors();
            return $errors->getByCode(104);
        }
        try{
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== 'object'){
                return FALSE;
            }
            $fields = "firstname, surname, lastname, registration_no, course, year_of_study,semester, status, phone,email,username, password";
            $qr = $conn->prepare("INSERT INTO students(".$fields.") VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $qr->execute($this->values);
            return true;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function login($username_or_email, $password){
        $check = self::getByUsernameOrEmail($username_or_email);
        if(count($check) == 0){
            return false;
        }
        if($check->verify_password($password)){
            return $check;
        }
        return false;
    }
    public static function getByUsernameOrEmail($username_email){
        if(gettype($username_email) !== "string"){
            return [];

        }
        try{
            if(strlen($username_email) < 1){
                return [];
            }
            $final = array();
            array_push($final, $username_email);
            array_push($final, $final[0]);
//            print_r($final);
            $db = new Database();
            $conn = $db->connection();
            if(gettype($conn) !== "object"){
//                print_r(gettype($conn));
                return [];
            }
            $sql = "SELECT * FROM students WHERE (username= ?) or (email = ?)";
//            print_r($final);
            $qr = $conn->prepare($sql);
            $qr->execute($final);
            $records = $qr->fetchAll(PDO::FETCH_CLASS, "Student");
//            print_r($records);
            //print_r($qr);
            if($qr->rowCount() === 0) {
                return [];
            }
            return $records[0];
        }catch (Exception $e){
//            print_r($e);
            return [];
        }
    }
    public function getCourse(){
        $course = Course::getById($this->course);;
        return $course;
    }
    private function inDone($done_units, $unit_id){
        if(zero($done_units)){
            return false;
        }
        foreach ($done_units as $done_unit){
            if($done_unit->getUnitId() === $unit_id){
                return true;
            }
        }
        return false;
    }
    public function getEvaluationDone(){
        try{
            $sql = "SELECT * FROM evaluation_logs WHERE student_id = ? AND evaluation_id = (SELECT MAX(evaluations.id) FROM evaluations where evaluations.status=1)";
            $db = new Database();
            $conn = $db->connection();
            $units = $this->getMyUnits();
            if(gettype($conn) !== "object"){
                return [];
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return [];
            }
            $query->execute(array($this->id));
            $results = [];
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Evaluation_Log");
            if(zero($records)){
                return [];
            }
            if(zero($units)){
                return [];
            }
            foreach ($units as $unit){
                if($this->inDone($records, $unit->getId())){
                    array_push($results, $unit);
                }
            }
            return $results;
        }catch(Exception $ex){
            return [];
        }
    }
    public function getEvaluationNotDone(){
        try{
            $sql = "SELECT * FROM evaluation_logs WHERE student_id = ? AND evaluation_id = (SELECT MAX(evaluations.id) FROM evaluations WHERE evaluations.status=1)";
            $db = new Database();
            $conn = $db->connection();
            $units = $this->getMyUnits();
            if(gettype($conn) !== "object"){
                return $units;
            }
            $query = $conn->prepare($sql);
            if(!$query){
                return $units;
            }
//            print_r("Here");
            $query->execute(array($this->id));
            $results = [];
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Evaluation_Log");
            if(zero($records)){
//                print("HERE");
                return $units;
            }
            if(zero($units)){
                return $units;
            }
            foreach ($units as $unit){
                if(!$this->inDone($records, $unit->getId())){
                    array_push($results, $unit);
                }
            }
            return $results;
        }catch(Exception $ex){
            return $units;
        }
    }
    public function thisIsDone($unit_id){
        $dones = $this->getEvaluationDone();
        if(zero($dones)){
            return false;
        }
        foreach ($dones as $done){
            if($done->getId() === $unit_id){
                return true;
            }
        }
        return false;
    }
    public function isMyUnit($unit_id){
        $my_units = $this->getMyUnits();
        if(zero($my_units)){
            return false;
        }
        foreach ($my_units as $my_unit) {
            if($my_unit->getId() === $unit_id){
                return true;
            }
        }
        return false;
    }

    public static function all(){
        try{
            $sql = "SELECT * FROM students";
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
            $records = $query->fetchAll(PDO::FETCH_CLASS, "Student");
            if(count($records)===0){
                return [];
            }
            return $records;
        }catch (Exception $ex){
            return [];
        }
    }
    public function getName(){
        return $this->firstname. " ". $this->surname . " ". $this->lastname;
    }
}
