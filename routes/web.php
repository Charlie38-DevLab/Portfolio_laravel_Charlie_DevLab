<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RealisationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AffiliateController;

// Auth Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminRealisationController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\JourneyController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;


/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// À Propos
Route::get('/a-propos', [HomeController::class, 'about'])->name('about');

// Réalisations
Route::prefix('realisations')->name('realisations.')->group(function () {
    Route::get('/', [RealisationController::class, 'index'])->name('index');
    Route::get('/{slug}', [RealisationController::class, 'show'])->name('show');
});

Route::get('/realisations/image/{filename}', function ($filename) {
    $path = storage_path('app/public/realisations/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('realisations.image');


// Route::get('/events/image/{filename}', function ($filename) {
//     $path = storage_path('app/public/events/' . $filename);

//     if (!file_exists($path)) {
//         abort(404);
//     }

//     return response()->file($path);
// })->name('events.image');


// Boutique
Route::prefix('boutique')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
});


Route::get('/products/image/{filename}', function ($filename) {
    $path = storage_path('app/public/products/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('products.image');


// Événements
// Route::prefix('evenements')->name('events.')->group(function () {
//     Route::get('/', [EventController::class, 'index'])->name('index');
//     Route::get('/{slug}', [EventController::class, 'show'])->name('show');
// });


/*
|--------------------------------------------------------------------------
| Routes Publiques - Événements
|--------------------------------------------------------------------------
*/

Route::prefix('evenements')->name('events.')->group(function () {
    // Liste des événements
    Route::get('/', [EventController::class, 'index'])->name('index');

    // Détail d'un événement
    Route::get('/{slug}', [EventController::class, 'show'])->name('show');

    // Inscription à un événement (nécessite authentification)
    Route::post('/{slug}/inscription', [EventController::class, 'register'])
        ->middleware('auth')
        ->name('register');

    // Annulation d'inscription (nécessite authentification)
    Route::delete('/{slug}/annuler', [EventController::class, 'cancelRegistration'])
        ->middleware('auth')
        ->name('cancel');
});


// Blog
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/contact', [ContactController::class, 'index'])->name('public.contact');

// Programme d'affiliation
Route::get('/programme-affilie', [AffiliateController::class, 'index'])->name('affiliate.index');

/*
|--------------------------------------------------------------------------
| Routes d'Authentification
|--------------------------------------------------------------------------
*/

// Routes pour les invités (non connectés)
Route::middleware('guest')->group(function () {
    // Connexion
    Route::get('/connexion', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/connexion', [LoginController::class, 'login'])->name('login.submit');

    // Inscription
    Route::get('/inscription', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/inscription', [RegisterController::class, 'register'])->name('register.submit');

    // Authentification sociale (Google & GitHub)
    Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])
        ->name('social.redirect')
        ->where('provider', 'google|github');

    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])
        ->name('social.callback')
        ->where('provider', 'google|github');
});

// Déconnexion (utilisateurs connectés)
Route::middleware('auth')->group(function () {
    Route::post('/deconnexion', [LoginController::class, 'logout'])->name('logout');

    // Inscription aux événements
    Route::post('/evenements/{slug}/inscription', [EventController::class, 'register'])->name('events.register');
});

/*
|--------------------------------------------------------------------------
| Routes Utilisateur (Nécessite authentification)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('mon-profil')->name('profile.')->group(function () {
    // Profil
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/modifier', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/modifier', [ProfileController::class, 'update'])->name('update');

    // Événements et achats
    Route::get('/evenements', [ProfileController::class, 'myEvents'])->name('events');
    Route::get('/achats', [ProfileController::class, 'myPurchases'])->name('purchases');

    // Gestion des activités
    Route::delete('/activite/{id}', [ProfileController::class, 'deleteActivity'])->name('activity.delete');
    Route::delete('/activites/tout-supprimer', [ProfileController::class, 'clearAllActivities'])->name('activity.clear');
});

/*
|--------------------------------------------------------------------------
| Communauté
|--------------------------------------------------------------------------
*/

Route::prefix('communaute')->name('community.')->group(function () {
    Route::get('/', [CommunityController::class, 'index'])->name('index');
});

/*
|--------------------------------------------------------------------------
| Routes Admin - Protégées par le middleware 'role:admin'
|--------------------------------------------------------------------------
*/

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin', [AdminDashboardController::class, 'index'])
//         ->name('admin.dashboard');
// });
// Routes Admin


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... autres routes admin ...

    // Skills Routes
    Route::get('/skills', [App\Http\Controllers\Admin\SkillController::class, 'index'])->name('skills.index');
    Route::post('/skills', [App\Http\Controllers\Admin\SkillController::class, 'store'])->name('skills.store');
    Route::put('/skills/{skill}', [App\Http\Controllers\Admin\SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{skill}', [App\Http\Controllers\Admin\SkillController::class, 'destroy'])->name('skills.destroy');
    Route::post('/skills/reorder', [App\Http\Controllers\Admin\SkillController::class, 'reorder'])->name('skills.reorder');

    // Skill Categories Routes
    Route::post('/skill-categories', [App\Http\Controllers\Admin\SkillCategoryController::class, 'store'])->name('skill-categories.store');
    Route::put('/skill-categories/{skillCategory}', [App\Http\Controllers\Admin\SkillCategoryController::class, 'update'])->name('skill-categories.update');
    Route::delete('/skill-categories/{skillCategory}', [App\Http\Controllers\Admin\SkillCategoryController::class, 'destroy'])->name('skill-categories.destroy');
    Route::post('/skill-categories/reorder', [App\Http\Controllers\Admin\SkillCategoryController::class, 'reorder'])->name('skill-categories.reorder');


    // Parcours
    Route::resource('journeys', JourneyController::class);
    Route::post('journeys/update-order', [JourneyController::class, 'updateOrder'])->name('journeys.update-order');

    // Formations
    Route::resource('educations', EducationController::class);
    Route::post('educations/update-order', [EducationController::class, 'updateOrder'])->name('educations.update-order');

    // Expériences
    Route::resource('experiences', ExperienceController::class);
    Route::post('experiences/update-order', [ExperienceController::class, 'updateOrder'])->name('experiences.update-order');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::post('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{order}', [AdminOrderController::class, 'destroy'])->name('destroy');
    });

    // Gestion des Réalisations
    Route::prefix('realisations')->name('realisations.')->group(function () {
        Route::get('/', [AdminRealisationController::class, 'index'])->name('index');
        Route::get('/create', [AdminRealisationController::class, 'create'])->name('create');
        Route::post('/', [AdminRealisationController::class, 'store'])->name('store');
        Route::get('/{realisation}/edit', [AdminRealisationController::class, 'edit'])->name('edit');
        Route::put('/{realisation}', [AdminRealisationController::class, 'update'])->name('update');
        Route::delete('/{realisation}', [AdminRealisationController::class, 'destroy'])->name('destroy');
    });

    // Gestion des Produits
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('create');
        Route::post('/', [AdminProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
    });

    // Gestion des Événements
    // Route::prefix('events')->name('events.')->group(function () {
    //     Route::get('/', [AdminEventController::class, 'index'])->name('index');
    //     Route::get('/create', [AdminEventController::class, 'create'])->name('create');
    //     Route::post('/', [AdminEventController::class, 'store'])->name('store');
    //     Route::get('/{event}/edit', [AdminEventController::class, 'edit'])->name('edit');
    //     Route::put('/{event}', [AdminEventController::class, 'update'])->name('update');
    //     Route::delete('/{event}', [AdminEventController::class, 'destroy'])->name('destroy');
    //     Route::get('/{event}/registrations', [AdminEventController::class, 'registrations'])->name('registrations');
    // });

        /*
    |--------------------------------------------------------------------------
    | Routes Admin - Gestion des Événements
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/evenements')->name('events.')->group(function () {
        // Liste des événements (dashboard)
        Route::get('/', [AdminEventController::class, 'index'])->name('index');

        // Créer un événement
        Route::get('/create', [AdminEventController::class, 'create'])->name('create');
        Route::post('/', [AdminEventController::class, 'store'])->name('store');

        // Éditer un événement
        Route::get('/{event}/modifier', [AdminEventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [AdminEventController::class, 'update'])->name('update');

        // Supprimer un événement
        Route::delete('/{event}', [AdminEventController::class, 'destroy'])->name('destroy');

        // Voir les inscriptions d'un événement
        Route::get('/{event}/inscriptions', [AdminEventController::class, 'registrations'])->name('registrations');

        // Basculer le statut "mis en avant"
        Route::post('/{event}/toggle-featured', [AdminEventController::class, 'toggleStatus'])->name('toggle-featured');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes API (optionnel) - Pour AJAX/API
    |--------------------------------------------------------------------------
    */

    Route::prefix('api/evenements')->name('api.events.')->middleware('api')->group(function () {
        // Liste des événements (JSON)
        Route::get('/', [EventController::class, 'index']);

        // Recherche d'événements
        Route::get('/recherche', [EventController::class, 'search']);

        // Événements à venir
        Route::get('/a-venir', function () {
            return \App\Models\Event::upcoming()->get();
        });

        // Événements en vedette
        Route::get('/en-vedette', function () {
            return \App\Models\Event::featured()->upcoming()->get();
        });
    });

    // Gestion du Blog
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [AdminBlogController::class, 'index'])->name('index');
        Route::get('/create', [AdminBlogController::class, 'create'])->name('create');
        Route::post('/', [AdminBlogController::class, 'store'])->name('store');
        Route::get('/{post}/edit', [AdminBlogController::class, 'edit'])->name('edit');
        Route::put('/{post}', [AdminBlogController::class, 'update'])->name('update');
        Route::delete('/{post}', [AdminBlogController::class, 'destroy'])->name('destroy');
    });

    // Gestion des Utilisateurs
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });

    // Gestion des Messages de Contact
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [AdminContactController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminContactController::class, 'show'])->name('show');
        Route::delete('/{id}', [AdminContactController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/mark-read', [AdminContactController::class, 'markAsRead'])->name('mark-read');
    });
});
