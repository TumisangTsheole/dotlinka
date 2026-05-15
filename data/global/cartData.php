<?php

include "../../models/cart.php";
include "../../models/product.php";

$carts = [
    new Cart(
        12345, 
        [
            new Product(
                12345, 
                "Nike Shoes",
                "Brand New Nike Shoes, Not Worn",
                850.00,
                new User(
                    100200300,
                    "Tumisang",
                    "Tsheole"
                ),
                1,
                "Clothing"
            )
        ]
        )
];