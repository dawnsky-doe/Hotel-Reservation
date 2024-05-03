<?php
function build_calendar($month,$year){
    $mysqli = new mysqli('localhost', 'root', '', 'bookingsystem');
    $stmt = $mysqli->prepare("SELECT * FROM booking_record WHRE MONTH(DATE) = ? AND YEAR(DATE) = ?");
    $stmt->bind_param('ss', $month, $year);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['DATE'];
            }

            $stmt->close();
        }
    }

        $daysOfWeek = array('Sunaday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
        $numberDays = date('t',$firstDayOfMonth);
        $dateComponents = getdate($firstDayOfMonth);
        $monthName = $dateComponents['month'];
        $daysOfWeek = $dateComponents['wday'];
    
    $datetoday = date('Y-m-d');

    $calendar = "<table class='table table-bordered'>";
    $calendar.= "<center><h2>$monthName $year<h2>";
    $calendar.= "<a class='btn btn-xs btn-success' href='?month=".date('m', mktime(0,0,0, $month-1,1, $year))."&year=".date('Y', mktime(0,0,0, $month-1,1, $year))."'>Previous Month</a> ";
    $calendar.= "<a class='btn btn-xs btn-success' href='?month=".date('m')."&year=" .date('Y')."'>Current Month</a> ";
    $calendar.= "<a class='btn btn-xs btn-success' href='?month=".date('m', mktime(0,0,0, $month-1,1, $year))."&year=".date('Y', mktime(0,0,0, $month-1,1, $year))."'>Next Month</a></center><br>";


    $calendar .= "<tr>";
    foreach($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    $currentDay = 1;
    $calendar .= "</tr><tr>";

    if ($daysOfWeek > 0) {
        for($k=0;$k<$daysOfWeek;$k++){
            $calendar .= "<td class='empty'></td>";

        }
    }
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        if ($daysOfWeek ==7) {

            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }
        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

            $dayname = strtolower(date('1', strtotime($date)));
            $eventNum = 0;
            $today = $date==date('Y-m-d')? "today" : "";
        if($date<date('Y-m-d')){
            $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs' disabled>N/A</button>";
        }elseif(in_array($date, $bookings)){
            $calendar.="<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'> <span class='glyphicon glyphicon-lock
            '></span> Already Booked</button>";
        }else{
            $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='book.php?date=".$date."' class='btn btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Book Now</a>'";
        }
        $calendar .="</td>";
        $currentDay++;
        $dayOfWeek++;
    }
    if ($dayOfWeek != 7){

        $remainingDays = 7 - $dayOfWeek;
        for($l=0;$l<$remainingDays;$l++){
            $calendar .= "<td class='empty'></td>";

        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";
    echo $calendar;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <div class="container">
            <div class="row">
                <div class="alert alert-danger" style="backgroud:#2ecc71;border:none;color:white">
                    <h1>Online Booking System</h1>
                </div>
                <div class="col-md-12">

                </div>
            </div>
        </div>
</body>
</html>