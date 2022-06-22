<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $marks = $email = $birthdate =  $streetaddress = "";
$name_err = $address_err = $marks_err = $email_err = $birthdate_err = $streetaddress_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        // Prepare an insert statement
        $sql = "INSERT INTO employee_record (name, address, marks,email,birthdate,streetaddress) VALUES (?, ?, ?, ?, ? ,?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_address, $param_marks,$param_email,$param_birthdate,$param_streetaddress);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_marks = $marks;
			$param_email = $email;
			$param_birthdate = $birthdate;
            $param_streetaddress=$streetaddress;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
