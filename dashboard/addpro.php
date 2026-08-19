<?php
include('connect.php');
include('header.php');
?>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
                            </div>
                            <form class="user" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <!-- Category ID Dropdown -->
                                    <div class="col-sm-6 mb-3">
                                        <select name="category_id" class="form-control" style="border-radius: 10rem; height: calc(1.5em + .75rem + 2px); padding: 0.375rem 1rem;" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            // Categories table se data lane ke liye
                                            $cat_query = "SELECT * FROM `categories`";
                                            $cat_result = mysqli_query($con, $cat_query);
                                            while($cat_row = mysqli_fetch_assoc($cat_result)) {
                                                echo "<option value='".$cat_row['category_id']."'>".$cat_row['category_name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Product Name -->
                                    <div class="col-sm-6 mb-3">
                                        <input type="text" name="product_name" class="form-control form-control-user" placeholder="Product Name" required>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-sm-6 mb-3">
                                        <input type="number" step="0.01" name="price" class="form-control form-control-user" placeholder="Price" required>
                                    </div>

                                    <!-- Stock -->
                                    <div class="col-sm-6 mb-3">
                                        <input type="number" name="stock" class="form-control form-control-user" placeholder="Stock Quantity">
                                    </div>

                                    <!-- Weight -->
                                    <div class="col-sm-6 mb-3">
                                        <input type="text" name="weight" class="form-control form-control-user" placeholder="Weight (e.g. 500g, 1kg)">
                                    </div>

                                    <!-- Flavor -->
                                    <div class="col-sm-6 mb-3">
                                        <input type="text" name="flavor" class="form-control form-control-user" placeholder="Flavor">
                                    </div>

                                    <!-- Status Dropdown -->
                                    <div class="col-sm-6 mb-3">
                                        <select name="status" class="form-control" style="border-radius: 10rem; height: calc(1.5em + .75rem + 2px); padding: 0.375rem 1rem;">
                                            <option value="Available">Available</option>
                                            <option value="Out of Stock">Out of Stock</option>
                                        </select>
                                    </div>

                                    <!-- Product Image -->
                                    <div class="col-sm-6 mb-3">
                                        <input type="file" name="product_image" class="form-control" style="border-radius: 10rem; padding: 0.4rem 1rem;">
                                    </div>

                                    <!-- Description -->
                                    <div class="col-sm-12 mb-3">
                                        <textarea name="description" class="form-control" rows="3" placeholder="Product Description" style="border-radius: 15px; padding: 1rem;"></textarea>
                                    </div>
                                </div>

                                <button name="btn" class="btn btn-primary btn-user btn-block">
                                    Add Product
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

<?php
if(isset($_POST['btn'])){
    $category_id = $_POST['category_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = !empty($_POST['stock']) ? $_POST['stock'] : 0; 
    $weight = $_POST['weight'];
    $flavor = $_POST['flavor'];
    $status = $_POST['status'];
    
    // Image Handling
    $product_image = $_FILES['product_image']['name'];
    $tmp_name = $_FILES['product_image']['tmp_name'];
    
    if(!empty($product_image)){
        move_uploaded_file($tmp_name, "img/$product_image");
    } else {
        $product_image = "";
    }

    // FIXED QUERY: Ab yahan columns aur values ki ginti (9 columns aur 9 values) barabar hai
    $query = "INSERT INTO `products`(`category_id`, `product_name`, `description`, `price`, `stock`, `weight`, `flavor`, `image`, `status`) 
              VALUES ('$category_id', '$product_name', '$description', '$price', '$stock', '$weight', '$flavor', '$product_image', '$status')";
    
    $result = mysqli_query($con, $query);

    if($result){
        echo "<script>alert('Product Added Successfully'); window.location.href=window.location.href;</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "')</script>";
    }
}
?>
