<?php
require_once('abstractDAO.php');
require_once('./model/photo.php');

class photoDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getPhoto($photoId){
        $query = 'SELECT * FROM photos WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $photoId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $photo = new photo($temp['id'],$temp['name'], $temp['description'], $temp['price'], $temp['date'], $temp['img']);
            $result->free();
            return $photo;
        }
        $result->free();
        return false;
    }


    public function getPhotos(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM photos');
        $photos = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new photo object, and add it to the array.
                $photo = new Photo($row['id'], $row['name'], $row['description'], $row['price'], $row['date'], $row['img']);
                $photos[] = $photo;
            }
            $result->free();
            return $photos;
        }
        $result->free();
        return false;
    }   
    
    public function addPhoto($photo){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO photos (name, description, price, date, img) VALUES (?,?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $name = $photo->getName();
			        $description = $photo->getDescription();
			        $price = $photo->getPrice();
                    $date = $photo->getDate();
                    $img = $photo->getImg();



                  
			        $stmt->bind_param('ssiss', 
				        $name,
				        $description,
				        $price,
                        $date,
                        $img

			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $photo->getName() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   
    public function updatePhoto($photo){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE photos SET name=?, description=?, price=?, date=?, img=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $photo->getId();
                    $name = $photo->getName();
			        $description = $photo->getDescription();
			        $price = $photo->getPrice();
                    $date = $photo->getDate();
                    $img = $photo->getImg();



                  
			        $stmt->bind_param('ssissi', 
				        $name,
				        $description,
				        $price,
                        $date,
                        $img,
                        $id
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $photo->getName() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deletePhoto($photoId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM photos WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $photoId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>