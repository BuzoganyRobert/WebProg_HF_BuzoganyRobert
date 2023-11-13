<?php
session_start();

// Initialize the cart as an empty array if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the cart cookie is set and decode it
if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);
} else {
    $cart = [];
}

// Check if the form is submitted for removing from the cart
if (isset($_POST['remove_from_cart'])) {
    $productId = $_POST['product_id'];

    // Check if the product is in the cart and its quantity is greater than 1
    if (isset($_SESSION['cart'][$productId])) {
        if ($_SESSION['cart'][$productId]['quantity'] > 1) {
            $_SESSION['cart'][$productId]['quantity']--;
        } else {
            unset($_SESSION['cart'][$productId]);
        }
    }

    // Store the updated cart in a cookie
    setcookie('cart', json_encode($_SESSION['cart']), time() + 3600 * 24 * 7 * 7); // Cookie expires in 1 week
}

if (isset($_POST['update_quantity'])) {
    foreach ($_SESSION['cart'] as $productId => $item) {
        $updateKeyQuantity = "new_quantity_$productId";
        if (isset($_POST[$updateKeyQuantity])) {
            $newQuantity = filter_var($_POST[$updateKeyQuantity], FILTER_VALIDATE_INT);
            if ($newQuantity !== false && $newQuantity > 0) {
                $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
            }
        }
    }
    setcookie('cart', json_encode($_SESSION['cart']), time() + 3600 * 24 * 7 * 7);
}

// Calculate the total price of the cart
$totalPrice = 0;
foreach ($_SESSION['cart'] as $productId => $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>
<h1>Shopping Cart</h1>

<ul>
    <?php foreach ($_SESSION['cart'] as $productId => $item) { ?>
        <li>
            <form method="post">
                <?php echo $item['name']; ?> - $<?php echo $item['price']; ?>
                (Quantity: <?php echo $item['quantity']; ?>)
                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                <input type="submit" name="remove_from_cart" value="Remove from Cart">
                <input type="number" name="new_quantity_<?php echo $productId; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                <input type="submit" name="update_quantity" value="Update Quantity">
            </form>
        </li>
    <?php } ?>
</ul>

</body>
</html>
