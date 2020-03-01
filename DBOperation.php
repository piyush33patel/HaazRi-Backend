<?php
class DBOperation{
    private $con;
    function __construct(){
        require_once dirname(__FILE__).'/DBConnect.php';
        $db = new DBConnect();
        $this->con = $db->connect();
    }
    function InsertData($email, $name, $rollno, $year, $branch, $semester){
        $stmt = $this->con->prepare("INSERT INTO `student` (`email`, `name`, `rollno`, `year`,`branch`, `semester`) VALUES (?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("ssssss", $email, $name, $rollno, $year, $branch, $semester);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
}
?>
