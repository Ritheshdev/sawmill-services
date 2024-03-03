
<html>


<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style>
       @media only screen and (max-width: 760px),
        (min-device-width: 802px) and (max-device-width: 1020px) {

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: block;

            }
            
            

            .empty {
                display: none;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }



            /*
		Label the data
		*/
            td:nth-of-type(1):before {
                content: "Sunday";
            }
            td:nth-of-type(2):before {
                content: "Monday";
            }
            td:nth-of-type(3):before {
                content: "Tuesday";
            }
            td:nth-of-type(4):before {
                content: "Wednesday";
            }
            td:nth-of-type(5):before {
                content: "Thursday";
            }
            td:nth-of-type(6):before {
                content: "Friday";
            }
            td:nth-of-type(7):before {
                content: "Saturday";
            }


        }

        /* Smartphones (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
        }

        /* iPads (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
            body {
                width: 495px;
            }
        }

        @media (min-width:641px) {
            table {
                table-layout: fixed;
            }
            td {
                width: 33%;
            }
        }
        
        .row{
            margin-top: 20px;
        }
        
        .today{
            background:yellow;
        }
        .navbar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        background-color: #f2f2f2;
        padding: 10px;
    }

    .navbar-items {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .navbar-items li {
        display: inline-block;
        margin-right: 10px;
    }

    .navbar-items li a {
        text-decoration: none;
        color: #000;
        padding: 5px;
    }
        
        
        
    </style>
</head>

<body>
<nav class="navbar">
    <ul class="navbar-items">
        <li><a href="admin_page.php">Home</a></li>
        
      </ul>
</nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
             <div id="calendar"></div>  
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script>
$.ajax({
 url: "admincalendar.php",
 type:"POST",
 data: {'month': '<?php echo date('m'); ?>', 'year':'<?php echo date('Y'); ?>'},
 success:function(data){
 $("#calendar").html(data);
}
});


$(document).on('click','.changemonth',function(){
    //var resource_id=$("#resource_select").val();
$.ajax({
    url: "admincalendar.php",
    type:"POST",
    data: {'month': $(this).data('month'), 'year':$(this).data('year')},
    success: function(data){ 
    $("#calendar").html(data);
}
});
});
/*$(document).on('change','#resource_select',function(){
    var resource_id=$(this).val();
$.ajax({
    url: "calendar.php",
    type:"POST",
    data: {'month': $('#current_month').data('month'), 'year':$('#current_month').data('year'),'resource_id':resource_id},
    success: function(data){ 
    $("#calendar").html(data);
}
});
});*/

</script>
</html>




