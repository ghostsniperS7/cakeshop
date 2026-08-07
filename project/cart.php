<style>.cart-item {
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
}</style>

<div class="container mt-5">
    <div class="row">
        <!-- Shopping Cart Items -->
        <div class="col-md-8">
            <h3 class="text-white">Your Cart</h3>

            <!-- Cart Item 1 -->
            <div class="cart-item">
                <div class="d-flex">
                    <img src="https://via.placeholder.com/60" alt="Product" class="product-img me-3">
                    <div>
                        <h6 class="text-white">Product Name 1</h6>
                        <p class="mb-0 text-white">1 item</p>
                    </div>
                </div>
                <span class="text-white">$25.99</span>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-md-4">
            <div class="cart-summary">
                <h5>Summary</h5>
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>$45.98</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>Shipping:</span>
                        <span>$5.00</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="total-price">Total:</span>
                        <span class="total-price">$50.98</span>
                    </li>
                </ul>
                <button class="btn btn-checkout" disabled>Proceed to Checkout</button>
            </div>
        </div>
    </div>
</div>