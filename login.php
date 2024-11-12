<?php include './header.php'; ?>






    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/blog77.png');">
        <h2 class="ltext-105 cl0 txt-center">
            Login/Register
        </h2>
    </section>	


    <!-- Content page -->
    <section class="bg0 p-t-104 p-b-116">
        <div class="container">
            <div class="flex-w flex-tr">
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                
                        <h4 class="mtext-105 cl2 txt-center p-b-30">
                            Login
                        </h4>
                     <form id="login-form">
                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="login_email" id="login_email" placeholder="Your Email Address">
                        </div>
                        <span class="field_error" id="login_email_error"></span>
                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="password" name="login_password" id="login_password"  placeholder="Your password">
                        </div>
                        <span class="field_error" id="login_password_error"></span>
                        <button type="button" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer" onclick="user_login()">
                            Submit
                        </button><br/>
                        <a href="./forgot-password.php" type="button" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                            Forget Password
                        </a>
                        <div class="form-output login_msg">
									<p class="form-messege field_error"></p>
						</div>
                    </form>
                </div>

                <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                <form id="register-form" method="post">
                        <h4 class="mtext-105 cl2 txt-center p-b-30">
                            Register
                        </h4>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" id="name" name="name" placeholder="Your Name">
                        </div>
                        <span class="field_error" id="name_error"></span>
                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" id="email" name="email" placeholder="Your Email">
                        </div>
                        <span class="field_error" id="email_error"></span>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" id="mobile" name="mobile" placeholder="Your Mobile">
                        </div>
                        <span class="field_error" id="mobile_error"></span>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="password" id="password" name="password" placeholder="Your Password">
                        </div>
                        <span class="field_error" id="password_error"></span>

                        <button type="button" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer" onclick="user_register()">
                            Submit
                        </button>
                       
                        <div class="form-output register_msg">
									<p class="form-messege field_error"></p>
								</div>
                    </form>
                </div>
            </div>
        </div>
    </section>	
    



<?php include './footer.php'; ?>