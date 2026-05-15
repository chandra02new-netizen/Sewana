<?php

return [
  [
    'title' => 'Produk',
    'icon'  => 'bi bi-box-seam',
    'route' => 'products.index',
    'roles' => ['admin', 'staff'], // siapa aja yang bisa akses
  ],
  [
    'title' => 'Pengguna',
    'icon'  => 'bi bi-people',
    'route' => 'users.index',
    'roles' => ['admin'], // hanya admin
  ],

];
