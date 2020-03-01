<?php
require_once dirname(__FILE__).'/Constants.php';
$con  =  mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$response = array();
if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_POST['email']) and isset($_POST['title']))
            {
                $email = $_POST['email'];
                $title = $_POST['title'];
                $sql = "SELECT code FROM courses where title = '{$title}'";
                $result = mysqli_query($con, $sql);
                $code = "";
                while($row1 = mysqli_fetch_array($result))
                {
                    $code = $row1["code"];
                }    
                $sql2 = "SELECT date,value,time FROM attendance NATURAL JOIN student WHERE email = '{$email}' AND code = '{$code}' ORDER by date";
                $result2 = mysqli_query($con, $sql2);
                while($row = mysqli_fetch_array($result2))
                {
                    //Create Json
                    array_push($response, array("date"=>$row['date'],"value"=>$row['value'],"time"=>$row['time']));
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
