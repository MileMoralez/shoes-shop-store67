<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
// បញ្ជាក់៖ បើ OrderController របស់អ្នកមិននៅក្នុង Folder Admin ទេ សូមប្តូរទៅ App\Http\Controllers\OrderController វិញ
use App\Http\Controllers\Admin\OrderController;


/*
|--------------------------------------------------------------------------
| Public Routes (ទំព័រសម្រាប់អតិថិជនទូទៅ)
|--------------------------------------------------------------------------
*/

// ទំព័រដើម (Homepage)
Route::get('/', function () {
    $categories = Category::all(); 
    return view('index', compact('categories')); 
});

// ទំព័រ Categories ផ្សេងៗ
Route::get('/women', function () {
    $products = Product::where('category', 'Women')->latest()->get();
    return view('category.women', compact('products'));
});
Route::get('/men', function () { return view('category.men'); });
Route::get('/accessories', function () { return view('category.accessories'); });
Route::get('/sport', function () { return view('category.sport'); });
Route::get('/shoes', function () { return view('category.shoes'); });
Route::get('/anime', function () { return view('category.anime'); });

// Dynamic Category Route (ទំព័រ Category ស្វ័យប្រវត្តិ)
Route::get('/category/{slug}', function ($slug) {
    if (view()->exists('category.' . $slug)) {
        $products = Product::all(); 
        return view('category.' . $slug, compact('products'));
    }
    abort(404);
});

// ទំព័រលម្អិតរបស់ផលិតផលនីមួយៗ (Product Detail)
Route::get('/product/{slug}', function ($slug) {
    $product = Product::where('slug', $slug)->firstOrFail();
    $similarProducts = Product::where('id', '!=', $product->id)->inRandomOrder()->take(4)->get();
    return view('product.show', compact('product', 'similarProducts'));
});


/*
|--------------------------------------------------------------------------
| Cart & Checkout Routes (កន្ត្រកទំនិញ និងទូទាត់ប្រាក់)
|--------------------------------------------------------------------------
*/
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CartController::class, 'placeOrder']);
// ត្រូវប្រាកដថា Action របស់ Form រត់មកចំមុខងារថ្មីនេះ
Route::post('/aba/checkout', [CartController::class, 'payWithAbaPayway'])->name('aba.checkout');


/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes (ទំព័រសម្រាប់អ្នកគ្រប់គ្រង)
|--------------------------------------------------------------------------
*/
// ប្រើប្រាស់ prefix('admin') ដើម្បីកុំឲ្យសរសេរពាក្យ /admin/ ជាន់គ្នាផ្តេសផ្តាស
Route::prefix('admin')->group(function () {
    
    // --- ផ្នែក Orders ---
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // --- ផ្នែក Products ---
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    // --- ផ្នែក Categories ---
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/create', [CategoryController::class, 'create']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    
});
Route::post('/bakong-khqr-checkout', [\App\Http\Controllers\CartController::class, 'payWithBakong'])->name('bakong.checkout');
Route::post('/verify-transaction', [App\Http\Controllers\CartController::class, 'verifyTransaction']);
Route::get('/clear-cart', function() { session()->forget('cart'); return 'កន្ត្រកត្រូវបានសម្អាតជោគជ័យ! សូមត្រឡប់ទៅទំព័រដើមវិញ'; });
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'kh'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch'); // ឈ្មោះនេះហើយដែលវាទាមទារ
use Illuminate\Support\Facades\Session;

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'kh'])) {
        // 💡 ប្រើប្រព័ន្ធ Session ផ្ទាល់របស់ PHP/Laravel ហ្មង ដើម្បីកុំឱ្យវាគាំង
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');