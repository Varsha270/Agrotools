<?php include './header.php';

$err = '';
$msg = '';

if (isset($_POST['submit'])) {
    $code = $_POST['code'];

    // Check if code is empty
    if (strlen($code) < 1) {
        $err = "Please enter the verification code";
    } else {
        if (!isset($_SESSION['reset_email'])) {
            $err = "Session expired. Please start the forgot password process again.";
        } else {
            $email = $_SESSION['reset_email']; // Retrieve email from session
            
            // Database connection
            $conn = mysqli_connect("localhost", "root", "", "shopping");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Check if the code matches
            $code = mysqli_real_escape_string($conn, $code);
            $email = mysqli_real_escape_string($conn, $email);
            $query = "SELECT * FROM users WHERE email='$email' AND verification_code='$code'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                // Verification success
                $_SESSION['verified'] = true;
                //header("Location: reset_password.php");
                //exit();
                echo '<script>window.location = "./reset_password.php"</script>';
            } else {
                $err = "Invalid verification code.";
            }

            mysqli_close($conn);
        }
    }
}

?>
<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/download5.webp');">
    <h2 class="ltext-105 cl0 txt-center">
    Verify Code
    </h2>
</section>

<!-- Content page -->
<section class="bg0 p-t-104 p-b-116">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">

                <form action="verify_code.php" method="POST">
                    <h4 class="mtext-105 cl2 txt-center p-b-30">
                       verify code
                    </h4>

                    <div class="bor8 m-b-20 how-pos4-parent">

                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="code"
                            placeholder="verification code">
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