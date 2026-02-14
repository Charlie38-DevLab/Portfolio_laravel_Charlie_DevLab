<?php

// namespace App\Http\Controllers;

// use App\Models\Realisation;
// use App\Models\Event;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\ContactMail;

// class HomeController extends Controller
// {
//     public function index()
//     {
//         // $featuredRealisations = Realisation::featured()
//         //     ->latest()
//         //     ->take(3)
//         //     ->get();

//         $featuredRealisations = Realisation::featured()
//             ->latest()
//             ->take(3)
//             ->get();

//         // ✅ Si vide, prendre les 3 dernières (peu importe featured ou non)
//         if ($featuredRealisations->isEmpty()) {
//             $featuredRealisations = Realisation::latest()
//                 ->take(3)
//                 ->get();
//         }

//         // if ($featuredRealisations->isEmpty()) {
//         //     $featuredRealisations = Realisation::featured()->latest()->take(3)->get();
//         //     // dd('Aucune réalisation mise en avant trouvée. Affichage des dernières réalisations à la place.', $featuredRealisations);
//         //     dd('Aucune réalisation mise en avant trouvée. Affichage des dernières réalisations à la place.', Realisation::count(), $featuredRealisations->count(), $featuredRealisations    ->pluck('title')->toArray());
//         // }

//         $stats = [
//             'projects' => Realisation::count(),
//             'clients' => Realisation::distinct('client')->count('client'),
//             'experience' => 5,
//         ];

//         $upcomingEvents = Event::upcoming()
//             ->take(3)
//             ->get();

//         return view('public.home', compact(
//             'featuredRealisations',
//             'stats',
//             'upcomingEvents'
//         ));
//     }

//     public function about()
//     {
//         return view('public.about');
//     }

//     public function contact()
//     {
//         return view('public.contact');
//     }

//     public function submitContact(Request $request)
//     {
//         $validated = $request->validate([
//             'name'    => 'required|string|max:255',
//             'email'   => 'required|email',
//             'subject' => 'required|string|max:255',
//             'message' => 'required|string',
//         ]);

//         Mail::to('createchcharlie@gmail.com')
//             ->send(new ContactMail($validated));

//         return back()->with('success', 'Votre message a été envoyé avec succès !');
//     }
// }



namespace App\Http\Controllers;

use App\Models\Realisation;
use App\Models\Event;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

use App\Models\Journey;
use App\Models\Education;
use App\Models\Experience;


class HomeController extends Controller
{
    public function index()
    {
        $featuredRealisations = Realisation::featured()
            ->latest()
            ->take(3)
            ->get();

        // Si vide, prendre les 3 dernières
        if ($featuredRealisations->isEmpty()) {
            $featuredRealisations = Realisation::latest()
                ->take(3)
                ->get();
        }

        $stats = [
            'projects' => Realisation::count(),
            'clients' => Realisation::distinct('client')->count('client'),
            'experience' => 5,
        ];

        $upcomingEvents = Event::upcoming()
            ->take(3)
            ->get();

        // ✅ Charger les compétences avec leurs catégories
        $skillCategories = SkillCategory::with(['skills' => function($query) {
                $query->active()->ordered();
            }])
            ->active()
            ->ordered()
            ->get();

        return view('public.home', compact(
            'featuredRealisations',
            'stats',
            'upcomingEvents',
            'skillCategories'
        ));
    }

    public function about()
    {
        // {
        //     $journeys = Journey::active()->ordered()->get();
        //     $educations = Education::active()->ordered()->get();
        //     $experiences = Experience::active()->ordered()->get();

        //     return view('public.about', compact('journeys', 'educations', 'experiences'));
        // }


        $journeys = Journey::active()->ordered()->get();
        $educations = Education::active()->ordered()->get();
        $experiences = Experience::active()->ordered()->get();

        return view('public.about', compact('journeys', 'educations', 'experiences'));

        // return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::to('createchcharlie@gmail.com')
            ->send(new ContactMail($validated));

        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }
}


// namespace App\Http\Controllers;

// use App\Models\Realisation;
// use App\Models\Event;
// use App\Models\SkillCategory;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\ContactMail;

// class HomeController extends Controller
// {
//     public function index()
//     {
//         $featuredRealisations = Realisation::featured()
//             ->latest()
//             ->take(3)
//             ->get();

//         // Si vide, prendre les 3 dernières
//         if ($featuredRealisations->isEmpty()) {
//             $featuredRealisations = Realisation::latest()
//                 ->take(3)
//                 ->get();
//         }

//         $stats = [
//             'projects' => Realisation::count(),
//             'clients' => Realisation::distinct('client')->count('client'),
//             'experience' => 5,
//         ];

//         $upcomingEvents = Event::upcoming()
//             ->take(3)
//             ->get();

//         // ✅ Charger les compétences avec leurs catégories
//         $skillCategories = SkillCategory::with(['skills' => function($query) {
//                 $query->active()->ordered();
//             }])
//             ->active()
//             ->ordered()
//             ->get();

//         return view('public.home', compact(
//             'featuredRealisations',
//             'stats',
//             'upcomingEvents',
//             'skillCategories'
//         ));
//     }

//     public function about()
//     {
//         return view('public.about');
//     }

//     public function contact()
//     {
//         return view('public.contact');
//     }

