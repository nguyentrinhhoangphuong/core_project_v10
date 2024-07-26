<?php
return [
  'cookie' => [
    'name' => env('CART_COOKIE_NAME', 'cart'),
    'expiration' => 7 * 24 * 60, // One week
  ],
];
