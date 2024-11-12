<?php include './header.php'; 
require './admin/libs/database.php';

if (!isset($_SESSION['USER_ID']) ) {
    header("Location: ./login.php");
    exit();
  }
  

$user_id =  $_SESSION['USER_ID'];

$sql = "SELECT p.*, l.* FROM lendings l
        JOIN product p ON l.product_id = p.id
        WHERE l.user_id = '$user_id'";

        //echo $sql;die;
$res = $db->query($sql);

$tools = [];
while ($row = $res->fetch_object()) {
    $tools[] = $row;
}

?>

	<!-- Content page -->
	<section class="bg0 ">
		<div class="container">
            <div class="row" style="padding-top: 120px; padding-bottom:100px">
                <div class="col-lg-12 mx-auto">

                    <h3>My Bookings </h3>

                  <?php if(count($tools) > 0): ?>  
                    <?php foreach($tools as $tool): ?>
                    <div class="container d-flex ">
                     
                        <div class="card mb-3">
                            <div class="row g-1">
                          
                              <div class="col-md-4">
                                    <img src="./admin/uploaded-files/product/<?php 
                                    $fileName1 = explode('/', $tool->image1)[4];
                                    echo $fileName1 ?>"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                    <a href="./view_my_booking.php?id=<?php echo $tool->id ?>"><h5 class="card-title">
                                     <?php echo $tool->name; ?>
                                        </h5></a>
                                 
                                        <span class="card-text">
                                        Booking Id : <?php echo $tool->lending_id; ?>
                                        
                                        </span><br>
                                        <span class="card-text">
                                           Start Date : <?php echo $tool->start_date; ?>
                                        
                                        </span><br>
                                        <span class="card-text">
                                          
                                           End Date : <?php echo $tool->end_date; ?>
                                        </span>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                Status:
                                            </small>
                                            <span class="badge badge-pill badge-success"><?php echo $tool->booking_status; ?></span>
                                        </p>
                                    </div>
                                </div>
                               
                              
                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <h5 class="text-center">No Booking Yet</h5>
                    <?php endif ?>
                </div>
            </div>
    </section><!-- #intro -->

<?php include './footer.php'; ?>