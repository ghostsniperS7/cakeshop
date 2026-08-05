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
                                <h1 class="h4 text-gray-900 mb-4">Add Category</h1>
                            </div>
                            <form class="user" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="cat_name" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Category Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="cat_desc" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Description">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="file" name="cat_image" class="form-control form-control-user" id="exampleLastName">
                                    </div>
                                </div>
                                </div>
                                <button name="btn" class="btn btn-primary btn-user btn-block">
                                    Add Category
                                </button>
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
    $cat_name = $_POST['cat_name'];
    $cat_desc = $_POST['cat_desc'];
    $cat_image = $_FILES['cat_image']['name'];
    $tmp_name = $_FILES['cat_image']['tmp_name'];
    move_uploaded_file($tmp_name,"img/$cat_image");
    $query = "INSERT INTO `categories`(`category_name`, `description`, `image`) VALUES ('$cat_name','$cat_desc','$cat_image')";
    $result = mysqli_query($con, $query);
    echo "<script>alert('Category Added Successfully')</script>";
}
?>