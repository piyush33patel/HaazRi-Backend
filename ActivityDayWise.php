<?php
require_once dirname(__FILE__).'/Constants.php';
$con  =  mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_POST['email']))
            {
                $email = $_POST['email'];
                $sql = "SELECT DISTINCT(date) FROM `attendance` WHERE email='{$email}' ORDER by date DESC";
                $result = mysqli_query($con, $sql);
                $date = "";
                while($row1 = mysqli_fetch_array($result))
                {
                    $date = $row1["date"];
                    $sql2 = "SELECT DISTINCT(title),value FROM attendance NATURAL JOIN courses NATURAL JOIN timetable where attendance.date = '{$date}' and email = '{$email}' ORDER BY starts asc";
                    $result2 = mysqli_query($con, $sql2);
                    $subject = array();
                    while($row = mysqli_fetch_array($result2))
                    {
                        //Create Json
                        array_push($subject, array("title"=>$row['title'],"value"=>$row['value']));
                    }
                    array_push($response,array("date"=>$date,"subject"=>$subject));
                }    
                
            }
        else
            {
                $response['error'] = true;
                $response['message'] = "Required Field are Missing";
            }
    }
else
    {
        $response['error'] = true;
        $response['message'] = "Invalid Request";
    }
echo json_encode($response);
?>
