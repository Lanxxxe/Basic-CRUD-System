<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('header.php'); 
    
?>

<body>
    <?php include('navbar.php'); 
    ?>
    <div class="container">
        <h1 class="page-header text-center">ORDER  </h1>
        <form action="" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" value="<?php if (isset($_GET['search'])) {echo htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');} ?>" placeholder="search">
                <button class="btn btn-primary mt-4" type="submit">Search</button>
            </div>
        </form>

        <form id="orderForm" method="POST" action="purchase.php">
            <table class="table">
                <thead>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $iterate = 0;
                    if (isset($_GET['search'])) {
                        $SearchValue = $_GET['search'];

                        // Prepared statement
                        $statement = $conn->prepare("SELECT * FROM `product` WHERE ProductName LIKE ?");
                        $search = "%" . $SearchValue . "%"; // Adding wildcards
                        $statement->bind_param("s", $search); // "s" means the database expects a string
                        $statement->execute();
                        $result = $statement->get_result();

                        // Display the results
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo isset($row['ProductID']) ? $row['ProductID'] : ''; ?></td>
                                <td><?php echo isset($row['ProductName']) ? $row['ProductName'] : ''; ?></td>
                                <td class="">&#x20B1;<?php echo isset($row['Price']) ? number_format($row['Price'], 2) : ''; ?></td>
                                <td><input type="text" class="form-control quantity" data-productid="<?php echo $row['ProductID']; ?>" data-productname="<?php echo $row['ProductName']; ?>" data-price="<?php echo $row['Price']; ?>"></td>
                                <td><button class="btn btn-primary add-to-cart" type="button" data-productid="<?php echo $row['ProductID']; ?>">Add to cart</button></td>
                            </tr>
                        <?php
                            $iterate++;
                        }
                    } else {
                        $statement = $conn->prepare("SELECT * FROM `product`");
                        $statement->execute();
                        $result = $statement->get_result();

                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo isset($row['ProductID']) ? $row['ProductID'] : ''; ?></td>
                                <td><?php echo isset($row['ProductName']) ? $row['ProductName'] : ''; ?></td>
                                <td class="">&#x20B1;<?php echo isset($row['Price']) ? number_format($row['Price'], 2) : ''; ?></td>
                                <td><input type="text" class="form-control quantity" data-productid="<?php echo $row['ProductID']; ?>" data-productname="<?php echo $row['ProductName']; ?>" data-price="<?php echo $row['Price']; ?>"></td>
                                <td><button class="btn btn-primary add-to-cart" type="button" data-productid="<?php echo $row['ProductID']; ?>">Add to cart</button></td>
                            </tr>
                    <?php
                            $iterate++;
                        }
                    }
                    ?>
                </tbody>
            </table>

            <div id="orders-summary-container">
                <h3>Order Summary:</h3>

                <div class="d-flex flex-column">
                    <div id="items">
                        <table class="table table-striped">
                            <thead>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Subtotal</th>
                            </thead>
                            <tbody id="items-info">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

                <h3>Order Information:</h3>
            <div class="row">
                <div class="col-md-1">
                    <select class="form-select" name="TransactionType" id="">
                        <option value="Delivery">Delivery</option>
                        <option value="Pick-Up">Pick-Up</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="TransactionDate" class="form-control" required>
                </div>    
                <div class="col-md-3">
                    <input type="text" name="CustomerName" class="form-control" placeholder="Customer Name" required>
                </div>
                <div class="col-md-2" style="margin-left:-20px;">
                    <button type="submit" class="btn btn-primary"><span class="bi bi-cart4"></span> Place Order</button>
                </div>
            </div>

            <!-- Hidden input to store the cart data -->
            <input type="hidden" name="cart_data" id="cartData">
        </form>
    </div>

    <script type="text/javascript">
    // Initialize the cart from localStorage if available
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    // Function to update the cart items display table
    function updateCartTable() {
        let itemsInfo = document.getElementById('items-info');
        itemsInfo.innerHTML = '';

        let totalCartValue = 0;

        for (const productId in cart) {
            const item = cart[productId];
            const total = item.price * item.quantity;
            totalCartValue += total;

            let row = 
                `<tr id="item-${productId}">
                <td>${item.productName}</td>
                <td>P ${item.price.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>P ${total.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm delete-item" data-productid="${productId}">Remove</button></td>
            </tr>`;
            itemsInfo.innerHTML += row;
        }

        // Update the total cart value display
        document.getElementById('total-cart-value').innerText = totalCartValue.toFixed(2);
    }

    // Function to save order details to localStorage
    function saveOrderDetails() {
        const newOrder = {
            dateOfPurchase: document.querySelector('input[name="TransactionDate"]').value,
            customerName: document.querySelector('input[name="CustomerName"]').value,
            transactionType: document.querySelector('select[name="TransactionType"]').value,
            adminFirstName: '<?php echo $_SESSION['username']; ?>',
            cart: cart
        };

        // Retrieve existing order details
        let orderDetails = JSON.parse(localStorage.getItem('orderDetails')) || [];

        // Append the new order
        orderDetails.push(newOrder);

        // Save back to localStorage
        localStorage.setItem('orderDetails', JSON.stringify(orderDetails));
    }

    // Function to update the hidden input field with the cart data and save to localStorage
    function updateCartData() {
        localStorage.setItem('cart', JSON.stringify(cart));
        document.getElementById('cartData').value = JSON.stringify(cart);
    }

    // Event listener for 'Add to cart' buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-productid');
            const quantityInput = document.querySelector(`.quantity[data-productid="${productId}"]`);
            const quantity = parseInt(quantityInput.value);
            const productName = quantityInput.getAttribute('data-productname');
            const price = parseFloat(quantityInput.getAttribute('data-price'));

            if (quantity && quantity > 0) {
                cart[productId] = { productName, price, quantity };
                quantityInput.value = '';
                updateCartData();
                updateCartTable();
            } else {
                alert('Please enter a valid quantity');
            }
        });
    });

    // Event listener for the 'Place Order' button
    document.getElementById('orderForm').addEventListener('submit', function() {
        updateCartData(); // Ensure cart data is up-to-date before submitting
        saveOrderDetails(); // Save order details to localStorage
    });

    // Event listener for delete buttons
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-item')) {
            const productId = event.target.getAttribute('data-productid');
            delete cart[productId];
            updateCartData();
            updateCartTable();
        }
    });

    // Call updateCartTable to display cart items on page load
    updateCartTable();
</script>
    
</body>

</html>