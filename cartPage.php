<?php
    require "data/global/sessionData.php";
    require "db/dbconnection.php";
    require "controllers/OrderController.php";
    require "controllers/CartController.php";
    require "controllers/Router.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>commerce.za — Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f7f4; margin: 0; padding: 0; }
        .cart-wrapper { width: 90%; max-width: 650px; margin: 2rem auto; }
        h1 { font-size: 24px; color: #1a1a1a; margin-bottom: 1.5rem; }

        .wallet-badge {
            background: #fff;
            border: 1px solid #e8e6e1;
            border-radius: 10px;
            padding: .75rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 14px;
            color: #555;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .wallet-badge span:last-child {
            font-weight: 700;
            font-size: 15px;
            color: #1a1a1a;
        }

        .cart-item {
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
        .item-right { display: flex; align-items: center; gap: 1.25rem; }
        .item-price { font-size: 16px; font-weight: 700; color: #D85A30; }

        .btn-remove {
            background: none;
            border: 1px solid #e8e6e1;
            border-radius: 6px;
            padding: .3rem .65rem;
            font-size: 12px;
            color: #888;
            cursor: pointer;
        }
        .btn-remove:hover { border-color: #D85A30; color: #D85A30; }

        .cart-footer {
            background: #fff;
            border: 1px solid #e8e6e1;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .btn-checkout {
            background: #D85A30;
            color: #fff;
            border: none;
            padding: .75rem 1.5rem;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            width: 100%;
            margin-top: 1.25rem;
            text-align: center;
            display: block;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-checkout:hover { background: #993C1D; color: #fff; }

        .empty { color: #888; font-size: 15px; }
    </style>
</head>
<body>

<?php include "components/navbar.php"; ?>

<div class="cart-wrapper">
    <h1>Your Cart</h1>

    <!-- Wallet balance -->
    <?php
        $balanceStmt = $connection->prepare(
            "SELECT walletBalance FROM users WHERE id = :userId;"
        );
        $balanceStmt->execute([":userId" => $sessionUserId]);
        $walletRow = $balanceStmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="wallet-badge">
        <span>Wallet Balance</span>
        <span>R<?= number_format($walletRow["walletBalance"], 2) ?></span>
    </div>

    <?php if (empty($cartData)): ?>
        <p class="empty">Your cart is empty. <a href="/dashboard.php" style="color:#D85A30;">Browse listings</a></p>

    <?php else: ?>
        


        <?php
            $total = 0;
            $hasOutOfStock = false;
            foreach ($cartData as $item):
                $outOfStock = $item["quantity"] <= 0;
                if ($outOfStock) $hasOutOfStock = true;
                else $total += $item["price"];
        ?>
            <div class="cart-item" style="<?= $outOfStock ? 'opacity: 0.5;' : '' ?>">
                <div>
                    <div class="item-name"><?= htmlspecialchars($item["name"]) ?></div>
                    <div class="item-seller">Sold by <?= htmlspecialchars($item["sellerFirstName"] . " " . $item["sellerLastName"]) ?></div>
                    <?php if ($outOfStock): ?>
                        <div style="color: #D85A30; font-size: 12px; margin-top: 4px;">Out of stock — please remove this item</div>
                    <?php endif; ?>
                </div>
                <div class="item-right">
                    <?php if (!$outOfStock): ?>
                        <div class="item-price">R<?= number_format($item["price"], 2) ?></div>
                    <?php endif; ?>
                    <form method="POST" action="/formHandlers/removeFromCart.php">
                        <input type="hidden" name="productId" value="<?= $item["id"] ?>">
                        <button type="submit" class="btn-remove">Remove</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="cart-footer">
            <span>Total</span>
            <span>R<?= number_format($total, 2) ?></span>
        </div>

        <?php if (isset($_GET["error"]) && $_GET["error"] === "insufficient_balance"): ?>
            <div style="
                background: #fff0ed;
                border: 1px solid #D85A30;
                color: #D85A30;
                border-radius: 8px;
                padding: .65rem 1rem;
                font-size: 14px;
                margin-top: 1rem;
            ">
                Insufficient wallet balance to complete this purchase.
            </div>
        <?php endif; ?>

        <?php if ($hasOutOfStock): ?>
            <button class="btn-checkout" disabled style="opacity:0.5; cursor:not-allowed; background:#aaa;">
                Remove out of stock items to checkout
            </button>
        <?php else: ?>
            <a href="/checkoutPage.php" class="btn-checkout">Proceed to Checkout</a>
        <?php endif; ?>

    <?php endif; ?>
</div>

</body>
</html>