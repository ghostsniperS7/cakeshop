<?php
include('../dashboard/connect.php');
include("header.php");
// session_start();
if(!isset($_SESSION['id'])) {
    echo "<script>alert('Please login to proceed to checkout.'); window.location.href='login.php';</script>";
    exit();
}

// Fetch cart items for display
$cart_items = [];
$subtotal = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $query = "SELECT * FROM `products` WHERE `product_id` = '$product_id'";
        $result = mysqli_query($con, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $item_subtotal = $row['price'] * $quantity;
            $subtotal += $item_subtotal;
            $cart_items[] = [
                'product_id' => $product_id,
                'product_name' => $row['product_name'],
                'price' => $row['price'],
                'quantity' => $quantity,
                'subtotal' => $item_subtotal,
                'image' => $row['image']
            ];
        }
    }
}
$shipping = 5.00;
$grand_total = $subtotal + $shipping;
$cart_count = array_sum($_SESSION['cart'] ?? []);
?>
<style>
    /* Dark Theme form styling */
    .form-control, .custom-select {
        background-color: #1a1a1a !important;
        color: #fff !important;
        border: 1px solid #333 !important;
        border-radius: 8px !important;
        padding: 12px 16px !important;
        font-size: 15px !important;
        transition: all 0.3s ease !important;
    }
    .form-control:focus, .custom-select:focus {
        border-color: #E5BF4A !important;
        box-shadow: 0 0 0 3px rgba(229, 191, 74, 0.2) !important;
        outline: none !important;
    }
    .form-control::placeholder { color: #666 !important; }

    .text-muted { color: #aaa !important; }

    .checkout-card {
        background-color: #111 !important;
        border: 1px solid #222 !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
        padding: 30px !important;
    }

    .list-group-item {
        background-color: #111 !important;
        border: none !important;
        border-bottom: 1px solid #222 !important;
        padding: 15px 0 !important;
    }
    .list-group-item:last-child { border-bottom: none !important; }

    label { color: #ccc !important; font-size: 14px !important; font-weight: 500 !important; margin-bottom: 8px !important; display: block !important; }
    .text-theme { color: #E5BF4A !important; }
    .bg-theme { background-color: #E5BF4A !important; color: #0A0A0A !important; font-weight: bold !important; }

    .select-wrapper { position: relative; }
    .select-wrapper select { appearance: none; padding-right: 40px !important; }
    .select-wrapper::after {
        content: '\f107'; font-family: 'FontAwesome';
        position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
        color: #888; pointer-events: none;
    }

    .checkbox-wrapper, .radio-wrapper {
        display: flex; align-items: center; gap: 10px; cursor: pointer;
        padding: 12px; background: #1a1a1a; border: 1px solid #333; border-radius: 8px;
        margin-bottom: 10px; transition: all 0.3s ease;
    }
    .checkbox-wrapper:hover, .radio-wrapper:hover { border-color: #E5BF4A; background: #1f1f1f; }
    .checkbox-wrapper input, .radio-wrapper input { width: 18px; height: 18px; accent-color: #E5BF4A; cursor: pointer; }
    .checkbox-wrapper label, .radio-wrapper label { margin: 0; color: #ddd; font-size: 14px; cursor: pointer; flex: 1; }

    .section-divider { border-color: #333 !important; margin: 25px 0 !important; }

    .submit-btn {
        width: 100%; background: #E5BF4A; font-family: 'Poiret One', cursive; text-transform: uppercase;
        padding: 18px 30px; color: #0A0A0A !important; font-size: 16px !important; font-weight: 600 !important;
        border-radius: 8px; border: none; cursor: pointer; transition: all 0.3s ease;
        position: relative; overflow: hidden;
    }
    .submit-btn:hover { background: #d4aa3a; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(229, 191, 74, 0.4); }
    .submit-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

    /* Order Summary Sidebar */
    .order-summary {
        background: #111; border: 1px solid #222; border-radius: 12px; padding: 25px;
        position: sticky; top: 100px; height: fit-content;
    }
    .order-summary h4 { color: #E5BF4A; font-family: 'Poiret One', cursive; font-size: 22px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #333; }

    .cart-item { display: flex; gap: 12px; padding: 15px 0; border-bottom: 1px solid #222; }
    .cart-item:last-child { border-bottom: none; }
    .cart-item-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; flex-shrink: 0; }
    .cart-item-details { flex: 1; min-width: 0; }
    .cart-item-name { color: #fff; font-size: 14px; font-weight: 500; margin: 0 0 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .cart-item-meta { color: #888; font-size: 12px; margin: 0; }
    .cart-item-price { color: #E5BF4A; font-weight: 600; font-size: 14px; white-space: nowrap; }

    .summary-row { display: flex; justify-content: space-between; padding: 10px 0; color: #ccc; font-size: 14px; }
    .summary-row.total { border-top: 1px solid #333; margin-top: 10px; padding-top: 15px; color: #fff; font-size: 16px; font-weight: 600; }
    .summary-row .label { color: #aaa; }
    .summary-row .value { color: #fff; }
    .summary-row.total .label, .summary-row.total .value { color: #E5BF4A; }

    .promo-form { margin-top: 20px; padding-top: 20px; border-top: 1px solid #333; }
    .promo-input-group { display: flex; gap: 8px; }
    .promo-input-group .form-control { flex: 1; }
    .btn-promo { background: transparent; border: 1px solid #E5BF4A; color: #E5BF4A; padding: 12px 20px; border-radius: 8px; font-size: 13px; font-weight: 500; text-transform: uppercase; cursor: pointer; transition: all 0.3s ease; white-space: nowrap; }
    .btn-promo:hover { background: #E5BF4A; color: #0A0A0A; }

    .page-title { color: #E5BF4A; font-family: 'Poiret One', cursive; font-size: 36px; font-weight: 300; text-align: center; margin-bottom: 40px; }
    .section-title { color: #E5BF4A; font-family: 'Poiret One', cursive; font-size: 20px; margin-bottom: 20px; }

    .payment-methods { display: flex; flex-direction: column; gap: 10px; }
    .card-fields { display: none; animation: fadeIn 0.3s ease; }
    .card-fields.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    .form-control.is-invalid { border-color: #dc3545 !important; }
    .invalid-feedback { color: #dc3545; font-size: 13px; margin-top: 5px; display: none; }
    .form-control.is-invalid + .invalid-feedback { display: block; }

    @media (max-width: 767px) {
        .checkout-card { padding: 20px !important; }
        .order-summary { position: static; margin-top: 30px; }
        .page-title { font-size: 28px; }
    }
</style>

<main class="pt-4" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="container wow fadeIn">
        <h2 class="page-title">Secure Checkout</h2>

        <div class="row">
            <!-- Billing Form Column -->
            <div class="col-lg-8 mb-4">
                <div class="checkout-card">
                    <form method="post">
                        <!-- Contact Information -->
                        <h5 class="section-title">Contact Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First Name <span class="text-danger">*</span></label>
                                <input value="<?= htmlspecialchars($_SESSION['name'] ?? '') ?>" type="text" id="firstName" name="first_name" class="form-control" required autocomplete="given-name">
                                <div class="invalid-feedback">Please enter your first name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone <span class="text-danger">*</span></label>
                                <input value="<?= htmlspecialchars($_SESSION['phone'] ?? '') ?>" type="tel" id="phone" name="phone" class="form-control" required autocomplete="tel">
                                <div class="invalid-feedback">Please enter your phone number.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email (optional)</label>
                            <input value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" type="email" id="email" name="email" class="form-control" placeholder="youremail@example.com" autocomplete="email">
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>

                        <hr class="section-divider">

                        <!-- Shipping Address -->
                        <h5 class="section-title">Shipping Address</h5>
                        <div class="mb-3">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="1234 Main St" required autocomplete="street-address">
                            <div class="invalid-feedback">Please enter your address.</div>
                        </div>
                        <div class="mb-3">
                            <label for="address2">Address 2 (optional)</label>
                            <input type="text" id="address2" name="address2" class="form-control" placeholder="Apartment, suite, unit, etc." autocomplete="address-line2">
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="country">Country <span class="text-danger">*</span></label>
                                <div>
                                    <select class="form-control custom-select" id="country" name="country" required>
                                        <option value="">Choose...</option>
                                        <option value="United States" selected>United States</option>
                                        <option value="Canada">Canada</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="France">France</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">Please select a country.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state">State <span class="text-danger">*</span></label>
                                <div>
                                    <select class="form-control custom-select" id="state" name="state" required>
                                        <option value="">Choose...</option>
                                        <option value="California">California</option>
                                        <option value="New York">New York</option>
                                        <option value="Texas">Texas</option>
                                        <option value="Florida">Florida</option>
                                        <option value="Illinois">Illinois</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">Please select a state.</div>
                            </div>
                            <!-- <div class="col-md-4 mb-3">
                                <label for="zip">ZIP Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="90210" required autocomplete="postal-code" pattern="[0-9]{5}(-[0-9]{4})?">
                                <div class="invalid-feedback">Please enter a valid ZIP code.</div>
                            </div> -->
                        </div>

                        <hr class="section-divider">

                        <!-- Address Options -->
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="same_address" name="same_address" value="1">
                            <label for="same_address">Shipping address is the same as my billing address</label>
                        </div>
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="save_info" name="save_info" value="1">
                            <label for="save_info">Save this information for next time</label>
                        </div>

                        <hr class="section-divider">

                        <!-- Payment Method -->
                        <h5 class="section-title">Payment Method</h5>
                        <div class="payment-methods">
                            <label class="radio-wrapper">
                                <input type="radio" name="payment_method" value="credit" name="payment_method" id="payment_credit" required>
                                <span>Credit Card</span>
                            </label>
                            <label class="radio-wrapper">
                                <input type="radio" name="payment_method" value="debit" name="payment_method" id="payment_debit" required>
                                <span>Debit Card</span>
                            </label>
                            <label class="radio-wrapper">
                                <input type="radio" name="payment_method" value="cod" name="payment_method" id="payment_cod" required>
                                <span>Cash on Delivery</span>
                            </label>
                        </div>

                        <!-- Card Details (shown for credit/debit) -->
                        <div id="cardFields" class="card-fields mt-3">
                            <hr class="section-divider">
                            <h5 class="section-title">Card Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="card_name">Name on Card <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="card_name" name="card_name" placeholder="John Doe" autocomplete="cc-name">
                                    <div class="invalid-feedback">Name on card is required.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="card_number">Card Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" autocomplete="cc-number" inputmode="numeric" maxlength="19" pattern="[0-9\s]{13,19}">
                                    <div class="invalid-feedback">Valid card number is required.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="card_expiry">Expiration <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="card_expiry" name="card_expiry" placeholder="MM/YY" autocomplete="cc-exp" maxlength="5" pattern="(0[1-9]|1[0-2])\/[0-9]{2}">
                                    <div class="invalid-feedback">Valid expiration (MM/YY) required.</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="card_cvv">CVV <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="card_cvv" name="card_cvv" placeholder="123" autocomplete="cc-csc" inputmode="numeric" maxlength="4" pattern="[0-9]{3,4}">
                                    <div class="invalid-feedback">Valid CVV required.</div>
                                </div>
                            </div>
                        </div>

                        <hr class="section-divider">
                        <button type="submit" name="btn" class="submit-btn" >
                            <i class="fas fa-lock mr-2"></i>Complete Order - $<?= number_format($grand_total, 2) ?>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary Column -->
            <div class="col-lg-4 mb-4">
                <div class="order-summary">
                    <h4>Your Order <span class="badge badge-pill bg-theme ml-2"><?= $cart_count ?></span></h4>
                    <?php if (!empty($cart_items)): ?>
                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-item">
                                <img src="../dashboard/img/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="cart-item-img">
                                <div class="cart-item-details">
                                    <h6 class="cart-item-name"><?= htmlspecialchars($item['product_name']) ?></h6>
                                    <p class="cart-item-meta">Qty: <?= $item['quantity'] ?> × $<?= number_format($item['price'], 2) ?></p>
                                </div>
                                <span class="cart-item-price">$<?= number_format($item['subtotal'], 2) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted py-4">Your cart is empty</p>
                    <?php endif; ?>
                    <div class="summary-row">
                        <span class="label">Subtotal</span>
                        <span class="value">$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Shipping</span>
                        <span class="value">$<?= number_format($shipping, 2) ?></span>
                    </div>
                    <div class="summary-row total">
                        <span class="label">Total</span>
                        <span class="value">$<?= number_format($grand_total, 2) ?></span>
                    </div>
                    <!-- Promo Code -->
                    <div class="promo-form">
                        <form id="promoForm" class="promo-input-group">
                            <input type="text" class="form-control" placeholder="Promo code" id="promoCode" name="promo_code" autocomplete="off">
                            <button type="button" class="btn-promo" id="applyPromo">Redeem</button>
                        </form>
                        <small id="promoMessage" class="text-muted d-block mt-2"></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitBtn');
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const cardFields = document.getElementById('cardFields');
    const cardInputs = cardFields.querySelectorAll('input');
    const promoCode = document.getElementById('promoCode');
    const promoMessage = document.getElementById('promoMessage');
    const applyPromo = document.getElementById('applyPromo');

    // Toggle card fields based on payment method
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'credit' || this.value === 'debit') {
                cardFields.classList.add('active');
                cardInputs.forEach(input => input.required = true);
            } else {
                cardFields.classList.remove('active');
                cardInputs.forEach(input => input.required = false);
            }
        });
    });

    // Format card number with spaces
    document.getElementById('card_number')?.addEventListener('input', function() {
        let value = this.value.replace(/\s/g, '').replace(/\D/g, '');
        this.value = value.replace(/(\d{4})/g, '$1 ').trim().substring(0, 19);
    });

    // Format expiry date
    document.getElementById('card_expiry')?.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length >= 2) value = value.substring(0, 2) + '/' + value.substring(2, 4);
        this.value = value;
    });

    // Format CVV & phone
    document.getElementById('card_cvv')?.addEventListener('input', function() { this.value = this.value.replace(/\D/g, ''); });
    document.getElementById('phone')?.addEventListener('input', function() { this.value = this.value.replace(/\D/g, '').substring(0, 10); });

    // Form validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        form.querySelectorAll('[required]').forEach(field => {
            if (!field.value.trim()) { field.classList.add('is-invalid'); isValid = false; }
            else { field.classList.remove('is-invalid'); }
        });
        if (!isValid) { e.preventDefault(); form.querySelector('.is-invalid')?.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
        else { submitBtn.classList.add('loading'); submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...'; }
    });

    // Clear validation on input
    form.querySelectorAll('input, select').forEach(field => {
        field.addEventListener('input', () => field.classList.remove('is-invalid'));
        field.addEventListener('change', () => field.classList.remove('is-invalid'));
    });

    // Promo code
    applyPromo.addEventListener('click', function() {
        const code = promoCode.value.trim().toUpperCase();
        const promos = { 'SAVE10': 10, 'WELCOME': 5, 'CAKE20': 20 };
        if (!code) { promoMessage.textContent = 'Enter a promo code'; promoMessage.style.color = '#dc3545'; }
        else if (promos[code]) { promoMessage.textContent = 'Code "' + code + '" applied!'; promoMessage.style.color = '#28a745'; }
        else { promoMessage.textContent = 'Invalid promo code'; promoMessage.style.color = '#dc3545'; }
    });
});
</script>

    <?php
    include('footer.php');
    if(isset($_POST['btn'])){
        $user_id = $_SESSION['id'];
        $address = $_POST['address'] . ', ' . $_POST['address2'] . ', ' . $_POST['state'] . ', ' . $_POST['country'];
        $payment_method = $_POST['payment_method'];
        // $total_amount = $_POST['total_amount'];

        $query = "INSERT INTO `orders`(`user_id`, `total_amount`, `order_status`, `payment_status`,`address`, `payment_method`) VALUES ('$user_id', '$grand_total', 'Pending', 'Pending', '$address', '$payment_method')";
        $result = mysqli_query($con, $query);

        if ($result) {
    echo "<script>alert('Order placed successfully!');</script>";
} else {
    echo "<script>alert('Error: " . $query . "<br>" . $con->error . "');</script>";
}

    }
    ?>