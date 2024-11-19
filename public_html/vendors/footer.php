

<!-- The Modal -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 style="color:#000" class="text-uppercase text-dark px-2">Login</h2>
      <span class="close" onclick="cc()">&times;</span>
    </div>
    <div class="modal-body">
      <form action="login.php" method="POST" style="margin:10px">
		Username:
		<input type="text" name="username" placeholder="Username" class="form-control" required>
		Password:
		<input type="password" name="password" placeholder="Password" class="form-control" required>
		<input type="submit" name="submit" class="btn btn-primary" style="margin-top:10px">
	  </form>
    </div>
  </div>
</div>
<!-- The Modal -->
<div id="myModal1" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 style="color:#000" class="text-uppercase text-dark px-2">Register</h2>
      <span class="close" onclick="cc()">&times;</span>
    </div>
    <div class="modal-body">
      
  <form method="POST" action="register.php" onsubmit="return c()">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="name" name="name" required placeholder="Fullname">
		<label for="name">Address</label>
		<input type="text" class="form-control" id="address" name="address" required placeholder="Full Address">
		<label for="name">Contact Number</label>
		<input type="text" class="form-control" id="contact" name="contact" required placeholder="Contact Number">
		<label for="name">Email Address</label>
		<input type="text" class="form-control" id="email" name="email" required placeholder="Email Address">
		<label for="name">Username</label>
		<input type="text" class="form-control" id="username" name="username" required placeholder="Username">
		<label for="name">Password</label>
		<input type="password" class="form-control" id="password1" name="password" required placeholder="Password">
		<label for="name">Confirm Password</label>
		<input type="password" class="form-control" id="password2" name="cpassword" required placeholder="Confirm Password">		
		<input type="submit" value="Register" class="btn btn-primary px-3" name="submit" style="margin-top:10px">
		<br>
		<br>
    </form>
    </div>
  </div>
</div>


<script>

function c() {
	var password1 = document.getElementById('password1').value;
	var password2 = document.getElementById('password2').value;
	if(password1 == password2) {
			return true;
	} else {
			alert("Password and Confirm Password did not match");
			return false;
	}
}
var modal = document.getElementById("myModal");
var modal1 = document.getElementById("myModal1");

var btn = document.getElementById("myBtn");
var btn1 = document.getElementById("myBtn1");


btn.onclick = function() {
  modal.style.display = "block";
}
btn1.onclick = function() {
  modal1.style.display = "block";
}

function cc() {
modal.style.display = "none";
modal1.style.display = "none";	
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  if (event.target == modal1) {
    modal1.style.display = "none";
  }
}
</script>
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary " style="bottom:0;position:fixed;margin-left:-0px;padding:10px;padding-bottom:0px !important;background:">		&copy; <a class="text-primary" href="#"></a> All Rights Reserved - Daniel and Marilyn's General Merchandise <?php echo date('Y'); ?></p>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>