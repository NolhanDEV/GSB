<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$libelle = $id =  "";
$name_err = $address_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_libelle = trim($_POST["libelle"]);
    if(empty($input_libelle)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_libelle, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $libelle = $input_libelle;
    }
    

    // Debug
    $id = 'gh';
    echo var_dump($id);
   // fin Debug


    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO Etat (id, libelle) VALUES (:id, :libelle)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":libelle", $param_libelle);
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_libelle = $libelle;
            $param_id = $id;
            
            // Debug
            echo var_dump($id);
            //fin Debug
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  <div class="form-group">
                            <label>id</label>
                            <input name="id" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $id; ?></input>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>libelle</label>
                            <input type="text" name="libelle" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $libelle; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>