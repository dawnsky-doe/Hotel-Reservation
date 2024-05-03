
<?php
require 'Config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = file_get_contents("php://input");
    $decoded = json_decode($data, TRUE);

        $Email=  mysqli_real_escape_string($conn,$decoded['email']);
        $Password =  mysqli_real_escape_string($conn,$decoded['pwd']);
        $result = mysqli_query($conn, "SELECT * FROM register WHERE Email = '$Email'");
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result)>0){

            if($Password == $row["Password"]){                              
                        die("index.php");
                    
                }
            else{
                die("Wrong Password");
                }
        }else{
            die("User Not Registered");
        }
    }

?>