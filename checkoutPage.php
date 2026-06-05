<?php
    require "data/global/sessionData.php";
    require "db/dbconnection.php";
    require "controllers/CartController.php";
    require "controllers/Router.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dotlinka — Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f7f4; margin: 0; padding: 0; }
        .checkout { width: 90%; max-width: 600px; margin: 2rem auto; }
        h1 { font-size: 24px; color: #1a1a1a; margin-bottom: 1.5rem; }
        .item {
            background: #fff;
            border: 1px solid #e8e6e1;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: .75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .item-name { font-size: 15px; font-weight: 600; color: #1a1a1a; }
        .item-seller { font-size: 12px; color: #888; margin-top: 2px; }
        .item-price { font-size: 16px; font-weight: 700; color: #D85A30; }
        .total {
            background: #fff;
            border: 1px solid #e8e6e1;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            font-size: 16px;
            font-weight: 700;
        }
        .btn-confirm {
            background: #D85A30;
            color: #fff;
            border: none;
            padding: .75rem 1.5rem;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            width: 100%;
            margin-top: 1.25rem;
        }
        .btn-confirm:hover { background: #993C1D; }
        .empty { color: #888; font-size: 15px; }
    </style>
</head>
<body>
  <?php include 'components/loading.php'; ?>

<?php include "components/navbar.php"; ?>

<div class="checkout">
    <h1>Checkout</h1>

    <?php if (empty($checkoutCartData)): ?>
        <p class="empty">Your cart is empty.</p>
    <?php else: ?>

        <?php
            $total = 0;
            foreach ($checkoutCartData as $item):
                $total += $item["price"];
        ?>
            <div class="item">
                <div>
                    <div class="item-name"><?= htmlspecialchars($item["name"]) ?></div>
                    <div class="item-seller">Sold by <?= htmlspecialchars($item["sellerFirstName"] . " " . $item["sellerLastName"]) ?></div>
                </div>
                <div class="item-price">R<?= number_format($item["price"], 2) ?></div>
            </div>
        <?php endforeach; ?>

        <div class="total">
            <span>Total</span>
            <span>R<?= number_format($total, 2) ?></span>
        </div>

        <form method="POST" action="/formHandlers/processCheckout.php">
            <button type="submit" class="btn-confirm">Confirm Purchase</button>
        </form>

    <?php endif; ?>
</div>

</body>
</html>