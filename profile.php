<?php

    /* TO-DO: Include header.php
            Hint: header.php is inside the includes folder and already connects to the database
    */
    require_once __DIR__ . '/includes/header.php';



            
	require_login($logged_in);                              // Redirect user if not logged in
	$username = $_SESSION['username'];                      // Retrieve the username from the session data
    $custID   = $_SESSION['custID'];                        // Retrieve the custID from the session data



    /* TO-DO: Create a function that retrieves ALL order information for the logged-in user 

              Your function should:
                1. Query the appropriate tables to retrieve:
                    - order information
                    - toy name
                    - toy image
                    Make sure to sort the results in descending order (most recent first)
                2. Execute the SQL query using the pdo() helper function and fetch the results
                3. Return orders for the logged-in user only
	*/
    function get_orders(PDO $pdo, int $custID) {
        $sql = "SELECT orders.*, toy.name AS toy_name, toy.img_src
                FROM orders
                JOIN toy
                ON orders.toyID = toy.toyID
                WHERE orders.custID = :custID
                ORDER BY orders.date_ordered DESC;";

        $orders = pdo($pdo, $sql, ['custID' => $custID])->fetchAll();
        return $orders;
    }



    /* TO-DO: Call function to retrieve orders for the logged-in user */
    $orders = get_orders($pdo, $custID);

?>

<main class="container profile-page">

    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>

    <!-- TO-DO: Check if no orders were returned from the database -->
    <?php if (empty($orders)): ?>
        <div class="no-orders">
            <p>You have no orders yet.</p>
        </div>
    <?php else: ?>

    <!-- TO-DO: Otherwise (order data was returned) -->
    <?php endif; ?>
        <div class="orders-container">

            <!-- TO-DO: Loop through each order returned from the database -->
            <?php foreach ($orders as $order): ?>

                <div class="order-card">

                    <!-- TO-DO: Display the toy image and update the alt text to the toy name -->
                    <img src="<?= $order['img_src'] ?>" alt="<?= $order['toy_name'] ?>">

                    <div class="order-info">

                        <!-- TO-DO: Display the order number -->
                        <p><strong>Order Number:</strong> <?= $order['orderID'] ?></p>

                        <!-- TO-DO: Display the toy name -->
                        <p><strong>Toy:</strong> <?= $order['toy_name'] ?></p>

                        <!-- TO-DO: Display the order quantity -->
                        <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>

                        <!-- TO-DO: Display the date ordered -->
                        <p><strong>Date Ordered:</strong> <?= $order['date_ordered'] ?></p>

                        <!-- TO-DO: Display the delivery address -->
                        <p><strong>Delivery Address:</strong> <?= $order['deliv_addr'] ?></p>

                        <!-- TO-DO: Display the delivery date
                                    Hint: If the delivery date is NULL, use the null-coalescing operator to display a placeholder message like "Pending"
                         -->
                        <p><strong>Delivery Date:</strong> <?= $order['date_deliv'] ?? 'Pending' ?></p>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php ?>

</main>

<?php include 'includes/footer.php'; ?>