<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;
    public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        else
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource)
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->LoadFromId($Id))
            $this->Create();
    }
    protected function Create() {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        $this->TaskId = $this->getUniqueId();
        $this->TaskName = 'New Task';
        $this->TaskDescription = 'New Description';
    }
    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
        return -1; // Placeholder return for now
    }
    protected function LoadFromId($Id = null) {
        if ($Id) {
            // Assignment: Code to load details here...
            $query = "SELECT * FROM Task WHERE id = '".$_POST["id"]."'";
            $statement = $connect->prepare($query);
            $statement->execute();
            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
             $data[] = $row;
            }
           echo json_encode($data);
}
        } else
            return null;
    }

    public function Save() {
        //Assignment: Code to save task here
        include('database_connection.php');

        if(isset($_POST["name"]))
         {
          $error = '';
          $success = '';
          $task1 = '';
          $task2 = '';
          if(empty($_POST["task1"]))
          {
          $error .= '<p>task1 is Required</p>';
           }
           else
          {
           $name = $_POST["task2"];
          }
           if(empty($_POST["task3"]))
          {
              $error .= '<p>task3 is Required</p>';
          }
             else
          {
         $task1 = $_POST["task1"];
          }
        if(empty($_POST["task1"]))
        {
         $error .= '<p>task1 is Required</p>';
         }
         else
         {
           $task2 = $_POST["task2"];
          }
           if(empty($_POST["age"]))
          {
          $error .= '<p>Task2 is Required</p>';
           }
          else
        {
         $task2 = $_POST["Task2"];
       }
       else
  {
   $images = rand() . '.' . $extension;
  
   }
   }
       if($error == '')
       {
        $data = array(
         ':task1'   => $task1,
         ':task2'  => $task2,
         );
        $query = "
        INSERT INTO Task 
        (task1, task2) 
         VALUES (:task1, :task2)
        ";
        $statement = $connect->prepare($query);
        $statement->execute($data);
        $success = 'Task Data Inserted';
         }
         $output = array(
        'success'  => $success,
        'error'   => $error
       );
       echo json_encode($output);
         }
          }
          public function Delete() {
              //Assignment: Code to delete task here
              include('database_connection.php');
      
              if(isset($_POST["id"]))
                {
                   $query = "
                  DELETE FROM Task 
                  WHERE id = '".$_POST["id"]."'
                                           ";
                  $statement = $connect->prepare($query);
                  $statement->execute();
}

    }
}
?>