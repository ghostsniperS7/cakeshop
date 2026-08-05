<?php
include('connect.php');
include('header.php');
?>

<div class="container-fluid mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
            <a href="addpro.php" class="btn btn-sm btn-primary">Add New Product</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Weight</th>
                            <th>Flavor</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Products ke sath category ka naam lane ke liye JOIN query
                        $query = "SELECT p.*, c.category_name FROM `products` p 
                                  LEFT JOIN `categories` c ON p.category_id = c.category_id";
                        $result = mysqli_query($con, $query);
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $row['product_id']; ?></td>
                            <td>
                                <?php if(!empty($row['image'])){ ?>
                                    <img src="img/<?php echo $row['image']; ?>" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                                <?php } else { echo "No Image"; } ?>
                            </td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['category_name'] ?? 'N/A'; ?></td>
                            <td>Rs. <?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td><?php echo $row['weight']; ?></td>
                            <td><?php echo $row['flavor']; ?></td>
                            <td>
                                <span class="badge <?php echo ($row['status'] == 'Available') ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="editpro.php?id=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                <!-- Yeh link ab direct deletepro.php file par ID bhejega -->
                                <a href="deletepro.php?del_id=<?php echo $row['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
// Bootstrap aur scripts include karne ke liye (agar header mein nahi hain)
?>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
