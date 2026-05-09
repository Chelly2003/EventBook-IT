<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SocialClickController;
use App\Http\Controllers\PayloadController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Organiser\PayoutController;
use App\Http\Controllers\Organiser\ContactController;
use App\Http\Controllers\Organiser\TeamController;
use App\Http\Controllers\MpesaController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\KRAController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ProfileController;


// Checkout
//Route::get('/events/{event}/checkout', [CheckoutController::class, 'show'])
  //   ->name('checkout.show');

//Route::post('/checkout/{event}/process', [CheckoutController::class, 'process'])
  //   ->name('checkout.process');

// M-Pesa Callback (very important)
//Route::post('/mpesa/callback', [CheckoutController::class, 'mpesaCallback'])
   //  ->name('mpesa.callback');

// Booking Confirmed
//Route::get('/booking/confirmed/{booking}', [BookingsController::class, 'confirmBooking'])
  //   ->name('booking.confirmed');


Route::post('/tickets/generate', [TicketController::class, 'generate'])
    ->name('ticket.generate')
    ->middleware('auth');

    Route::prefix('organizer')->middleware('auth')->group(function () {
    Route::get('/organiser/payout', [PayoutController::class, 'index'])
        ->name('organiser.payout');

    Route::post('/organiser/payout', [PayoutController::class, 'store'])
        ->name('organiser.payout.store');

        Route::get('/organiser/payout/verify-otp', [PayoutController::class, 'showOtpForm'])->name('organiser.payout.verify-otp');
Route::post('/organiser/payout/verify-otp', [PayoutController::class, 'verifyOtp']);
Route::post('/organiser/payout/resend-otp', [PayoutController::class, 'resendOtp'])->name('organiser.payout.resend-otp');


    // Delete method
    Route::delete('/organiser/payout/{payoutMethod}', [PayoutController::class, 'destroy'])
        ->name('organiser.payout.destroy');
});
//contaclist route dashboard
Route::prefix('organizer')->middleware('auth')->group(function () {
    Route::get('/contact_lists', [ContactController::class, 'index'])->name('organiser.contact_lists');
    Route::post('/contact_lists', [ContactController::class, 'store'])->name('organiser.contact_lists.store');
    Route::delete('/contact_lists/{contact}', [ContactController::class, 'destroy'])->name('organiser.contact_lists.destroy');
    Route::get('/contact_lists/{contact}/edit', [ContactController::class, 'edit'])->name('organiser.contact_lists.edit'); // added organiser.
    Route::put('/contact_lists/{contact}', [ContactController::class, 'update'])->name('organiser.contact_lists.update'); // added organiser.
});

//team rout
Route::prefix('organizer')->middleware('auth')->group(function () {
    Route::get('/dashboard/team', [TeamController::class, 'index'])->name('dashboard.team');
    Route::post('/dashboard/team/invite', [TeamController::class, 'invite'])->name('team.invite');
    Route::delete('/dashboard/team/{user}', [TeamController::class, 'remove'])->name('team.remove');
});

Route::post('/events/online', [EventController::class, 'storeOnline'])->name('events.online.store');
// Venue event store
Route::post('/events/venue/store', [EventController::class, 'storeVenue'])
    ->name('events.venue.store');

// routes/web.php
Route::get('/venueevent/{id}', [EventController::class, 'show'])->name('venueevent.show');

    Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/tickets/{id}', [TicketController::class, 'show']);
Route::post('/tickets/scan', [TicketController::class, 'scan']);



Route::post('/payload', [PayloadController::class, 'store']);

//Route::post('/social-click', [SocialClickController::class, 'store']);


//show forms
Route::get('sign_up', [TemplateController::class,'sign_up'])->name('register');
Route::get('sign_in', [TemplateController::class,'sign_in'])->name('login');
// Handle form submissions
Route::post('/sign_up', [RegisterController::class, 'register']);
Route::post('/sign_in', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [TemplateController::class,'home'])->name('home');

Route::get('edit', [TemplateController::class,'edit'])->name('edit');
Route::get('createevent', [TemplateController::class,'createevent']) ->name('createevent');

Route::get('exploreevents', [TemplateController::class,'exploreevents']) ->name('exploreevents');


Route::get('/venueevent/{id}', [EventController::class, 'venueevent'])
    ->name('venue.event.show');

Route::get('onlineevent', [TemplateController::class,'onlineevent']) ->name('onlineevent');

Route::get('pricing', [TemplateController::class,'pricing']) ->name('pricing');

Route::get('online_event', [TemplateController::class,'online_event']) ->name('online_event');
Route::get('venue_event', [TemplateController::class,'venue_event']) ->name('venue_event');
Route::delete('/events/{event}', [EventController::class, 'destroy'])
    ->name('events.destroy')
    ->middleware('auth');
    // Edit event
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])
         ->name('events.edit');
         Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');

