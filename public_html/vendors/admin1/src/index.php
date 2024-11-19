<?php
include('header.php');
?>
    <!-- partial -->
    <div class="main-wrapper mdc-drawer-app-content">
      <!-- partial:partials/_navbar.html -->
      <header class="mdc-top-app-bar">
        <div class="mdc-top-app-bar__row">
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu</button>
            <span class="mdc-top-app-bar__title">Home</span>
           
          </div>
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
            
          <style>
		  
/* Float four columns side by side */
.column1 {
  float: left;
  width: 22%;
  padding: 0 10px;
}
.column1c {
  width: 100%;
  border:0px solid #000;
  padding: 0 10px;
}
.column1a {
  float: left;
  width: 70%;
  padding: 0 10px;
}

.column1b {
  float: left;
  width: 25%;
  padding: 0 10px;
}
/* Remove extra left and right margins, due to padding */
.row1 {margin: 0 -5px;}

/* Clear floats after the columns */
.row1:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column1 {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
  .column1a {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
  .column1b {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card1 {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #FFF;
}



/* Style the counter cards */
.card1 {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #FFF;
}


/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Hide the images by default */
.mySlides {
  display: none;
}


/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 95%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}
		  </style>
			
            
          </div>
        </div>
      </header>
      <!-- partial -->
      <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
           
            
           
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                  <div class="d-flex justify-content-between">
                    
                    <div>
                        
                    </div>
                  </div>
<?php
$result = mysql_query("SELECT * FROM appointment  ORDER BY id ASC");
$count=mysql_num_rows($result);
$result1 = mysql_query("SELECT * FROM appointment WHERE status = 'Approved' ORDER BY id ASC");
$count1=mysql_num_rows($result1);
$result2 = mysql_query("SELECT * FROM appointment WHERE  status = 'Pending' ORDER BY id ASC");
$count2=mysql_num_rows($result2);
$result3 = mysql_query("SELECT * FROM appointment WHERE  status = 'Cancelled' ORDER BY id ASC");
$count3=mysql_num_rows($result3);

?>
<h2>Dashboard</h2>
<br>
<!-- start -->

  <div class="column1c" >
  <div class="column1" >
    <div class="card1" style="text-align:left;height:100px;max-height:100px;">
      <h4 style="font-weight:normal;">Total Appointment<span style="float:right;"><i class="fa-solid fa-calendar-check"></i></span></h3>
		<h1 style="font-size:50px"><?php echo $count ?></h1>
		</div>
	  <!-- end chat -->
    </div>
  <div class="column1" >
    <div class="card1" style="text-align:left;height:100px;max-height:100px;">
      <h4 style="font-weight:normal;">Total Approved<span style="float:right;"><i class="fa-solid fa-person-circle-check"></i></span></h3>
	<h1 style="font-size:50px"><?php echo $count1 ?></h1>
	 </div>
	</div>
	
  <div class="column1" >
    <div class="card1" style="text-align:left;height:100px;max-height:100px;">
      <h4 style="font-weight:normal;">Total Pending<span style="float:right;"><i class="fa-solid fa-chalkboard-user"></i></h3>
	<h1 style="font-size:50px"><?php echo $count2 ?></h1>
	 </div>
	</div>
  <div class="column1" >
    <div class="card1" style="text-align:left;height:100px;max-height:100px;">
      <h4 style="font-weight:normal;">Total Cancelled<span style="float:right;"><i class="fa-duotone fa-rectangle-xmark"></i></h3>
	<h1 style="font-size:50px"><?php echo $count3 ?></h1>
	 </div>
	</div>
  </div>
  <!-- end -->
  	<br clear="all	">  
<div class="row1" style="border:0px solid #000">
               
  <div class="column1a"   >
    <div class="card1" style="text-align:left;;height:600px;overflow-y:scroll">
    <h4 style="font-weight:bold">Announcement</h3>
     <?php
	 
$result2 = mysql_query("SELECT * FROM tools  ORDER BY date DESC LIMIT 10");
while($row2 = mysql_fetch_array($result2))
	{
		$date  = date('F d, Y',strtotime($row2['date']));
		echo '<h5 style="margin:0px">'.$row2['title'].'</h3>';
		echo '<i style="font-size:12px">'.$date.'</i>';
		echo '<p>'.$row2['description'].'</p>';
		echo '<hr>';
		
	}
	 
	 ?>
	
		</div>
	  <!-- end chat -->
    </div>
	
	
  <div class="column1b" >
    <div class="card1" style="text-align:left;">
      <h4 style="font-weight:normal;">Appointment Today<span style="float:right;"><i class="fa-solid fa-calendar-days"></i></span></h3>
	  <br>
    <?php
	 $date = date('Y-m-d');
	 //echo $date;
				include('../../connect.php');
				$result = mysql_query("SELECT * FROM appointment WHERE date = '$date' AND status = 'Approved'ORDER BY id ASC");
				while($row = mysql_fetch_array($result))
				{           
			$type = $row['type'];
			$user = $row['user'];
			$student = $row['student'];
				$resulta = mysql_query("SELECT * FROM login WHERE username = '$user' ORDER BY id ASC");
				while($rowa = mysql_fetch_array($resulta))
				{
					$name =$rowa['name'];
				}
				$resultb = mysql_query("SELECT * FROM login WHERE username = '$student' ORDER BY id ASC");
				while($rowb = mysql_fetch_array($resultb))
				{
					$student =$rowb['fname'].' '.$rowb['lname'];
				}
					
	echo '<div style="border:1px solid #d3d3d3;padding:10px;margin-bottom:10px">';
					$time = $row['time'];
					$t = date('h:i A',strtotime($time));
					$d = date('F d, Y');
					echo $t,' '.$student.' with '.$name;
					
	echo '</div>';
				}
	 ?>
	 
		</div>
		 <div class="card1" style="text-align:left;">
      <h4 style="font-weight:normal;">Incoming Events<span style="float:right;"><i class="fa-solid fa-calendar-circle-user"></i></span></h3>
	  <br>
    <br>
	  
                
 <!-- start calendar -->
 <?php 
	$currentData = date('Y-m-d');
	?>

	<!-- Calendar Container -->
	<div id='calendar-container'>
    	<div id='calendar'></div>
  	</div>

  	<!-- jQuery -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

  	<!-- Fullcalendar  -->
	<script type="text/javascript" src="fullcalendar/dist/index.global.min.js"></script>

	<!-- Sweetalert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
	    var calendarEl = document.getElementById('calendar');

	    var calendar = new FullCalendar.Calendar(calendarEl, {
	      	initialDate: '<?= $currentData ?>',
	      	height: '600px',
	      	selectable: true,
	      	editable: true,
	      	dayMaxEvents: true, // allow "more" link when too many events
	      	events: 'fetchevents.php', // Fetch all events
	
	      	eventDrop: function (event, delta) { // Move event

	      		// Event details
	      		var eventid = event.event.extendedProps.eventid;
	      		var newStart_date = event.event.startStr;
	      		var newEnd_date = event.event.endStr;
	           	
	           	// AJAX request
	           	$.ajax({
					url: 'ajaxfile.php',
					type: 'post',
					data: {request: 'moveEvent',eventid: eventid,start_date: newStart_date, end_date: newEnd_date},
					dataType: 'json',
					async: false,
					success: function(response){

						console.log(response);
									
					}
				}); 

	        },
	    
	    });

	    calendar.render();
	});

	</script>
 <!-- end calendar -->
     <!-- <?php
	 $date = date('Y-m-d');
	 //echo $date;
				include('../../connect.php');
				$result = mysql_query("SELECT * FROM tools WHERE  date > '$date' ORDER BY DATE ASC LIMIT 10");
				while($row = mysql_fetch_array($result))
				{           
			$date = $row['date'];
			$title =$row['title'];
			$date =date('F d, Y',strtotime($date));		
	echo '<div style="border:1px solid #d3d3d3;padding:10px;margin-bottom:10px">';
					
					$description = $row['description'];
					echo $date,' - '.$title;
					
	echo '</div>';
				}
	 ?> -->
		</div>
	  <!-- end chat -->
    </div>
	
	 
