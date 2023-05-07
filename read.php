<?php
// Include photoDAO file
require_once('./dao/photoDAO.php');
$photoDAO = new photoDAO(); 					

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id =  trim($_GET["id"]);
    $photo = $photoDAO->getPhoto($id);
            
    if($photo){
        // Retrieve individual field value
        $name = $photo->getName();
        $description = $photo->getDescription();
        $price = $photo->getPrice();
        $date = $photo->getDate();
        $img =$photo->getImg();
    } else{
        // URL doesn't contain valid id. Redirect to error page
        header("location: error.php");
        exit();
    }
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
} 

// Close connection
$photoDAO->getMysqli()->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 800px;
            margin: 0 auto;
        }
        .image-size{
            width:800px;
        }

    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $name; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <p><b><?php echo $description; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <p><b>$<?php echo $price; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Issue Date</label>
                        <p><b><?php echo $date; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <p><b><?php 
                        $html_template = '<div><img class="image-size" src="img/<IMAGE_PATH>"></div>';
                        echo str_replace("<IMAGE_PATH>", $img, $html_template);?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>