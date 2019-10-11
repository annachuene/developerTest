<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
 session_start();
require('task.class.php');
// Assignment: Implement this script


     if (! empty($_GET["action"])) {
    $action = $_GET["action"];
}
switch ($action) {
    
    ...
    
    case "student-add":
        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $roll_number = $_POST['roll_number'];
            $dob = "";
            if ($_POST["dob"]) {
                $dob_timestamp = strtotime($_POST["dob"]);
                $dob = date("Y-m-d", $dob_timestamp);
            }
            $class = $_POST['class'];
            
            $task = new Task();
            $insertId = $task->addtask($task1, $task2, $dob, $class);
            if (empty($insertId)) {
                $response = array(
                    "message" => "Problem in Adding New Record",
                    "type" => "error"
                );
            } else {
                header("Location: index.php");
            }
        }
        require_once "web/add.php";
        break;
    
    case "student-edit":
        $student_id = $_GET["id"];
        $student = new Student();
        
        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $roll_number = $_POST['roll_number'];
            $dob = "";
            if ($_POST["dob"]) {
                $dob_timestamp = strtotime($_POST["dob"]);
                $dob = date("Y-m-d", $dob_timestamp);
            }
            $class = $_POST['class'];
            
            $task->editTask($task1, $task2, $dob, $class, $task_id);
            
            header("Location: index.php");
        }
        
        $result = $student->getStudentById($student_id);
        require_once "web/student-edit.php";
        break;
    
    case "student-delete":
        $task_id = $_GET["id"];
        $task = new Task();
        
        $student->deleteTask($Task_id);
        
        $result = $student->getAllTask();
        require_once "web/student.php";
        break;
    
    default:
        $task = new Task();
        $result = $student->getAllTask();
        require_once "web/Task.php";
        break;
	if(isset($_POST['add'])){
		$database = new Connection();
		$db = $database->open();
		try{
			//make use of prepared statement to prevent sql injection
			$stmt = $db->prepare("INSERT INTO members (task1, task2, task3) VALUES (:task1, :task2, :task3)");
			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $stmt->execute(array(':task1' => $_POST['task1'] , ':task2' => $_POST['task2'] , ':task3' => $_POST['task3'])) ) ? 'Task added successfully' : 'Something went wrong. Cannot add task';	
 
		}
		catch(PDOException $e){
			$_SESSION['message'] = $e->getMessage();
		}
 
		//close connection
		$database->close();
	   }
 
	else{
		$_SESSION['message'] = 'Fill up add form first';
	   }
 
	   header('location: index.php');

		if(isset($_POST['edit'])){
		$database = new Connection();
		$db = $database->open();
		try{
			$id = $_GET['id'];
			$task1 = $_POST['task1'];
			$task2 = $_POST['task2'];
			$task3 = $_POST['task3'];
 
			$sql = "UPDATE task SET task1 = '$task1', task2 = '$task2', task3 = '$task3' WHERE id = '$id'";
			//if-else statement in executing our query
			$_SESSION['message'] = ( $db->exec($sql) ) ? 'Task updated successfully' : 'Something went wrong. Cannot update member';
 
		  }
		catch(PDOException $e){
			$_SESSION['message'] = $e->getMessage();
		}
 
		//close connection
		$database->close();
	   }
	else{
		$_SESSION['message'] = 'Fill up edit form first';
	  }
 
	header('location: index.php');


		if(isset($_GET['id'])){
		$database = new Connection();
		$db = $database->open();
		try{
			$sql = "DELETE FROM task WHERE id = '".$_GET['id']."'";
			//if-else statement in executing our query
			$_SESSION['message'] = ( $db->exec($sql) ) ? 'Task deleted successfully' : 'Something went wrong. Cannot delete task';
		}
		catch(PDOException $e){
			$_SESSION['message'] = $e->getMessage();
		}
 
		//close connection
		$database->close();
 
	}
	else{
		$_SESSION['message'] = 'Select task to delete first';
	}
 
	header('location: index.php');
?>