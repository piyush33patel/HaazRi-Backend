<?php
require_once dirname(__FILE__).'/Constants.php';
$con  =  mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$response = array();


$code = "";
$count = 0;
if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_POST['email']) and 
                isset($_POST['course']) and 
                    isset($_POST['date']) and 
                            isset($_POST['value'])
                )
            {
                $email = $_POST['email'];
                $course = $_POST['course'];
                $date = $_POST['date'];
                $value = $_POST['value'];
                
                //get subject code
                $sql_code = "SELECT code FROM courses where title = '{$course}'";
                $result = mysqli_query($con, $sql_code);
               
                while($row = mysqli_fetch_array($result))
                {
                    $code = $row["code"];
                }                
                //get subject code
                
                //Check if Already Marked
                $sql_count = "SELECT count(id) from attendance where email = '{$email}' AND code = '{$code}' AND date = '{$date}'";
                $result_count = mysqli_query($con, $sql_count);
                
                while($row1 = mysqli_fetch_array($result_count))
                {
                    $count = $row1["count(id)"];
                }
                //Check if Already Marked
                
                //Mark attendance
                if($count == 0){
                    $sql = "INSERT INTO attendance (code, email, date, value, time) VALUES ('{$code}','{$email}','{$date}','{$value}', CURRENT_TIMESTAMP);";
                    
                    if(mysqli_query($con, $sql)){
                        $response['error'] = false;
                        $response['message'] = "Attendance Marked";
                    }
                    else{
                        
                        $response['error'] = true;
                        $response['message'] = mysqli_error($con);
                    }
                }
                else{
                    $sql = "UPDATE attendance SET value = '{$value}', time = CURRENT_TIMESTAMP WHERE email = '{$email}' and date = '{$date}' AND code = '{$code}'";
                    
                    if(mysqli_query($con, $sql)){
                        $response['error'] = false;
                        $response['message'] = "Attendance Marked";
                    }
                    else{
                        
                        $response['error'] = true;
                        $response['message'] = mysqli_error($con);
                    }
                }
                //Mark Attendance
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
