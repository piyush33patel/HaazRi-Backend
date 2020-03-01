<?php
require_once dirname(__FILE__).'/Constants.php';
$con  =  mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$response = array();
if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_POST['email']))
            {
                $email = $_POST['email'];
                $sql = "SELECT title FROM courses,student WHERE courses.semester = student.semester AND email = '{$email}'";
                
                $result = mysqli_query($con, $sql);
                while($row = mysqli_fetch_array($result))
                {
                    $title = $row["title"];
                    $sql2 = "SELECT code FROM courses where title = '{$title}'";
                    $result2 = mysqli_query($con, $sql2);
                    $code = "";
                    while($row1 = mysqli_fetch_array($result2))
                    {
                        $code = $row1["code"];
                    }    
        
                    //Total Count
                    $resTotal = mysqli_query($con, "SELECT COUNT(DISTINCT date) as 'count' from attendance WHERE email = '{$email}' and code = '{$code}';");
                    $row = mysqli_fetch_array($resTotal);
                    $total = $row['count'];
                    //Total Present
                    $resPresent = mysqli_query($con, "SELECT COUNT(DISTINCT date) as 'count' from attendance WHERE email = '{$email}' and code = '{$code}' and value='P';");
                    $row = mysqli_fetch_array($resPresent);
                    $present = $row['count'];
                    //Total Absent
                    $resAbsent = mysqli_query($con, "SELECT COUNT(DISTINCT date) as 'count' from attendance WHERE email = '{$email}' and code = '{$code}'  and value='A';");
                    $row = mysqli_fetch_array($resAbsent);
                    $absent = $row['count'];
                    
                    //Create Json
                    array_push($response, array("title"=>$title,"total"=>$total,"present"=>$present,"absent"=>$absent));
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
