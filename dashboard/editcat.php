<?php 
include('connect.php'); 
include('header.php'); 

if(isset($_GET['id'])){ 
    $id = $_GET['id']; 
    // Categories table se data fetch karne ke liye query
    $fetch_query = "SELECT * FROM `categories` WHERE `category_id` = '$id'"; 
    $fetch_result = mysqli_query($con, $fetch_query); 
    $cat_data = mysqli_fetch_assoc($fetch_result); 
} else { 
    // Agar ID na mile to view categories wale page per redirect karega
    echo "<script>window.location.href='viewcat.php';</script>"; 
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
                                <h1 class="h4 text-gray-900 mb-4">Edit Category</h1> 
                            </div> 
                            <form class="user" method="post" enctype="multipart/form-data"> 
                                <div class="form-group row"> 
                                    
                                    <!-- Category Name --> 
                                    <div class="col-sm-6 mb-3"> 
                                        <label class="small font-weight-bold">Category Name</label> 
                                        <input type="text" name="category_name" value="<?php echo $cat_data['category_name']; ?>" class="form-control form-control-user" required> 
                                    </div> 

                                    <!-- Category Image --> 
                                    <div class="col-sm-6 mb-3"> 
                                        <label class="small font-weight-bold">Category Image (Leave blank to keep old)</label> 
                                        <input type="file" name="category_image" class="form-control" style="border-radius: 10rem; padding: 0.4rem 1rem;"> 
                                        <?php if(!empty($cat_data['image'])){ ?> 
                                            <small class="text-muted ml-3">Current: <?php echo $cat_data['image']; ?></small> 
                                        <?php } ?> 
                                    </div> 

                                    <!-- Description --> 
                                    <div class="col-sm-12 mb-3"> 
                                        <label class="small font-weight-bold">Description</label> 
                                        <textarea name="description" class="form-control" rows="3" style="border-radius: 15px; padding: 1rem;"><?php echo $cat_data['description']; ?></textarea> 
                                    </div> 
                                </div> 

                                <button name="update_btn" class="btn btn-success btn-user btn-block"> Update Category </button> 
                                <a href="viewcat.php" class="btn btn-secondary btn-user btn-block text-center">Cancel</a> 
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
    $category_name = $_POST['category_name']; 
    $description = $_POST['description']; 

    // Image Update Logic 
    $category_image = $_FILES['category_image']['name']; 
    $tmp_name = $_FILES['category_image']['tmp_name']; 

    if(!empty($category_image)){ 
        move_uploaded_file($tmp_name, "img/$category_image"); 
        $img_query_part = ", `image` = '$category_image'"; 
    } else { 
        $img_query_part = ""; // Agar nayi image upload nahi ki to purani hi rahegi 
    } 

    // Database fields ke mutabiq Update Query
    $update_query = "UPDATE `categories` SET `category_name` = '$category_name', `description` = '$description' $img_query_part WHERE `category_id` = '$id'"; 
    $update_result = mysqli_query($con, $update_query); 

    if($update_result){ 
        echo "<script>alert('Category Updated Successfully'); window.location.href='viewcat.php';</script>"; 
    } else { 
        echo "<script>alert('Error: " . mysqli_error($con) . "')</script>"; 
    } 
} 
?>
