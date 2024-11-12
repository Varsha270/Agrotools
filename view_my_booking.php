<?php
session_start();
require './admin/libs/database.php';
require './helpers/helpers.php';

// Check if the user is logged in
if (!isset($_SESSION['USER_ID'])) {
    echo "User is not logged in or session is missing.";
    exit;
}

$user_id = $_SESSION['USER_ID']; // Retrieve user ID from the session

// Get all bookings for the logged-in user
$sql = "SELECT l.*, p.name AS product_name FROM lendings l
        JOIN product p ON l.product_id = p.id
        WHERE l.user_id = '$user_id'";

$res = $db->query($sql);

$bookings = [];
while ($row = $res->fetch_object()) {
    $bookings[] = $row;
}
?>

<!-- HTML Code to Display Bookings -->
<section class="bg0">
    <div class="container">
        <div class="row" style="padding-top: 120px; padding-bottom: 100px">
            <div class="col-lg-12 mx-auto">
                <h3>My Bookings</h3>

                <?php if (count($bookings) > 0): ?>  
                    <?php foreach ($bookings as $booking): ?>
                        <div class="container d-flex">
                            <div class="card mb-3">
                                <div class="row g-1">
                                    <div class="col-md-4">
                                        <img src="./admin/uploaded-files/product/<?php echo $booking->image1 ?>" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <a href="./view-my-booking.php?id=<?php echo $booking->lending_id ?>">
                                                <h5 class="card-title"><?php echo $booking->product_name; ?></h5>
                                            </a>
                                            <span class="card-text">Booking Id: <?php echo $booking->lending_id; ?></span><br>
                                            <span class="card-text">Start Date: <?php echo $booking->start_date; ?></span><br>
                                            <span class="card-text">End Date: <?php echo $booking->end_date; ?></span><br>
                                            <p class="card-text">
                                                <small class="text-muted">Status:</small>
                                                <span class="badge badge-pill badge-<?php echo ($booking->booking_status == 'Pending') ? 'warning' : 'success'; ?>">
                                                    <?php echo $booking->booking_status; ?>
                                                </span>
                                            </p>
                                            
                                            <!-- Button to change status to 'Completed' if the current status is 'Pending' -->
                                            <?php if ($booking->booking_status == 'Pending'): ?>
                                                <form action="update_booking_status.php" method="POST">
                                                    <input type="hidden" name="lending_id" value="<?php echo $booking->lending_id; ?>">
                                                    <button type="submit" class="btn btn-success">Mark as Completed</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <h5 class="text-center">No Bookings Yet</h5>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include './footer.php'; ?>
