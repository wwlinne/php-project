<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('./dao/photoDAO.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js" defer></script>

    <style>
        .wrapper{
            width: 1000px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
        table tr td:nth-child(2){
            width: 100px;
        }
        table tr td:nth-child(5){
            width: 150px;
        }
        img{
            width:120px;
        }
    
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="photo">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">YOU ONLY LIVE ONCE</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New photo</a>
                    </div>
                    <?php
                        $photoDAO = new photoDAO();
                        $photos = $photoDAO->getPhotos();
                        $html_template = '<div><img src="img/<IMAGE_PATH>"></div>';

                        if($photos){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Price</th>";
                                        echo "<th>Issue Date</th>";
                                        echo "<th>Photo</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach($photos as $photo){
                                    echo "<tr>";
                                        echo "<td>" . $photo->getId(). "</td>";
                                        echo "<td>" . $photo->getName() . "</td>";
                                        echo "<td>" . $photo->getDescription() . "</td>";
                                        echo "<td>$" . $photo->getPrice() . "</td>";
                                        echo "<td>" . $photo->getDate() . "</td>";
                                        echo "<td>" . str_replace("<IMAGE_PATH>", $photo->getImg(),$html_template) . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $photo->getId() .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $photo->getId() .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $photo->getId() .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            //$result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                   
                    // Close connection
                    $photoDAO->getMysqli()->close();
                    include 'footer.php';
                    ?>
                </div>
            </div>        
        </div>
    </div>

</body>
</html>