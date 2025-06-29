<?php
include("../config/conn.php");
header('Content-Type: application/json');

// Started Action
if(isset($_POST['action'])){
    $action = $_POST['action'];
    if(function_exists($action)){
        $action($conn);
    } else {
        echo json_encode(["status" => "error", "message" => "Action Is Required"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Action And Action Is Required"]);
}

// Students Read Dashboad Start Here
function AllStudents($conn){
    $Read_query=mysqli_query($conn,"SELECT * FROM students");
    if($Read_query && mysqli_num_rows($Read_query)>0){
        echo json_encode(["status"=>"success","message"=>mysqli_num_rows($Read_query)]);
    }else{
         echo json_encode(["status"=>"error","message"=>"No Student found"]); 
    }
}
function Allteachers($conn){
    $select=mysqli_query($conn,"SELECT * FROM teachers");
    if($select && mysqli_num_rows($select)>0){
        echo json_encode(["status"=>"success","message"=>mysqli_num_rows($select)]);
    }else{
         echo json_encode(["status"=>"error","message"=>"No Teachers found"]); 
    }
}
// Students Read Dashboad End Here
?>