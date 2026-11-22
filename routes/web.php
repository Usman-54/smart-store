<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, ProductController, RegisterController, 
CartController, Cart_sidebarController,CheckoutController, PaymentController};

// Home page
Route::get('/smart-mall', [HomeController::class, 'index'])->name('home');

// Product resource routes
Route::resource('products', ProductController::class);

// Cart routes (unified)
Route::post('/cart/add', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [ProductController::class, 'viewCart'])->name('cart.view');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('detail_item');
Route::get('/cart/mini', [CartController::class, 'miniCart'])->name('cart.mini');
Route::post('/cart/update', [CartController::class, 'update']) ->name('cart.update.old');

// Route::get('/product/{id}', [ProductController::class, 'detail'])->name('detail_item');

// Collection routes
Route::get('/mens-collection', [ProductController::class, 'mensCollection'])->name('mens.collection');
Route::get('/womens-collection', [ProductController::class, 'womensCollection'])->name('womens.collection');
Route::get('/footwear', [ProductController::class, 'footwearCollection'])->name('footwear.collection');
Route::get('/watches', [ProductController::class, 'watchesCollection'])->name('watches.collection');

// Registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routes for cart_sidebar
Route::post('/cart/add', [Cart_sidebarController::class, 'add']) ->name('cart.add');

Route::post('/cart/{id}/update', [Cart_sidebarController::class, 'update']) ->whereNumber('id') ->name('cart.update');

Route::delete('/cart/{id}', [Cart_sidebarController::class, 'remove']) ->whereNumber('id') ->name('cart.remove');

Route::get('/cart', [Cart_sidebarController::class, 'view']) ->name('cart.view');

// for checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout');

Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
    ->name('checkout.place');

// Payment page Routes
Route::get('/payment', [PaymentController::class,'checkout',])->name('payments.checkout');

Route::post('/payment/initiate', [PaymentController::class, 'initiate',])->name('payments.initiate');

// confirmation order page route
Route::get('/orders/{order}/confirmation', [CheckoutController::class, 'confirmation'] )->name('orders.confirmation');