<?php
require './api/config.php';

if(!$_SESSION['accepted']){
    header("Location: verification.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $body = json_decode(file_get_contents("php://input"), TRUE);
    $pwd = mysqli_escape_string($con, $body['pwd']);

    if(mysqli_query($con, "UPDATE accounts SET password='".$pwd."'")){
        $_SESSION['accepted'] = FALSE;
        die("OK");
    }else{
        die("Something went wrong");
    }
}




if($_SERVER['REQUEST_METHOD'] == 'GET'){

    ?>
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
    <link href="login.css" rel="stylesheet">
    <script src="/jquery.min.js"></script>
</head>
<body>
    <div class ="form-container1">
        
    <form class="" id="id">
    <h1>Reset Password</h1>
        <input type="password" name="pwd" placeholder="Enter your new Password">
        <input type="ConfirmPassword" name="npwd" placeholder="Confirm Password">
       
        
        <input type="submit" name="submit" value="Reset password" id="submit" class="form-btn"><br><br>

    </form>
 
    </div>

    </div>
    <script>
    $(function(e) {
        const pwd = $("input[name=pwd]")
        const npwd = $("input[name=npwd]")

        $("input#submit").click(function(e) {
            if(pwd.val() != npwd.val()) return alert("Password not matched")
            if(!pwd.val() || !npwd.val()) return alert("Complete all input")
            
            $.ajax({
                type: "POST",
                url: "/forgot_password.php",
                headers: {
                    "Content-Type": "application/json"
                },
                data: JSON.stringify({
                    pwd: pwd.val()
                }),
                success: (res) => {
                    if(res == "OK"){
                        location.replace("/login.php")
                    }else {
                        alert(res)
                    }
                }
            })
        })

        $("#id").submit(function(e) {
            e.preventDefault()
            
        })
    })</script>
</body>
</html>
    
    <?php
}

?>
