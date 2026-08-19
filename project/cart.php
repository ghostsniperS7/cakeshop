<?php
include('../dashboard/connect.php');
include('header.php');
?>
<style>
    .cart-item {
        border-bottom: 1px solid #ddd;
        padding: 15px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .product-img {
        max-width: 60px;
        object-fit: cover;
        border-radius: 5px;
    }

    .cart-summary {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .cart-summary .total-price {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .btn-checkout {
        background-color: #333;
        color: white;
        border-radius: 25px;
    }

    .btn-checkout:hover {
        background-color: #444;
    }

    .cart-summary .btn {
        width: 100%;
        padding: 12px;
    }

    .cart-summary .btn:disabled {
        background-color: #ddd;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <!-- Shopping Cart Items -->
        <div class="col-md-8">
            <h3 class="text-white">Your Cart</h3>

            <?php
            $total = 0;
            $subtotal = 0;
            if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $query = "SELECT * FROM `products` WHERE `product_id` = '$id'";
        $result = mysqli_query($con, $query);
        if($row = mysqli_fetch_assoc($result)){
            $item_subtotal = $row['price'] * $quantity;
            $total += $item_subtotal;
            ?>

            <!-- Cart Item 1 -->
<div class="cart-item">
    <div class="d-flex align-items-center">
        <img src="../dashboard/img/<?php echo $row['image']; ?>" alt="Product" class="product-img me-3">
        <div>
            <h6 class="text-white mb-1"><?php echo $row['product_name']; ?></h6>
            <p class="mb-0 text-white-50 small"><?php echo $quantity; ?> item(s)</p>
        </div>
    </div>
    <span class="text-white fw-bold">$<?php echo number_format($item_subtotal, 2); ?></span>
    <a href="increase.php?id=<?php echo $row['product_id']; ?>" class="btn btn-danger">+</a>
    <a href="decrease.php?id=<?php echo $row['product_id']; ?>" class="btn btn-danger">-</a>
    <a href="remove.php?removeid=<?php echo $row['product_id']; ?>" class="btn btn-danger">Remove</a>
</div>
                    <?php
        }
            }
}
?>
        </div>




        <!-- Cart Summary -->
        <div class="col-md-4">
            <div class="cart-summary">
                <h5>Summary</h5>
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>Shipping:</span>
                        <span>$5.00</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="total-price">Total:</span>
                        <span class="total-price">$<?php echo number_format($total + 5.00, 2); ?></span>
                    </li>
                </ul>

                <?php
                if(isset($_SESSION['id'])) {
                    echo '<a href="checkout.php" class="btn btn-checkout">Proceed to Checkout</a>';
                } else {
                    echo '<a href="login.php" class="btn btn-checkout" disabled>login to Checkout</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>