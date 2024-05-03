

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Verification_form</title>
	<script src="/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="register.css">
</head>
<body>

           
	  <div class="form-container"> 
	  <form id="form">
    <h1>SECURITY QUESTIONS</h1>

        
        <input type="text" id="q1" value="What is your favorite color?" disabled> 
        <input type="text" id="a1" >
        <input type="text" id="q2" value="Where is your homeland?" disabled> 
        <input type="text" id="a2" >  

    
        
        <input type="submit" name="submit" id="submit" value="SUBMIT" class="form-btn"><br><br>
        
     
		</form>
</body>

<script>
    $(function(e) {
        const a1 = $("#a1")
        const a2 = $("#a2")

        $("form#form").submit(function(e) {
            e.preventDefault()
        })

        $("input#submit").click(function() {
            if(!a1.val() || !a2.val()) return alert("Complete all fields")

            $.ajax({
                type: "POST",
                url: "/api/checkquestion.php",
                headers: {
                    "Content-Type": "application/json"
                },
                data: JSON.stringify({
                    a1: a1.val(),
                    a2: a2.val()
                }),
                success: (res) => {
                    if(res == "OK"){
                        location.replace("/forgot_password.php")
                    }else{
                        alert(res)
                    }
                }
            })
        })
    })
</script>
	

</html>

<?php

// }else {
//    header("Location: admin_view.php");
// }
//  ?>