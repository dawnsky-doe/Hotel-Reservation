<?php
   require './api/config.php';

   if(empty($_SESSION["user"])){
       header("Location: login.php");
   }else{
      if($_SESSION["user"] == "admin"){
          header("Location: admin_view.php");
      }
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vienna Hotel.com</title>
    <link rel="stylesheet" href="/Booking_form.css">
    <script src="/jquery.min.js"></script>
    <script src="/moment.min.js"></script>
    <script src="swal2.min.js"></script>
    <!-- <link rel="stylesheet" href="/public/flatpickr.min.css"/>
    <script type="text/javascript" src="/public/flatpickr.min.js"></script> -->
    <script type="text/javascript" src="/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/daterangepicker.css" />
</head>
<body>
    <form id="form" novalidate>
        <div class="elem-group">
          <label for="name">Fullname:</label>
          <input type="text" id="name" name="visitor_name" placeholder="IETI_Vienna" pattern=[A-Z\sa-z]{3,20}>
        </div>
        <div class="elem-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="visitor_email" placeholder="IloveIETI@email.com">
        </div>
        <div class="elem-group">
          <label for="phone">Phone Number</label>
          <input type="text" maxlength="11" id="phone" name="visitor_phone" placeholder="0922*******" pattern=(\d{3})-?\s?(\d{3})-?\s?(\d{4})>
        </div>
        <hr>
        <!-- <div class="elem-group inlined">
          <label for="adult">Adults</label>
          <input type="number" id="adult" name="total_adults" placeholder="2" min="1">
        </div>
        <div class="elem-group inlined">
          <label for="child">Children</label>
          <input type="number" id="child" name="total_children" placeholder="2" min="0">
        </div> -->
        <div class="elem-group inlined">
          <label for="schedule">Schedule Date</label>
          <input id="schedule">
        </div>
        <!-- <div class="elem-group inlined">
          <label for="checkout-date">Check-out Date</label>
          <input type="date" id="checkout" name="checkout">
        </div> -->
        <!-- <div class="elem-group">
          <label for="room-selection">Select Room Preference</label>
          <select id="room-selection" name="room_preference">
              <option selected disabled>Choose a Room from the List</option>
              <option value="Single">SINGLE BEDROOM</option>
              <option value="Standard">STANDARD QUEEN</option>
              <option value="Deluxe">DELUXE KING</option>
          </select>
        </div> -->
        <hr>
        <!-- <div class="elem-group">
          <label for="message">Anything Else?</label>
          <textarea id="message" name="visitor_message" placeholder="Tell us anything else that might be important."></textarea>
        </div> -->
        <button type="submit" id="submit">Book The Rooms</button>
      </form>

      <script>
        $(function(e) {
          const urlParams = new URLSearchParams(window.location.search);
          const bed = urlParams.get('bed')
          const name = $("#name"),
          email = $("#email"),
          phone = $("#phone"),
          schedule = $("#schedule")
          // roomSelection = $("#room-selection")

          function clearInput() {
            name.val("")
            email.val("")
            phone.val("")
          }

          $.ajax({
            type: "GET",
            url: `/api/getschedules.php?bed=${bed}`,
            success: (res) => {
              const data = JSON.parse(res)

              const parsedData = data.map((date) => ({
                check_in: moment(date.check_in).format("YYYY-MM-DD"),
                check_out: moment(date.check_out).format("YYYY-MM-DD")
              }))

              $('input#schedule').daterangepicker({
                minDate: moment(),
                isInvalidDate: function(date) {
                  for (var i = 0; i < parsedData.length; i++) {
                    return (date.isSameOrAfter(parsedData[i].check_in) && date.isSameOrBefore(parsedData[i].check_out))
                  }
                },
              });

            },
            error: (err) => {
              alert("Something went wrong")
              console.log(err)
            }
          })
          
          

          $("#phone").keydown(function(e) {
            if((e.keyCode >= 48 && e.keyCode <= 57) || e.keyCode == 8){
              return null
            }else{
              e.preventDefault()
            }
          })


          $("#form").submit(function(e) {
            e.preventDefault()
          })

          $("#submit").click(function(e) {
            const dates = schedule.val().replaceAll(" ","").split("-")

            if(!email.val() || !phone.val() || dates.length <= 1){
              return Swal.fire({
              icon: 'warning',
              title: 'Please complete all input'
            })
            }

            $.ajax({
              type: "POST",
              url: '/api/add_reservation.php',
              headers: {
                'Content-Type': 'application/json'
              },
              data: JSON.stringify({
                name: name.val(),
                email: email.val(),
                phone: phone.val(),
                checkin: moment(dates[0]).format(),
                checkout: moment(dates[1]).format(),
                roomSelection: bed
              }),
              success: (res) => {
                const parsed = JSON.parse(res)

                if(parsed.operation){
                  clearInput()

                  return Swal.fire({
                    icon: 'success',
                    confirmButtonText: "OK",
                    title: 'Reservation successful'
                  }).then((result) => {
                    if(result.isConfirmed){
                      location.replace("/")
                    }
                  })
                }

                Swal.fire({
                  icon: 'error',
                  title: 'Reservation failed'
                })
              },
              error: (error) => {
                alert("Something went wrong")
                console.log(error)
              }
            })
          })
        })
      </script>
</body>
</html>