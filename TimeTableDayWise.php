<?php
require_once dirname(__FILE__).'/Constants.php';
$con  =  mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$response = array();
if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_POST['dayOfWeek']) and isset($_POST['email']))
            {
                $dayOfWeek = $_POST['dayOfWeek'];
                $email = $_POST['email'];
                $sql = "SELECT title FROM courses,timetable,student WHERE courses.code=timetable.code AND day='{$dayOfWeek}' AND email = '{$email}' order by starts desc";
                $result = mysqli_query($con, $sql);
                while($row = mysqli_fetch_array($result))
                {
                    array_push($response, array("title"=>$row['title']));
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
