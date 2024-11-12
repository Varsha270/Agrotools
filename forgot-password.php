<?php include './header.php';



$err = '';
$msg = '';

require './vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Check if email is empty
    if (strlen($email) < 1) {
        $err = "Please enter your email address";
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = "Please enter a valid email address";
    } else {
        // Database connection
        $conn = mysqli_connect("localhost", "root", "", "shopping");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if email exists in the database
        $email = mysqli_real_escape_string($conn, $email);
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Generate verification code
            $verification_code = rand(100000, 999999); // 6-digit code

            // Update user record with the verification code
            $update_query = "UPDATE users SET verification_code='$verification_code' WHERE email='$email'";
            mysqli_query($conn, $update_query);

            // Store the email in session for later use
            $_SESSION['reset_email'] = $email;

            // Send verification code to user's email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set SMTP server to send through
                $mail->SMTPAuth = true;
                $mail->Username = 'dummyinjamul@gmail.com'; // SMTP username
                $mail->Password = 'efqkandmbsjhpeas'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('dummyinjamul@gmail.com', 'Your Site');
                $mail->addAddress($email); // Add user's email

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Verification Code';
                $mail->Body = "Your password reset verification code is: <strong>$verification_code</strong>";

                $mail->send();
                $msg = "A verification code has been sent to your email.";
                // Redirect to verify code page
                echo '<script>window.location = "./verify_code.php"</script>';

            } catch (Exception $e) {
                $err = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $err = "Email not found in our records.";
        }

        mysqli_close($conn);
    }
}

?>

<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/download5.webp');">
    <h2 class="ltext-105 cl0 txt-center">
        Forgot password
    </h2>
</section>


<!-- Content page -->
<section class="bg0 p-t-104 p-b-116">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">

                <form action="forgot-password.php" method="POST">
                    <h4 class="mtext-105 cl2 txt-center p-b-30">
                        Forgot password setup
                    </h4>

                    <div class="bor8 m-b-20 how-pos4-parent">

                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="email" name="email"
                            placeholder="Your Email Address">
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


<!-- Map -->
<div class="map">
    <div class="size-303" id="google_map" data-map-x="40.691446" data-map-y="-73.886787" data-pin="images/icons/pin.png"
        data-scrollwhell="0" data-draggable="1" data-zoom="11"></div>
</div>

<?php include './footer.php'; ?>