//Route::get('attendee_profile', [TemplateController::class,'attendee_profile']) ->name('attendee');
//attendee profile
// Attendee Profile
Route::middleware('auth')->get('attendee/profile', [TemplateController::class, 'attendee_profile'])
     ->name('attendee');

// Organizer Profile
Route::middleware(['auth', \App\Http\Middleware\OrganizerMiddleware::class])->get('organizer/profile', [ProfileController::class, 'showProfile'])
     ->name('organiserprofile');
Route::get('create_online_event', [TemplateController::class,'cr_online_event']) ->name('create_online_event');

Route::get('create_venue_event', [TemplateController::class,'cr_venue_event']) ->name('create_venue_event');

Route::get('faq', [TemplateController::class,'faq']) ->name('faq');


Route::get('contactus', [TemplateController::class,'contactus']) ->name('contactus');


//confirmchange later




Route::get('/invoice/{ticket_id}', [TicketController::class, 'invoice'])
    ->name('invoice');



//Route::get('organiserprofile', [TemplateController::class,'organiserprofile']) ->name('organiserprofile')->prefix('organizer')->middleware([\App\Http\Middleware\OrganizerMiddleware::class]);

Route::get('organiserdashboard', [TemplateController::class,'organiserdashboard']) ->name('organiserdashboard') ->prefix('organizer')->middleware([\App\Http\Middleware\OrganizerMiddleware::class]);

// Payout Request Route
Route::post('/organiser/payout/request', [App\Http\Controllers\Organiser\PayoutController::class, 'requestPayout'])
     ->name('organiser.payout.request');

Route::get('event_referral_analytics', [TemplateController::class,'event_referral_analytics']) ->name('event_referral_analytics');

Route::get('org_events', [TemplateController::class,'orgevents']) ->name('organisationevents');

Route::get('conversion_setup', [TemplateController::class,'conversion']) ->name('conversion_setup');

Route::get('my_team', [TemplateController::class,'my_team']) ->name('org_my_team');

//Route::get('contact_list', [TemplateController::class,'contact_list']) ->name('org_contact_list');

Route::get('reports', [TemplateController::class,'reports']) ->name('org_reports');




//for the sign in google button
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Check if a user with this email already exists
    $user = User::firstOrCreate(
        ['email' => $googleUser->email], // search by email
        [
            'name' => $googleUser->name,
            'role' => 'attendee', // only applied if new user
            'password' => bcrypt(uniqid()) // random password for new user
        ]
    );

    // Log the user in
    Auth::login($user);

    // Redirect after login
    return redirect()->route('home');
});




Route::middleware(['auth'])->group(function () {
    Route::post('/upgrade-to-organizer', [RegisterController::class, 'upgradeToOrganizer'])
        ->name('upgrade.organizer');
});

//forgot password route


// Show form
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])

    ->name('password.request');

// Send reset link
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])

    ->name('password.email');



// Show reset password form (the link the user clicks in email)
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])

    ->name('password.reset');

// Handle reset password submission
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);


Route::delete('/events/{event}', [EventController::class, 'destroy'])
    ->name('events.destroy')
    ->middleware('auth');


    //gavaaconnect
   Route::post('/validate-kra', [KRAController::class, 'validatePin'])->name('kra.validate');

   //edit/delet acc


    Route::get('profile', [ProfileController::class, 'showProfile'])->name('organiserprofile');
    Route::put('account/update', [ProfileController::class, 'update'])->name('account.update');
    Route::delete('account/delete', [ProfileController::class, 'destroy'])->name('account.delete');



Route::middleware([\App\Http\Middleware\OrganizerMiddleware::class])->prefix('organizer')->group(function () {
    Route::get('organiserprofile', [TemplateController::class, 'organiserprofile'])
        ->name('organiserprofile');

    // Add other organiser routes here, e.g. dashboard
    Route::get('dashboard', [TemplateController::class, 'organiserdashboard'])
        ->name('organiserdashboard');
});


// === CHECKOUT & MPESA ROUTES ===
Route::get('/events/{event}/checkout', [CheckoutController::class, 'show'])
     ->name('checkout.show');

Route::post('/checkout/{event}/process', [CheckoutController::class, 'process'])
     ->name('checkout.process');

// M-Pesa Callback - Safaricom calls this
Route::post('/mpesa/callback', [CheckoutController::class, 'mpesaCallback'])
     ->name('mpesa.callback');

// Polling status (JS calls this every few seconds)
Route::get('/booking/status/{booking}', [CheckoutController::class, 'checkPaymentStatus'])
     ->name('booking.status');

// Final confirmed page
Route::get('/booking/confirmed/{booking}', [BookingsController::class, 'confirmBooking'])
     ->name('booking.confirmed');



// Free event booking
Route::post('/events/{event_id}/book', [BookingsController::class, 'bookEvent'])
     ->name('booking.book')
     ->middleware('auth');
