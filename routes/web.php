<?php

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\UMKM;
use App\Models\Produk;
use App\Models\Homestay;
use App\Models\DestinasiPariwisata;
use App\Http\Middleware\CountVisits;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UMKMController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomestayController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\FrontendHomeController;
use App\Http\Controllers\FrontendPostController;
use App\Http\Controllers\FrontendUMKMController;
use App\Http\Controllers\FrontendVideoController;
use App\Http\Controllers\FrontendKontakController;
use App\Http\Controllers\FrontendProdukController;
use App\Http\Controllers\FrontendHomestayController;
use App\Http\Controllers\FrontendDestinasiController;
use App\Http\Controllers\DestinasiPariwisataController;
use App\Http\Controllers\PostENController;
use App\Http\Controllers\VideoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/post', function () {
    return view('posts',['posts'=>Post::all()]);
});

Route::get('/', [FrontendHomeController::class, 'index'])->name('home');

// Route::post('/booking', [BookingController::class, 'formBooking']);
// Route::put('/booking/send', [BookingController::class, 'booking']);


Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [DashbaordController::class, 'index']);
    Route::resource('/admin/category', CategoryController::class);
    Route::resource('/admin/user', UserController::class);
    Route::resource('/admin/destinasipariwisata', DestinasiPariwisataController::class);
    Route::resource('/admin/homestay', HomestayController::class);
    Route::resource('/admin/provider', ProviderController::class);
    Route::resource('/admin/post', PostController::class);
    Route::resource('/admin/video', VideoController::class);

    /* Route::resource('/admin/umkm', UMKMController::class);
    Route::get('/admin/produk/catcreate', [ProdukController::class, 'catcreate'])->name('produk.catcreate');
    Route::post('/admin/produk/strcreate', [ProdukController::class, 'strcreate'])->name('produk.strcreate'); */
    Route::resource('/admin/produk', ProdukController::class);

    Route::put('/admin/users/{id}', [UserController::class, 'update']);
    Route::get('updateStatus/{id}', [UserController::class, 'updateStatus']);
    Route::delete('/media/{id}', [AssetController::class, 'destroy']);
    Route::delete('/assets/{id}', [AssetController::class, 'destroy'])->name('assets.destroy');
    Route::delete('/postEN/{id}', [PostENController::class, 'destroyEN'])->name('postEN.destroy');
    // Route::get('/admin/booking/{id}/approve', [BookingController::class, 'approve']);
    Route::put('/admin/post/toggleStatus/{id}', [PostController::class, 'toggleStatus'])->name('post.toggleStatus');
    Route::put('/admin/video/toggleHightlight/{id}', [VideoController::class, 'toggleHighlight'])->name('video.toggleHighlight');

    Route::get('sign-out', [SigninController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('sign-in', [SigninController::class, 'index'])->name('login');
    Route::post('proses', [SigninController::class, 'authentication'])->name('proses-signin');

    Route::get('/forgot-password', function () {
        return view('admin.ForgotPassword');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->input('email'))->first();

        if ($user && $user->status != 'active') {
            return view('admin.disabled');
        }
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])->with('status','Reset password berhasil dikirimkan ke Email Anda. Silahkan cek dibagian Email, termasuk spam.')
            : back()->withErrors(['email' => __($status)])->with('status','Email anda belum terdaftar');
    })->name('password.email');

    Route::get('/reset-password/{token}', function (string $token, Request $request) {
        $email = $request->email;
        return view('admin.ResetPassword', ['token' => $token, 'email' => $email]);
    })->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login dengan password baru Anda.')
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');

});
Route::get('/account-disabled', function () {
    return view('admin.disabled');
})->name('account.disabled');

Route::get('/list-destinasi', [FrontendDestinasiController::class, 'index']);
Route::get('/list-homestay', [FrontendHomestayController::class, 'index']);
Route::get('/list-produk', [FrontendProdukController::class, 'index']);
Route::get('/list-post', [FrontendPostController::class, 'index']);
Route::get('/hubungi-kami',[FrontendKontakController::class,'index']);

Route::middleware(['hitungVisit'])->group(function () {
    Route::get('/list-destinasi/{id}', [FrontendDestinasiController::class, 'show'])->name('destinasi.show');
    Route::get('/list-homestay/{id}', [FrontendHomestayController::class, 'show'])->name('homestay.show');
    Route::get('/produk/{id}', [FrontendProdukController::class, 'show'])->name('produk.show');
    Route::get('/list-post/{slug}', [FrontendPostController::class, 'show'])->name('post.detail');
    Route::get('/list-post/{slug}/{lang?}', [FrontendPostController::class, 'show'])->name('post.detail');
});

Route::get('/list-hard-news', [FrontendPostController::class, 'hardNews'])->name('post.hardNews');
Route::get('/list-soft-news', [FrontendPostController::class, 'softNews'])->name('post.softNews');
Route::get('/list-feature', [FrontendPostController::class, 'feature'])->name('post.feature');
Route::get('/list-feature/{id}', [FrontendPostController::class, 'show'])->name('post.show');
Route::get('/list-hard-news/{slug}', [FrontendPostController::class, 'show'])->name('post.hardNewsDetail');
Route::get('/list-soft-news/{slug}', [FrontendPostController::class, 'show'])->name('post.softNewsDetail');
Route::get('/list-feature/{slug}', [FrontendPostController::class, 'show'])->name('post.featureDetail');

Route::get('/list-homestay/{id}/Form-WA', [FrontendHomestayController::class, 'wagw']);
Route::post('/sendWA', [FrontendHomestayController::class, 'wagwSend']);
Route::get('/list-video', [FrontendVideoController::class, 'index']);
