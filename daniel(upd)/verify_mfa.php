<?php
session_start();

if (!isset($_SESSION['mfa_code']) || !isset($_SESSION['temp_user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['mfa_code'])) {
    // Add debugging information
    error_log("Submitted MFA code: " . $_POST['mfa_code']);
    error_log("Stored MFA code: " . $_SESSION['mfa_code']);
    
    if ($_POST['mfa_code'] == $_SESSION['mfa_code']) {
        error_log("MFA codes match!");
        // MFA successful, set up the session
        $_SESSION['username'] = $_SESSION['temp_user'];
        $type = $_SESSION['temp_type'];
        
        // Clean up temporary session variables
        unset($_SESSION['mfa_code']);
        unset($_SESSION['temp_user']);
        unset($_SESSION['temp_type']);
        
        // Redirect based on user type
        if($type == 'admin') {
            header("Location: admin/index.php");
        } elseif($type == 'store') {
            header("Location: store/index.php");
        } elseif($type == 'user') {
            header("Location: ./index.php");
        }
        exit();
    } else {
        error_log("MFA codes do not match!");
        $error = "Invalid MFA code. Please try again.";
        // Add visible debug info
       
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify MFA Code</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body style="background:#FFFBE6">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4">Enter MFA Code</h3>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="mfa_code">Enter the code sent to your email</label>
                                <input type="text" class="form-control" id="mfa_code" name="mfa_code" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 