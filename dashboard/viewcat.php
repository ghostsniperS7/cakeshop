<?php 
include('connect.php'); 
include('header.php'); 
?> 

<div class="container-fluid mt-4"> 
    <div class="card shadow mb-4"> 
        <div class="card-header py-3 d-flex justify-content-between align-items-center"> 
            <h6 class="m-0 font-weight-bold text-primary">All Categories</h6> 
            <a href="addcat.php" class="btn btn-sm btn-primary">Add New Category</a> 
        </div> 
        <div class="card-body"> 
            <div class="table-responsive"> 
                <table class="table table-bordered" width="100%" cellspacing="0"> 
                    <thead> 
                        <tr> 
                            <th>ID</th> 
                            <th>Image</th> 
                            <th>Name</th> 
                            <th>Description</th> 
                            <th>Action</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                    <?php 
                    // Categories table se data lane ke liye simple query
                    $query = "SELECT * FROM `categories`"; 
                    $result = mysqli_query($con, $query); 
                    
                    while($row = mysqli_fetch_assoc($result)){ 
                    ?> 
                        <tr> 
                            <td><?php echo $row['category_id']; ?></td> 
                            <td> 
                                <?php if(!empty($row['image'])){ ?> 
                                    <img src="img/<?php echo $row['image']; ?>" width="50" height="50" style="object-fit: cover; border-radius: 5px;"> 
                                <?php } else { echo "No Image"; } ?> 
                            </td> 
                            <td><?php echo $row['category_name']; ?></td> 
                            <td><?php echo $row['description'] ?? 'No Description'; ?></td> 
                            <td> 
                                <a href="editcat.php?id=<?php echo $row['category_id']; ?>" class="btn btn-sm btn-info">Edit</a> 
                                <a href="deletecat.php?del_id=<?php echo $row['category_id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')" class="btn btn-sm btn-danger">Delete</a> 
                            </td> 
                        </tr> 
                    <?php } ?> 
                    </tbody> 
                </table> 
            </div> 
        </div> 
    </div> 
</div> 

<script src="vendor/jquery/jquery.min.js"></script> 
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
</body>