<script>
$(document).ready(function() {
    $('#customers').DataTable( {
        responsive: true
    } );
} );
</script>

<style>
 .dataTables_filter input {
    padding: 10px !important;

    }
.dataTables_wrapper .dataTables_filter {
   
}
</style>   
			   </div>
			   
				  <!-- start -->
				  
		
				  <!-- end -->
				  
				  <br>
                     
                </div> 
              </div>
             
           
            </div>
          </div>
        </main>
        <!-- partial:partials/_footer.html -->
        <footer>
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                <span class="text-center text-sm-left d-block d-sm-inline-block tx-14">Copyright © <a href="#" target="_blank">2022 </a>SSMS</span>
              </div>
              
            </div>
          </div>
        </footer>
        <!-- partial -->
      </div>
    </div>
  </div>
  	  <!-- plugins:js -->
	  <!-- endinject -->
	  <!-- Plugin js for this page-->
	  <script src="../assets/vendors/chartjs/Chart.min.js"></script>
	  <script src="../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
	  <script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	  <!-- End plugin js for this page-->
	  <!-- inject:js -->
	  <script src="../assets/js/material.js"></script>
	  <script src="../assets/js/misc.js"></script>
	  <!-- endinject -->
	  <!-- Custom js for this page-->
	  <script src="../assets/js/dashboard.js"></script>

</body>
</html> 