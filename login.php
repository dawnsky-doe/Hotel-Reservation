<?php
require './api/config.php';

if(isset($_SESSION["user"])){
    if($_SESSION["user"] != "admin"){
        header("Location: index.php");
    }else{
        header("Location: admin_view.php");
    }
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $body = json_decode(file_get_contents("php://input"), TRUE);
    $username = mysqli_escape_string($con, $body["username"]);
    $pwd = mysqli_escape_string($con, $body["pwd"]);

    $resultAdmin = mysqli_num_rows(mysqli_query($con, "SELECT * FROM accounts WHERE username='".$username."' AND password='".$pwd."'"));
    $resultUser = mysqli_num_rows(mysqli_query($con, "SELECT * FROM user_accounts WHERE email='".$username."' AND password='".$pwd."'"));
    
    if($resultAdmin >= 1){
        $_SESSION["user"] = $username;
        die("admin_dashboard.php");
    }

    if($resultUser >= 1){
        $_SESSION["user"] = $username;
        die("index.php");
    }

    die("Incorrect credentials");
}




if($_SERVER['REQUEST_METHOD'] == 'GET'){

    ?>
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="login.css" rel="stylesheet">
    <script src="/jquery.min.js"></script>
</head>
<body>
    <div class ="form-container1">
        
    <form class="" id="id">
    <h1>Login</h1>
    <h3>Login with your email and password.</h3>
    <input type="text" name="Email" placeholder="Enter your Email"> 
        <input type="password" name="Password" placeholder="Enter your Password">

        <div class="Reset">
             <a href="forgot_password.php">Forgot password?</a>
        </div>
       
        
        <input type="submit" name="submit" value="Login" id="submit" class="form-btn"><br><br>
        

        <div class="links">
            Don't have account? <a href="register.php">Sign up Now</a>
        </div>
       
      

    </form>
 
    </div>

    </div>
    <script>
    $(function(e) {
        const email = $("input[name=Email]")
        const pwd = $("input[name=Password]")
        $("#id").submit(function(e) {
            e.preventDefault()
            $.ajax({
                type: "POST",
                url: "/login.php",
                headers: {
                    "Content-Type": "application/json"
                },
                data: JSON.stringify({
                    username: email.val(),
                    pwd: pwd.val()
                }),
                success: (res) => {
                    if(!res.includes("php")){
                        alert(res);
                    }else{
                        location.replace(`/${res}`)
                    }
                }
            })
        })
    })</script>
</body>
</html>
    
    <?php
}

?>
