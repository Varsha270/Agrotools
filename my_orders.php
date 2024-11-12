<?php include './header.php'; ?>
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-02.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        orders
    </h2>
</section>
<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            Orders
        </span>
    </div>
</div>

<section class="bg0 p-t-62 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-12 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                              
                                <th class="column-1">Order Id</th>
                                <th class="column-2">Order Date</th>

                                <th class="column-3">Payment Type</th>
                                <th class="column-4">Order Status</th>
                                <th class="column-5">Action</th>
                             
                            </tr>
                            <?php
                                    $uid=$_SESSION['USER_ID'];
                                     $res=mysqli_query($db,"select `order`.*,order_status.name as order_status_str from `order`,order_status where `order`.user_id='$uid' and order_status.id=`order`.order_status");
                                    while($row=mysqli_fetch_assoc($res)){
                                ?>
                           <tr class="table_row">
                        
                                    <td class="column-1"> <?php echo $row['id']?></td>
                                    <td class="column-2"><?php echo $row['added_on']?></td>
                                 
                                    <td class="column-3"><?php echo $row['payment_type']?></td>
                                    <td class="column-4"><?php echo $row['order_status_str']?></td>
                                    <td class="column-5"><a href="order_details.php?id=<?php echo $row['id']?>">View</a></td>
                                    
                                </tr>
                                <?php } ?>

                        </table>
                        
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<?php include './footer.php'; ?>