<?php
require './api/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$body = json_decode(file_get_contents("php://input"), TRUE);
	$email = mysqli_escape_string($con, $body["email"]);
	$pwd = mysqli_escape_string($con, $body["confirmPwd"]);
	$id_number = mysqli_escape_string($con, $body["id_number"]);
	$course_year = mysqli_escape_string($con, $body["course_year"]);
	$name = mysqli_escape_string($con, $body["name"]);
	
	$checkEmailAdmin = mysqli_num_rows(mysqli_query($con, "SELECT * FROM accounts WHERE username='".$email."'"));
	$checkEmailUser = mysqli_num_rows(mysqli_query($con, "SELECT * FROM user_accounts WHERE email='".$email."'"));

	if($checkEmailAdmin >= 1 || $checkEmailUser >= 1){
		die("Email already exist");
	}

	if(mysqli_query($con, "INSERT INTO user_accounts VALUES('".$id_number."','".$email."','".$pwd."','".$course_year."','".$name."')")){
		die("Account registered");
	}else{
		die("Some Ting Wong");
	}
}

    
    
if($_SERVER["REQUEST_METHOD"] == "GET"){
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login_form</title>
	<script src="/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="register.css">
</head>
<body>

           
	  <div class="form-container"> 
	  <form id="form">
    <h1>Register Now</h1>

        
        <input type="text" id="name" name="Name" required placeholder="Enter your Name"> 
        <input type="text" id="course_year" name="Course_Yrlevel" required placeholder="Enter your Course and Year Level">
        <input type="text" id="id_number" name="ID_Number" required placeholder="Enter your ID Number"> 
        <input type="text" id="email" name="Email" required placeholder="Enter your Email"> 
        <input type="password" id="pwd" name="Password" required placeholder="Enter your Password"> 
        <input type="password" id="confirmPwd" name="ConfirmPassword" required placeholder="Confirm Password"> 

    
        
        <input type="submit" name="submit" value="Signup" class="form-btn"><br><br>
		
		<div class="links">
            already have account? <a href="login.php">Sign in</a>
        </div>
        
     
		</form>
</body>
	<script>
		$(function(e) {
			const confirmPwd = $("#confirmPwd")
			const pwd = $("#pwd")
			const email = $("#email")
			const id_number = $("#id_number")
			const course_year = $("#course_year")
			const name = $("#name")

			$("form#form").submit(function(e) {
				e.preventDefault()
			})

			$("form#form input[type=submit]").click(function(e) {
				if(confirmPwd.val() != pwd.val()) return alert("Password not matched")
				if(!name.val() || !course_year.val() || !email.val() || !id_number.val() || !pwd.val() || !confirmPwd.val()) return alert("All inputs should be populated")

				$.ajax({
					type: "POST",
					url: "/register.php",
					headers: {
						"Content-Type": "application/json"
					},
					data: JSON.stringify({
						id_number: id_number.val(),
						email: email.val(),
						name: name.val(),
						confirmPwd: confirmPwd.val(),
						course_year: course_year.val(),
					}),
					success: (res) => {
						if(res.includes("Account registered")){
							alert(res)
							return location.replace("/index.php")
						}
						alert(res)
					},
					error: (error) => {
						console.log(error)
					}
				})
			})
		})
	</script>

</html>

<?php

	}
// }else {
//    header("Location: admin_view.php");
// }
//  ?>