//     public function submitContact(Request $request)
//     {
//         $validated = $request->validate([
//             'name'    => 'required|string|max:255',
//             'email'   => 'required|email',
//             'subject' => 'required|string|max:255',
//             'message' => 'required|string',
//         ]);

//         Mail::to('createchcharlie@gmail.com')
//             ->send(new ContactMail($validated));

//         return back()->with('success', 'Votre message a été envoyé avec succès !');
//     }
// }






// <?php

// // namespace App\Http\Controllers;

// // use App\Models\Realisation;
// // use App\Models\Event;
// // use Illuminate\Http\Request;
// // use Illuminate\Support\Facades\Mail;
// // use App\Mail\ContactMail;

// // class HomeController extends Controller
// // {
// //     public function index()
// //     {
// //         // $featuredRealisations = Realisation::featured()
// //         //     ->latest()
// //         //     ->take(3)
// //         //     ->get();

// //         $featuredRealisations = Realisation::featured()
// //             ->latest()
// //             ->take(3)
// //             ->get();

// //         // ✅ Si vide, prendre les 3 dernières (peu importe featured ou non)
// //         if ($featuredRealisations->isEmpty()) {
// //             $featuredRealisations = Realisation::latest()
// //                 ->take(3)
// //                 ->get();
// //         }

// //         // if ($featuredRealisations->isEmpty()) {
// //         //     $featuredRealisations = Realisation::featured()->latest()->take(3)->get();
// //         //     // dd('Aucune réalisation mise en avant trouvée. Affichage des dernières réalisations à la place.', $featuredRealisations);
// //         //     dd('Aucune réalisation mise en avant trouvée. Affichage des dernières réalisations à la place.', Realisation::count(), $featuredRealisations->count(), $featuredRealisations    ->pluck('title')->toArray());
// //         // }

// //         $stats = [
// //             'projects' => Realisation::count(),
// //             'clients' => Realisation::distinct('client')->count('client'),
// //             'experience' => 5,
// //         ];

// //         $upcomingEvents = Event::upcoming()
// //             ->take(3)
// //             ->get();

// //         return view('public.home', compact(
// //             'featuredRealisations',
// //             'stats',
// //             'upcomingEvents'
// //         ));
// //     }

// //     public function about()
// //     {
// //         return view('public.about');
// //     }

// //     public function contact()
// //     {
// //         return view('public.contact');
// //     }

// //     public function submitContact(Request $request)
// //     {
// //         $validated = $request->validate([
// //             'name'    => 'required|string|max:255',
// //             'email'   => 'required|email',
// //             'subject' => 'required|string|max:255',
// //             'message' => 'required|string',
// //         ]);

// //         Mail::to('createchcharlie@gmail.com')
// //             ->send(new ContactMail($validated));

// //         return back()->with('success', 'Votre message a été envoyé avec succès !');
// //     }
// // }



// <?php

// namespace App\Http\Controllers;

// use App\Models\Realisation;
// use App\Models\Event;
// use App\Models\PageSetting;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\ContactMail;

// class HomeController extends Controller
// {
//     /**
//      * Afficher la page d'accueil publique
//      */
//     public function index()
//     {
//         // Récupérer les réalisations mises en avant (featured)
//         $featuredRealisations = Realisation::where('featured', true)
//             ->latest()
//             ->take(3)
//             ->get();

//         // ✅ Si aucune réalisation featured, prendre les 3 dernières
//         if ($featuredRealisations->isEmpty()) {
//             $featuredRealisations = Realisation::latest()
//                 ->take(3)
//                 ->get();
//         }

//         // Statistiques dynamiques
//         $stats = [
//             'projects' => Realisation::count(),
//             'clients' => Realisation::distinct('client')->count('client'),
//             'experience' => PageSetting::get('stats_experience_years', 5), // ✅ Valeur dynamique depuis la DB
//         ];

//         // Événements à venir
//         $upcomingEvents = Event::upcoming()
//             ->take(3)
//             ->get();

//         // ✅ Charger tous les paramètres de page depuis la base de données
//         $pageSettings = [
//             'hero' => PageSetting::getSection('hero'),
//             'services' => PageSetting::getSection('services'),
//             'skills' => PageSetting::getSection('skills'),
//             'realisations' => PageSetting::getSection('realisations'),
//             'cta' => PageSetting::getSection('cta'),
//         ];

//         return view('public.home', compact(
//             'featuredRealisations',
//             'stats',
//             'upcomingEvents',
//             'pageSettings' // ✅ Ajout des paramètres de page
//         ));
//     }

//     /**
//      * Afficher la page À propos
//      */
//     public function about()
//     {
//         return view('public.about');
//     }

//     /**
//      * Afficher la page Contact
//      */
//     public function contact()
//     {
//         return view('public.contact');
//     }

//     /**
//      * Traiter le formulaire de contact
//      */
//     public function submitContact(Request $request)
//     {
//         $validated = $request->validate([
//             'name'    => 'required|string|max:255',
//             'email'   => 'required|email',
//             'subject' => 'required|string|max:255',
//             'message' => 'required|string',
//         ]);

//         // Envoyer l'email
//         Mail::to('createchcharlie@gmail.com')
//             ->send(new ContactMail($validated));

//         return back()->with('success', 'Votre message a été envoyé avec succès !');
//     }
// }
