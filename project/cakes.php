<?php include('header.php'); ?>

<main>
    <!--? Hero Area Start-->
    <div class="slider-area">
        <div class="single-slider slider-height2 slider-bg2 d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center ">
                    <div class="col-xxl-12">
                        <!-- Hero Caption -->
                        <div class="hero-caption hero-caption2">
                            <h2>Delicious Cakes</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Hero Area End-->
    <!--? Latest-items 02 Start -->
    <section class="latest-items section-padding fix">
        <div class="container">
            <div class="row">

                <?php
                include('../dashboard/connect.php');
                $query = "SELECT * FROM `products`";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)) {

                ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="properties properties2 pb-40">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="#"><img src="../dashboard/img/<?php echo $row['image']; ?>" alt="" fetchpriority="high" decoding="sync"></a>
<div class="img-cap">
    <span>
        <a href="cart.php?cartid=<?php echo $row['product_id']; ?>" style="color: inherit; text-decoration: none; display: block; width: 100%; height: 100%;">
            Add to cart
        </a>
    </span>
</div>

                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="#"><?php echo $row['product_name']; ?></a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$<?php echo $row['price']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Latest-items End -->
    <!--? Instragram Start -->
    <div class="instragram ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-7 ">
                    <!-- Section Tittle -->
                    <div class="section-tittle  text-center mb-70">
                        <h2>Follow us on Instagram</h2>
                        <a href="#" class="btn_02 btn_02s mt-25"><i class="fab fa-instagram"></i>Cakeshop</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="instra-img mb-30">
                        <a href="#"><img src="assets/img/gallery/instra1.jpg" alt="" class="w-100" loading="lazy" decoding="async"></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="instra-img mb-30">
                        <a href="#"><img src="assets/img/gallery/instra2.jpg" alt="" class="w-100" loading="lazy" decoding="async"></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="instra-img mb-30">
                        <a href="#"><img src="assets/img/gallery/instra3.jpg" alt="" class="w-100" loading="lazy" decoding="async"></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="instra-img mb-30">
                        <a href="#"><img src="assets/img/gallery/instra4.jpg" alt="" class="w-100" loading="lazy" decoding="async"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include('footer.php');

?>