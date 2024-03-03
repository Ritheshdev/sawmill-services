<?php
$mysqli = new mysqli('localhost', 'root', '', 'wood');
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['date'])){
    $resourceid=$_GET['resource_id'];
    $stmt = $mysqli->prepare("select * from resources where id=?");
    $stmt->bind_param('i',$resourceid);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $resourcename=$row['name'];
    }
                
    $date = $_GET['date'];
    $stmt = $mysqli->prepare("select * from bookings where date=? AND resource_id=?");
    $stmt->bind_param('si',$date,$resourceid);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['timeslot'];
            }
        }
    }
}

if(isset($_POST['submit'])){
    $stmt = $mysqli->prepare("SELECT name, email FROM `users` WHERE id = ?");
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $name=$row['name'];
        $email=$row['email'];
    }
    $timeslot=$_POST['timeslot'];
    $stmt = $mysqli->prepare("select * from bookings where date=? AND timeslot=? AND resource_id=?");
    $stmt->bind_param('ssi',$date,$timeslot,$resourceid);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            $msg = "<div class='alert alert-danger'>Already booked</div>";
                
            
            }else{
                $stmt = $mysqli->prepare("INSERT INTO bookings (id,name,timeslot, email, date,resource_id,resource_name) VALUES (?,?,?,?,?,?,?)");
                $stmt->bind_param('issssis',$user_id, $name,$timeslot, $email, $date,$resourceid,$resourcename);
                $stmt->execute();
                $msg = "<div class='alert alert-success'>Booking Successfull</div>";
                $bookings[]=$timeslot;
                $stmt->close();
                $mysqli->close();
            }

    }
}
$duration=90;
$cleanup=0;
$start="09:00";
$end="17.00";

function timeslots($duration,$cleanup,$start,$end){
    $start=new DateTime($start);
    $end=new DateTime($end);
    $interval=new DateInterval("PT".$duration."M");
    $cleanupinterval=new DateInterval("PT".$cleanup."M");
    $slots=array();

    for($intstart=$start;$intstart<$end;$intstart->add($interval)->add($cleanupinterval)){
        $endPeriod=clone $intstart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }
        $slots[]=$intstart->format("H:iA")."-".$endPeriod->format("H:iA");

    }
    return $slots;

}

?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
  </head>

  <body>
    <div class="container">
        
        <h1 class="text-center">Booking for resources"<?php echo $resourcename;?>"Date:<?php echo date('m/d/Y', strtotime($date)); ?></h1><hr>
        <div class="row">
            <div class="col-md-12">
                <?php echo isset($msg)?$msg:"";?>
            </div>
            <a href='index.php'>Home</a>

            <?php $timeslots=timeslots($duration,$cleanup,$start,$end);
            foreach($timeslots as $ts){
                ?>
                <div class="col-md-2">
                    <div class="form-group">
                        <?php if(in_array($ts,$bookings)){?>
                            <button class="btn btn-danger"><?php echo $ts;?></button>
                        <?php }else{ ?>
                    <button class="btn btn-success book" data-timeslot="<?php echo $ts;?>"><?php echo $ts;?></button>
                    <?php } ?>
                    
                    
                        

                    </div>
                   
                </div>
           <?php }?>
        </div>
    </div>
    <div id="myModal"class="modal fade"role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Booking:<span id="slot"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action=""method="post">
                                <div class="form-group">
                                    <label for="">Timeslot</label>
                                    <input required type="text"readonly name="timeslot"id="timeslot"class="form-control">

                                </div>
                            
                                <div class="form-group pull-right">
                                    
                                    <button class="btn btn-primary"type="submit"name="submit">Submit</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
        $(".book").click(function(){
            var timeslot=$(this).attr('data-timeslot');
          $("#slot").html(timeslot);
          $("#timeslot").val(timeslot);
          $("#myModal").modal("show");
        })
        </script>
  </body>

</html>
