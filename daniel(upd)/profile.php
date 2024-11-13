<?php
include('./header.php');


$username = $_SESSION['username'];

// Fetch user details
$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

if ($result) {
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
        // User not found
        echo '<script>alert("User  not found. Please log in again.");window.location="login.php"</script>';
        exit();
    }
} else {
    // Query error
    echo '<script>alert("Error fetching user details.");window.location="login.php"</script>';
    exit();
}

// Handling Profile Update
if (isset($_POST['submit_profile'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Update the user profile information
    mysqli_query($conn, "UPDATE user SET name = '$name', address = '$address', contact = '$contact', email = '$email' WHERE username = '$username'");
    echo '<script>alert("Profile has been updated");window.location="profile.php"</script>';
}

// Handling Password Update
if (isset($_POST['submit_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password from the database
    $current_user_result = mysqli_query($conn, "SELECT password FROM login WHERE username = '$username'");
    $current_user = mysqli_fetch_assoc($current_user_result);
    
    if ($current_user && $current_user['password'] == $old_password) {
        if ($new_password == $confirm_password) {
            mysqli_query($conn, "UPDATE login SET password = '$new_password' WHERE username = '$username'");
            echo '<script>alert("Password has been updated");window.location="profile.php"</script>';
        } else {
            echo '<script>alert("New Password and Confirm Password do not match");window.location="profile.php"</script>';
        }
    } else {
        echo '<script>alert("Incorrect Old Password");window.location="profile.php"</script>';
    }
}

// Handling Profile Image Update
if (isset($_POST['submit_image'])) {
    $target_dir = "./uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image = $_FILES["image"]["name"];
        mysqli_query($conn, "UPDATE user SET image = '$image' WHERE username = '$username'");
        echo '<script>alert("Profile image has been updated");window.location="profile.php"</script>';
    } else {
        echo '<script>alert("Error uploading image");window.location="profile.php"</script>';
    }
}
?>

<!-- HTML Form Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-12 col-md-8">
            <div class="row" style="color:#000">
                <!-- Profile Information Form -->
                <div class="col-md-7">
                    <div style="background:#FFF;padding:20px;border:1px solid #d4d4d4;margin-bottom:10px">
                        <form method="POST" action="#">
                            <h3>Account Information</h3>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($user['name']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required value="<?php echo htmlspecialchars ($user['address']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact Number</label>
                                <input type="text" class="form-control" id="contact" name="contact" required value="<?php echo htmlspecialchars($user['contact']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit_profile">Update Profile</button>
                        </form>
                    </div>

                    <!-- Password Settings Form -->
                    <div style="background:#FFF;padding:20px;border:1px solid #d4d4d4;margin-bottom:10px">
                        <form action="#" method="POST">
                            <h3>Password Settings</h3>
                            <div class="form-group">
                                <label for="old_password">Old Password</label>
                                <input type="password" class="form-control" id="old_password" name="old_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit_password">Update Password</button>
                        </form>
                    </div>

                    <!-- Profile Image Form -->
                    <div style="background:#FFF;padding:20px;border:1px solid #d4d4d4;margin-bottom:10px">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <h3>Profile Image</h3>
                            <div class="form-group">
                                <label for="image">Select Image</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit_image">Update Image</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            
					
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profileImage');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
					
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php
include('./footer.php');
?>