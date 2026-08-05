<?php
include('connect.php'); 
include('header.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $fetch_query = "SELECT * FROM `products` WHERE `product_id` = '$id'";
    $fetch_result = mysqli_query($con, $fetch_query);
    $pro_data = mysqli_fetch_assoc($fetch_result);
} else {
    echo "<script>window.location.href='viewpro.php';</script>";
    exit();
}
?>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Edit Product</h1>
                            </div>
                            <form class="user" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <!-- Category ID Dropdown -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Category</label>
                                        <select name="category_id" class="form-control" style="border-radius: 10rem; height: calc(1.5em + .75rem + 2px); padding: 0.375rem 1rem;" required>
                                            <?php
                                            $cat_query = "SELECT * FROM `categories`";
                                            $cat_result = mysqli_query($con, $cat_query);
                                            while($cat_row = mysqli_fetch_assoc($cat_result)) {
                                                $selected = ($cat_row['category_id'] == $pro_data['category_id']) ? "selected" : "";
                                                echo "<option value='".$cat_row['category_id']."' $selected>".$cat_row['category_name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Product Name -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Product Name</label>
                                        <input type="text" name="product_name" value="<?php echo $pro_data['product_name']; ?>" class="form-control form-control-user" required>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Price</label>
                                        <input type="number" step="0.01" name="price" value="<?php echo $pro_data['price']; ?>" class="form-control form-control-user" required>
                                    </div>

                                    <!-- Stock -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Stock</label>
                                        <input type="number" name="stock" value="<?php echo $pro_data['stock']; ?>" class="form-control form-control-user">
                                    </div>

                                    <!-- Weight -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Weight</label>
                                        <input type="text" name="weight" value="<?php echo $pro_data['weight']; ?>" class="form-control form-control-user">
                                    </div>

                                    <!-- Flavor -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Flavor</label>
                                        <input type="text" name="flavor" value="<?php echo $pro_data['flavor']; ?>" class="form-control form-control-user">
                                    </div>

                                    <!-- Status Dropdown -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Status</label>
                                        <select name="status" class="form-control" style="border-radius: 10rem; height: calc(1.5em + .75rem + 2px); padding: 0.375rem 1rem;">
                                            <option value="Available" <?php echo ($pro_data['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                            <option value="Out of Stock" <?php echo ($pro_data['status'] == 'Out of Stock') ? 'selected' : ''; ?>>Out of Stock</option>
                                        </select>
                                    </div>

                                    <!-- Product Image -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Product Image (Leave blank to keep old)</label>
                                        <input type="file" name="product_image" class="form-control" style="border-radius: 10rem; padding: 0.4rem 1rem;">
                                        <?php if(!empty($pro_data['image'])){ ?>
                                            <small class="text-muted ml-3">Current: <?php echo $pro_data['image']; ?></small>
                                        <?php } ?>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-sm-12 mb-3">
                                        <label class="small font-weight-bold">Description</label>
                                        <textarea name="description" class="form-control" rows="3" style="border-radius: 15px; padding: 1rem;"><?php echo $pro_data['description']; ?></textarea>
                                    </div>
                                </div>

                                <button name="update_btn" class="btn btn-success btn-user btn-block">
                                    Update Product
                                </button>
                                <a href="viewpro.php" class="btn btn-secondary btn-user btn-block text-center">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
if(isset($_POST['update_btn'])){
    $category_id = $_POST['category_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = !empty($_POST['stock']) ? $_POST['stock'] : 0; 
    $weight = $_POST['weight'];
    $flavor = $_POST['flavor'];
    $status = $_POST['status'];
    
    // Image Update Logic
    $product_image = $_FILES['product_image']['name'];
    $tmp_name = $_FILES['product_image']['tmp_name'];
    
    if(!empty($product_image)){
        move_uploaded_file($tmp_name, "img/$product_image");
        $img_query_part = ", `image` = '$product_image'";
    } else {
        $img_query_part = ""; // Agar nayi image upload nahi ki to purani hi rahegi
    }

    // Update Query
    $update_query = "UPDATE `products` SET 
                    `category_id` = '$category_id', 
                    `product_name` = '$product_name', 
                    `description` = '$description', 
                    `price` = '$price', 
                    `stock` = '$stock', 
                    `weight` = '$weight', 
                    `flavor` = '$flavor', 
                    `status` = '$status' 
                    $img_query_part 
                    WHERE `product_id` = '$id'";
    
    $update_result = mysqli_query($con, $update_query);

    if($update_result){
        echo "<script>alert('Product Updated Successfully'); window.location.href='viewpro.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "')</script>";
    }
}
?>
