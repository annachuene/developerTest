<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $marks = $email = $birthdate =  $streetaddress = "";
$name_err = $address_err = $marks_err = $email_err = $birthdate_err = $streetaddress_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate marks
    $input_marks = trim($_POST["marks"]);
    if(empty($input_marks)){
        $marks_err = "Please enter your contact number.";     
        } else{
        $marks = $input_marks;
    }
	 $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email.";     
    } else{
        $email = $input_email;
    }
	
	 $input_birthdate = trim($_POST["birthdate"]);
    if(empty($input_birthdate)){
        $birthdate = "Please enter date of birth.";     
    } else{
        $birthdate = $input_birthdate;
    }
	 $input_streetaddress = trim($_POST["streetaddress"]);
    if(empty($input_streetaddress)){
        $streetaddress = "Please enter street address.";     
    } else{
        $streetaddress = $input_streetaddress;
    }
    
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($marks_err) && empty($email_err) && empty($birthdate_err) && empty($streetaddress_err)){
        // Prepare an update statement
        $sql = "UPDATE employee_record SET name=?, address=?, marks=? , email=? , birthdate=?, streetaddress=? WHERE id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_name, $param_address, $param_marks,$param_email,$param_birthdate,$param_streetaddress,$param_id);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_marks = $marks;
			$param_email = $email;
			$param_birthdate = $birthdate;
            $param_streetaddress=$streetaddress;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    $my_option = $_GET["id"];
	if(!empty($my_option)){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM employee_record WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $address = $row["address"];
                    $marks = $row["marks"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($marks_err)) ? 'has-error' : ''; ?>">
                            <label>Contact Number</label>
                            <input type="text" name="marks" class="form-control" value="<?php echo $marks; ?>">
                            <span class="help-block"><?php echo $marks_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email Address</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($birthdate_err)) ? 'has-error' : ''; ?>">
                            <label>Date of Birth</label>
                            <input type="text" name="birthdate" class="form-control" value="<?php echo $birthdate; ?>">
                            <span class="help-block"><?php echo $birthdate_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($streetaddress_err)) ? 'has-error' : ''; ?>">
                            <label>Street Address</label>
                            <input type="text" name="streetaddress" class="form-control" value="<?php echo $streetaddress; ?>">
                            <span class="help-block"><?php echo $streetaddress_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>