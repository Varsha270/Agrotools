<?php include './header.php';
  

if(!isset($_SESSION['USER_LOGIN'])){
    ?>
    <script>
    window.location.href='./index.php';
    </script>
    <?php
}
$order_id=get_safe_value($db,$_GET['id']);



?>
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
            Order Details
        </span>
    </div>
</div>

<section class="bg0 p-t-62 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                    <table class="table-shopping-cart">
                            <tr class="table_head">
                              
                                <th class="column-1">Product Name</th>
                                <th class="column-2">Image</th>
                                <th class="column-3">Qty</th>
                                <th class="column-4">Price</th>
                                <th class="column-5">Total Price</th>
                           
                             
                            </tr>
                            <?php
                                            $uid=$_SESSION['USER_ID'];
                                            $res=mysqli_query($db,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image1 from order_detail,product ,`order` where order_detail.order_id='$order_id' and `order`.user_id='$uid' and order_detail.product_id=product.id");
                                            $total_price=0;
                                            while($row=mysqli_fetch_assoc($res)){
                                              
                                            $total_price=$total_price+($row['qty']*$row['price']);
                                            $front_image1 = explode('/', $row['image1'])[4];

                                            ?>
                           <tr class="table_row">
                                
                                    <td class="column-1"><?php echo $row['name']?></td>
                                    <td class="column-2">
                                    <div class="how-itemcart1">
                                        <img src="./admin/uploaded-files/product/<?php echo $front_image1 ?>"></td>
                                        </div>
                                    <td class="column-3"><?php echo $row['qty']?></td>
                                    <td class="column-4">
                                    <?php echo $row['price']?>
                                    </td>
                                    <td class="column-5"><?php echo $row['qty']*$row['price']?></td>                                    
                                </tr>
                                <?php } ?>
                        </table>
                        
                    </div>

                </div>
            </div>

            <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">
                        Cart Totals
                    </h4>

                    <div class="flex-w flex-t bor12 p-b-13">
                        <div class="size-208">
                            <span class="stext-110 cl2">
                                Subtotal:
                            </span>
                        </div>

                        <div class="size-209">
                            <span class="mtext-110 cl2">
                            <?php echo $total_price?>
                            </span>
                        </div>
                    </div>

                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
            

                        
                    </div>

                    

                </div>
            </div>  

        </div>
    </div>
</section>
<?php include './footer.php'; ?>