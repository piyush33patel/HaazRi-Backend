<?php
require_once dirname(__FILE__).'/Constants.php';
$con  =  mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$response = array();
if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_POST['email']))
            {
                $email = $_POST['email'];
                $sql = "SELECT * FROM student WHERE email = '{$email}'";
                $result = mysqli_query($con, $sql);
                while($row = mysqli_fetch_array($result))
                {
                    array_push($response, array("email"=>$row['email'],"name"=>$row['name'],"rollno"=>$row['rollno'],"branch"=>$row['branch'],"year"=>$row['year'],"semester"=>$row['semester']));
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
