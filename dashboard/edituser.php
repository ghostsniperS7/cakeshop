<?php
include('connect.php');
include('header.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    // Database structure ke mutabik users table aur user_id use kiya hai
    $fetch_query = "SELECT * FROM `users` WHERE `user_id` = '$id'";
    $fetch_result = mysqli_query($con, $fetch_query);
    $user_data = mysqli_fetch_assoc($fetch_result);
} else {
    echo "<script>window.location.href='users.php';</script>";
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
                                <h1 class="h4 text-gray-900 mb-4">Edit User</h1>
                            </div>
                            <form class="user" method="post">
                                <div class="form-group row">
                                    
                                    <!-- Full Name Field -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Full Name</label>
                                        <input type="text" name="full_name" value="<?php echo $user_data['full_name']; ?>" class="form-control form-control-user" required>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Email Address</label>
                                        <input type="email" name="email" value="<?php echo $user_data['email']; ?>" class="form-control form-control-user" required>
                                    </div>

                                    <!-- Password Field (Optional) -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Password (Leave blank to keep old)</label>
                                        <input type="password" name="password" class="form-control form-control-user" placeholder="Enter new password if changing">
                                    </div>

                                    <!-- Phone Field -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Phone Number</label>
                                        <input type="text" name="phone" value="<?php echo $user_data['phone']; ?>" class="form-control form-control-user">
                                    </div>

                                    <!-- Role Dropdown (Enum ke mutabik) -->
                                    <div class="col-sm-6 mb-3">
                                        <label class="small font-weight-bold">Role</label>
                                        <select name="role" class="form-control" style="border-radius: 10rem; height: calc(1.5em + .75rem + 2px); padding: 0.375rem 1rem;">
                                            <option value="customer" <?php echo ($user_data['role'] == 'customer') ? 'selected' : ''; ?>>Customer</option>
                                            <option value="admin" <?php echo ($user_data['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        </select>
                                    </div>
                                </div>

                                <button name="update_btn" class="btn btn-success btn-user btn-block">
                                    Update User
                                </button>
                                <a href="users.php" class="btn btn-secondary btn-user btn-block text-center">Cancel</a>
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
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    
    // Password Logic: Agar field khali nahi hai to hi password badlega
    if(!empty($_POST['password'])){
        $password = $_POST['password']; 
        $pass_query_part = ", `password` = '$password'";
    } else {
        $pass_query_part = ""; 
    }

    // Update Query database columns ke mutabik
    $update_query = "UPDATE `users` SET 
                    `full_name` = '$full_name', 
                    `email` = '$email', 
                    `phone` = '$phone', 
                    `role` = '$role' 
                    $pass_query_part 
                    WHERE `user_id` = '$id'";
    
    $update_result = mysqli_query($con, $update_query);

    if($update_result){
        echo "<script>alert('User updated successfully!'); window.location.href='users.php';</script>";
    } else {
        echo "<script>alert('Failed to update user: " . mysqli_error($con) . "');</script>";
    }
}
?>
