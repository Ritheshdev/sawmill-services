<?php
function build_calendar($month, $year,$resourceid) {
    
    $mysqli = new mysqli('localhost', 'root', '', 'wood');
   
     $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
     $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
     $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
     $dayOfWeek = $dateComponents['wday'];

     // Create the table tag opener and day headers
     
    $datetoday = date('Y-m-d');
    
    
    
    $calendar = "<table class='table table-bordered'>";

    $calendar .= "<center><h2>$monthName $year</h2>";
   
    $calendar.= " <a class='btn btn-xs btn-primary' href='home.php'>Home</a>";

    $calendar.= " <button class='changemonth btn btn-xs btn-primary' data-month='".date('m', mktime(0, 0, 0, $month-1, 1, $year))."' data-year='".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Previous Month</button>";
    
    $calendar.= " <button class='changemonth btn btn-xs btn-primary'id='current_month'data-month='".date('m')."'data-year='".date('Y')."'>Current Month</button> ";
    
    $calendar.= "<button class='changemonth btn btn-xs btn-primary' data-month='".date('m', mktime(0, 0, 0, $month+1, 1, $year))."'data-year='".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Next Month</button></center>";
    $calendar .= "<button class='btn btn-primary'style='float: right;'  onclick='location.href=\"view.php\"'>Activity</button>";


    
    
    $calendar.="<label>Select Resource</label><select id='resource_select'class='form-control'>";
    $stmt = $mysqli->prepare("select * from resources ");
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $selected=$resourceid==$row['id']?'selected':'';
              $calendar.= "<option $selected value='{$row['id']}'>{$row['name']}</option>";  
            }
        
        }
    }
    $calendar.="</select><br>";
        
      $calendar .= "<tr>";

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
          $calendar .= "<th  class='header'>$day</th>";
     } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

     $currentDay = 1;

     $calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

     if ($dayOfWeek > 0) { 
         for($k=0;$k<$dayOfWeek;$k++){
                $calendar .= "<td  class='empty'></td>"; 

         }
     }
    
     
     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
  
     while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

          if ($dayOfWeek == 7) {

               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";

          }
          
          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
          $date = "$year-$month-$currentDayRel";
          
            $dayname = strtolower(date('l', strtotime($date)));
            $eventNum = 0;
            $today = $date==date('Y-m-d')? "today" : "";
            if($dayname=="sunday"){
                $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Holiday</button>";
            }elseif($date<date('Y-m-d')){
             $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>N/A</button>";
         }else{
            $totalbooking=checkSlots($mysqli,$date,$resourceid);
            if($totalbooking==5){
                $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='#' class='btn btn-danger btn-xs'>All Booked</a>"; 
            }else{
                $availableslots=5-$totalbooking;
             $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='book.php?date=".$date."&resource_id=".$resourceid."' class='btn btn-success btn-xs'>Book</a><small><i>$availableslots slots available</i></small>";
         }
        }
            
            
           
            
          $calendar .="</td>";
          // Increment counters
 
          $currentDay++;
          $dayOfWeek++;

     }
     
     

     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
                $calendar .= "<td class='empty'></td>"; 

         }

     }
     
     $calendar .= "</tr>";

     $calendar .= "</table>";

     echo $calendar;

}
    

function checkSlots($mysqli,$date,$resourceid){
    $stmt = $mysqli->prepare("select * from bookings where date = ? AND resource_id=?");
    $stmt->bind_param('si', $date,$resourceid);
    $totalbooking=0;
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
            
                $totalbooking++;
            }
            
            $stmt->close();
        }
    }
    return $totalbooking;
}
$dateComponents = getdate();
if(isset($_POST['month']) && isset($_POST['year'])){
    $month = $_POST['month']; 			     
    $year = $_POST['year'];
    $resourceid=$_POST['resource_id'];
}else{
    $month = $dateComponents['mon']; 			     
    $year = $dateComponents['year'];
    $resourceid=1;
}
echo build_calendar($month,$year,$resourceid);


?>
