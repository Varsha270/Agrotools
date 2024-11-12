<?php include './header.php';

$err = '';
$msg = '';

if (!isset($_SESSION['verified']) || !$_SESSION['verified']) {
    $err = "Unauthorized access. Please go through the verification process.";
    echo '<script>window.location = "./forgot-password.php"</script>';
}

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Password validation
    if (strlen($password) < 6) {
        $err = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm_password) {
        $err = "Passwords do not match.";
    } else {
        $email = $_SESSION['reset_email']; // Get the user's email from session

        // Hash the password
        //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        $conn = mysqli_connect("localhost", "root", "", "shopping");

        // Update the password
        $update_query = "UPDATE users SET password='$password', verification_code=NULL WHERE email='$email'";
        if (mysqli_query($conn, $update_query)) {
            $msg = "Your password has been successfully reset.";
            unset($_SESSION['reset_email']); // Clear the session
            unset($_SESSION['verified']); // Clear verification status
        } else {
            $err = "Failed to reset password. Please try again.";
        }

        mysqli_close($conn);
    }
}


?>
<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/download5.webp');">
    <h2 class="ltext-105 cl0 txt-center">
   Reset password
    </h2>
</section>

<!-- Content page -->
<section class="bg0 p-t-104 p-b-116">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">

                <form action="reset_password.php" method="POST">
                    <h4 class="mtext-105 cl2 txt-center p-b-30">
                       Reset password
                    </h4>

                    <div class="bor8 m-b-20 how-pos4-parent">

                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="password" name="password"
                            placeholder="New password">
                    </div>
                    <div class="bor8 m-b-20 how-pos4-parent">

                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="password" name="confirm_password"
                            placeholder="Confirm password">
                    </div>

                    <button type="submit" name="submit"
                        class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                        Submit
                    </button>
                </form>
                <?php if ($err != ''): ?>
                    <p style="color: red;"><?php echo $err; ?></p>
                <?php endif; ?>
                <?php if ($msg != ''): ?>
                    <p style="color: green;"><?php echo $msg; ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
    </div>
    </div>
</section>

<?php include './footer.php'; ?>