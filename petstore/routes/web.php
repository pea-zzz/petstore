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
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRegisterController;
use Illuminate\Support\Facades\Gate;


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

// Home Page, About Us, Contact Us, and Search Results Page
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/search', [SearchController::class, 'search'])->name('search.results');
Route::get('/contact', [ContactController::class, 'showContactForm'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// User Profile with view page, edit and update functionalities
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Browsing History Page
Route::get('/history', [BrowsingHistoryController::class, 'index'])->name('browsing.history');
Route::post('/history/store/{itemId}', [BrowsingHistoryController::class, 'store'])->name('browsing.history.store');
Route::post('/history/clear', [BrowsingHistoryController::class, 'clear'])->name('browsing.history.clear');

// Our Products Page (Categories Page)
//Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
//Route::get('/categories/filter', [CategoryController::class, 'filter'])->name('categories.filter');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Item Detail Page
Route::get('/items/{id}', [ItemController::class, 'show'])->name('items.show');

// Review Page
Route::get('/items/{id}/review', [ReviewController::class, 'create'])->name('review.create');
Route::post('items/{id}/review', [ReviewController::class, 'store'])->name('review.store');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register/admin', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/register/admin', [AdminRegisterController::class, 'registerAdmin']);
Route::middleware('can:access-admin-dashboard')->get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/', function () {
    return view('welcome');
});