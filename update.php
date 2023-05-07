<?php
// Include photoDAO file
require_once('./dao/photoDAO.php');
 
// Define variables and initialize with empty values
$name = $description = $price = $date = $img = "";
$name_err = $description_err = $price_err = $date_err = $img_err = "";
$photoDAO = new photoDAO(); 
$max_range = 100;


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
    } elseif(strlen($input_name) >= 15){
        $name_err = "Please enter no more than 15 characters.";
    } else{
        $name = $input_name;
    }
    
    // Validate description description
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter an description."; 
    } else{
        $description = $input_description;
    }
    
    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price amount.";
    } elseif(!ctype_digit($input_price)){
        $price_err = "Please enter a positive integer value.";
    } elseif($input_price > $max_range){
        $price_err = "Please enter a value lower than 100.";
    } else{
        $price = $input_price;
    }

    // Validate date
    $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = "Please enter the issue date.";     
    } elseif (strtotime($input_date) >= strtotime('2023-04-05')) {
        $date_err = "Please enter a date before 2023-04-05.";
    } else{
        $date = $input_date;
    }
   //validate imgs
   if (isset($_FILES['image'])) {
    $img_err = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];

    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    $extensions= array("jpeg","jpg","png");

    if(empty($file_name)){
        $img_err = "Please upload an image file.";
    }elseif (!in_array($file_ext,$extensions)) {
        $img_err = "Extension not allowed, please choose a JPEG or PNG file.";
   }elseif ($file_size > 5242880) {
      $img_err = "Failed to upload: File size must be exactly 5 MB.";
   }else {
       // File passed all validation checks, so proceed with upload
       move_uploaded_file($file_tmp, "img/" . $file_name);
      // $img = $file_name;
   }
}
  

    // Check input errors before inserting in database
    if(empty($name_err) && empty($description_err) && empty($price_err) && empty($date_err)&& empty($img_err)){
        $img = $file_name;
        $photo = new Photo($id, $name, $description, $price, $date, $img);
        $result = $photoDAO->updatePhoto($photo);        
		header("refresh:2; url=index.php");
		echo '<br><h6 style="text-align:center">' . $result . '</h6>';
        // Close connection
        $photoDAO->getMysqli()->close();
    }

} else{
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
            $img = $photo->getImg();


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
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 1000px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the photo record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Issue Date</label>
                            <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Photo Upload</label>
                            <input type="file"  name="image" class="form-control <?php echo (!empty($img_err)) ? 'is-invalid' : ''; ?>" >
                            <span class="invalid-feedback"><?php echo $img_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>