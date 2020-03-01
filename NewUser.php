<?php
require_once dirname(__FILE__).'/DBOperation.php';
$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['email']) and 
            isset($_POST['name']) and
                isset($_POST['rollno']) and
                    isset($_POST['year']) and
                            isset($_POST['branch']) and
                                isset($_POST['semester']) 
            )
    {
        //operate further
        $db = new DBOperation();
        
        if($db->InsertData($_POST['email'], $_POST['name'],$_POST['rollno'],$_POST['year'],$_POST['branch'],$_POST['semester']))
        {
            $response['error'] = false;
            $response['message'] = "USER REGISTERED";
        }
        else{
            $response['error'] = true;
            $response['message'] = "USER NOT RESGISTERED";
        }
    }
else{
    $response['error'] = true;
    $response['message'] = "Required Field are Missing";
}
}
else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}
echo json_encode($response);

?>
