<?php
require_once dirname(__FILE__).'/Constants.php';
$con  =  mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$response = array();
if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_POST['email']) and isset($_POST['title']) and isset($_POST['date']))
            {
                $date = $_POST['date'];
                $email = $_POST['email'];
                $title = $_POST['title'];
                 //get subject code
                $sql_code = "SELECT code FROM courses where title = '{$title}'";
                $result_code = mysqli_query($con, $sql_code);
                $code="";
                while($row_code = mysqli_fetch_array($result_code))
                {
                    $code = $row_code["code"];
                }                
                //get subject code
                $sql = "DELETE FROM attendance WHERE email = '{$email}' AND code = '{$code}' AND date = '{$date}'";
                if(mysqli_query($con, $sql))
                {
                    $response['error'] = false;
                    $response['message'] = "Deletion Successful";
                }
                else
                {
                    
                    $response['error'] = true;
                    $response['message'] = mysqli_error($con);
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
