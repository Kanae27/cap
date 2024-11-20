<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  
</body>
</html>

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
<style>
    .bg-dark-green {
        background-color: #006400 !important; /* Dark green color */
    }
</style>

<footer class="bg-dark-green text-white py-2">
    <div class="container">
        <div class="row text-center">
            <!-- About Us Section -->
            <div class="col-md-12 mb-2">
                <h5 class="text-white mb-2">About Us</h5>
                <p class="small">Our store was established way back in 2010<br>
                We provide fresh vegetables and quality goods.<br>
                And offer convenience to our customers.</p>
            </div>
        </div>
        
        <div class="row text-center">
            <!-- Location Section -->
            <div class="col-md-4 mb-2">
                <h5 class="text-white mb-2">Location</h5>
                <address class="small">
                    <i class="fa fa-map-marker-alt mr-2" aria-hidden="true"></i>
                    Rizal Street, Lipa City, Batangas<br>
                    Philippines
                </address>
            </div>

            <!-- Connect with Us Section -->
            <div class="col-md-4 mb-2">
                <h5 class="text-white mb-2">Connect with Us</h5>
                <div class="mb-3">
                    <a href="#" class="text-white me-2" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-white me-2" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-white me-2" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                <p class="small">
                    <i class="fa fa-mobile-alt me-2" aria-hidden="true"></i>
                    0947-490-3288
                </p>
            </div>

            <!-- Store Hours Section -->
            <div class="col-md-4 mb-2">
                <h5 class="text-white mb-2">Store Hours</h5>
                <p class="small">Monday - Sunday: 3:30 AM - 5:00 PM</p>
            </div>
        </div>

        <!-- FAQs Section -->
        <div class="row text-center">
            <div class="col-md-12 mb-4">
                <h5 class="text-white mb-3">Frequently Asked Questions</h5>
                <div class="small">
                    <!-- FAQ Questions -->
                    <p>
                        <strong><a href="javascript:void(0);" onclick="toggleAnswer('answer1')" class="text-white">Q: What products do you offer?</a></strong>
                    </p>
                    <p id="answer1" class="faq-answer" style="display:none;">A: We offer a variety of fresh vegetables and quality goods.</p>
                    
                    <p>
                        <strong><a href="javascript:void(0);" onclick="toggleAnswer('answer2')" class="text-white">Q: How do I place an order?</a></strong>
                    </p>
                    <p id="answer2" class="faq-answer" style="display:none;">A: You can place an order by browsing products, adding them to your cart, <br>and proceeding to checkout to complete the payment.</p>
                    
                    <p>
                        <strong><a href="javascript:void(0);" onclick="toggleAnswer('answer3')" class="text-white">Q: Do you offer delivery services?</a></strong>
                    </p>
                    <p id="answer3" class="faq-answer" style="display:none;">A: Yes, we provide delivery services for your convenience.</p>

                    <!-- FAQ Page Button -->
                    <a href="faq-page.php" class="btn btn-primary btn-sm mt-3">Visit Full FAQ Page</a>
                </div>
            </div>
        </div>

        <!-- Optional Bottom Line -->
        <div class="text-center small mt-4">
            &copy; <?= date('Y'); ?> Your Company. All rights reserved.
        </div>
    </div>
</footer>
<!-- Footer End -->

<script>
    function toggleAnswer(id) {
        const answer = document.getElementById(id);
        if (answer.style.display === 'none') {
            answer.style.display = 'block';
        } else {
            answer.style.display = 'none';
        }
    }
</script>



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