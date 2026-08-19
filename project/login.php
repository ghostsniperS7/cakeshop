<?php
include('../dashboard/connect.php');
include('header.php');
?>

    <main>
        <!--? Hero Area Start-->
        <div class="slider-area">
            <div class="single-slider slider-height2 slider-bg2 d-flex align-items-center">
                <div class="container">
                    <div class="row justify-content-center ">
                        <div class="col-xxl-12">
                            <!-- Hero Caption -->
                            <div class="hero-caption hero-caption2">
                                <h2>Login</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Hero Area End-->
        <!--  Contact Area start  -->
        <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="contact-title">Login</h2>
                    </div>
                    <div class="col-lg-8">
<form class="form-contact contact_form" method="post">
    <div class="row">
        <div class="col-12">
        </div>
        <!-- Email Field -->
        <div class="col-sm-6">
            <div class="form-group">
                <input class="form-control valid text-white" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email" required>
            </div>
        </div>
        <!-- Password Field (Sahi class: col-sm-6) -->
        <div class="col-sm-6">
            <div class="form-group">
                <input class="form-control text-white" name="password" id="password" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Password'" placeholder="Enter Password" required>
            </div>
        </div>
    </div>
    <div class="form-group mt-3">
        <button type="submit" name="btn" class="button button-contactForm btn_1">Login</button>
    </div>
</form>

                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-home"></i></span>
                            <div class="media-body">
                                <h3>Buttonwood, California.</h3>
                                <p>Rosemead, CA 91770</p>
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                            <div class="media-body">
                                <h3>+1 253 565 2365</h3>
                                <p>Mon to Fri 9am to 6pm</p>
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-email"></i></span>
                            <div class="media-body">
                                <h3>support@colorlib.com</h3>
                                <p>Send us your query anytime!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Area End -->
    </main>
    <?php
    include('footer.php');
    if(isset($_POST['btn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $row['user_id'];
            $_SESSION['name'] = $row['full_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === 'admin') {
                header("Location: ../dashboard/index.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            echo "<script>alert('Invalid email or password!');</script>";
        }
    }
    ?>