<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BrowsingHistoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/order/history', [CartController::class, 'history'])->name('order.history');
Route::get('/payment-processing', [CartController::class, 'paymentProcessing'])->name('payment.processing');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
Route::delete('/cart/remove/{item_id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::put('/cart/update/{item_id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/shopping_cart', [CartController::class, 'cart'])->name('cart');
Route::post('add_to_cart',[CartController::class,'addToCart'])->name('cart.add');

// Home Page, About Us, Contact Us, and Search Results Page (not done yet)
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/search', [SearchController::class, 'search'])->name('search.results');

// User Profile Page (not done yet)
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::middleware(['auth'])->get('/profile', [ProfileController::class, 'showProfile'])->name('profile');

// Browsing History Page (not done yet)
Route::get('/browsing-history', [BrowsingHistoryController::class, 'index'])->name('browsing.history');
Route::get('/item/{item}/view', [BrowsingHistoryController::class, 'addToHistory'])->name('browsing.add');

// Categories Page (not done yet)
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/filter', [CategoryController::class, 'filter'])->name('categories.filter');

// Item Detail Page
Route::get('/item/{id}', [ItemController::class, 'show'])->name('item-detail');

// Review Page (not done yet)
Route::get('/item/{id}/review', [ReviewController::class, 'create'])->name('review.create');
Route::post('item/{id}/review', [ReviewController::class, 'store'])->name('review.store');
// only logged-in users can access this route
//Route::post('/item/{id}/review', [ReviewController::class, 'store'])->middleware('auth')->name('review.store');

// Contact Page (not done yet)
Route::get('/contact', [ContactController::class, 'showContactForm'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

