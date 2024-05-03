<?php
    require_once './api/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vienna Hotel.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="/jquery.min.js"></script>
</head>
<body>
    <header class="header">

        <a href="#rooms" class="logo"> Vienna <span>Hotel.</span> </a>
    
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#rooms">Rooms</a>
            <a href="#about">About Us</a>
            <a href="#footer">Contact</a>
        </nav>
    
        <div class="icons">
            <?php
                if(isset($_SESSION["user"])){
                    if($_SESSION["user"] != "admin"){
                        echo '<a href="/api/logout.php" class="fa-solid fa-user"> Logout </a>';
                    }else{
                        echo '<a href="/login.php" class="fa-solid fa-user"> Login </a>';
                    }
                }else{
                    echo '<a href="/login.php" class="fa-solid fa-user"> Login </a>';
                }
            ?>
        </div> 
        <div class="icons">
            <?php
                if(isset($_SESSION["user"])){
                    if($_SESSION["user"] != "admin"){
                        echo '';
                    }else{
                        echo '<a href="/register.php" class="fa-solid fa-list-check"> Register </a>';
                    }
                }else{
                    echo '<a href="/register.php" class="fa-solid fa-list-check"> Register </a>';
                }
            ?>
        </div> 
    </header>
    

<section class="home" id="home"> 
    <div class="home-text">
    
        <h1 style="color:rgb(255, 255, 255);"><span>Stay once, </span>carry <br> memories <span>forever.</span></h1>
        <button href="#rooms" class="homeBtn" style="--i:#159e2e;">Book A Room</button>
    </div>
 
</section>

<section class="rooms" id="rooms">

    <h1>Our Rooms</h1>
    
    <div class="box-container">

        <div class="box img">
            <img src="images/Bed1.png" alt="">
            <h3>SINGLE BEDROOM</h3>
            <div class="price">₱1,500 <span>₱2,999</span></div>
            <span>Our Single Bedroom are for travelers who are looking for an affordable but stylish room to unwind.</span>
            <a href="/Single_Bed.php?room=Single" class="btn">View Detail</a>
        </div>

        <div class="box img">
            <img src="images/Bed2.png" alt="">
            <h3>STANDARD QUEEN</h3>
            <div class="price">₱2,000 <span>3,999</span></div>
            <p class="a">Our Standard Double Rooms come with a Queen size bed and a sofa bed.</p>
            <a href="Standard_bed.php?room=Standard" class="btn">View Detail</a>
        </div>

        <div class="box img">
            <img src="images/Bed3.png" alt="">
            <h3>DELUXE KING</h3>
            <div class="price">₱5,000 <span>₱6,999</span></div>
            <p class="a">These fairly spacious 15 square meter with window rooms are tastefully designed in a warm and classic style to maximize the wellbeing of our guests and create an ambience of calm and serenity.</p>
            <a href="Deluxe_king.php" class="btn">View Detail</a>
        </div>
    </div>
</section>

<section class="about" id="about">

    <h1>about Us</h1>
    
    <div class="box-container">

        <div class="image">
            <img src="images/about1.jpg" alt="">
        </div>
    
        <div class="content">
            <h3>Viena Hotel</h3>
            
            <span>IETI San Pedro also build Vienna Hotel for HRM Students and HRM Instructors <br> for their research purposes to help them for their assessments and excel their  <br> knowledge reasoning in Hotels. Vienna Hotel is located at the 4th floor
            <br> of Basic Education Department of IETI College of Science and Technology. <br> </span>
            
        </div>
    </div>
</section>

<section class="footer" id="footer">

    <div class="credit"><h1>
        <span>Vienna Hotel<br>

        </span>
    </h1>Contact Us<br><h3>093121432</h3>
</div>
</section>
   
<script>
    $(function(e) {
        // alert("JQUERY IS WORKING")
    })
</script>
</body>
</html>