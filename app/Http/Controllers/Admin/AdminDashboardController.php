<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Product;
use App\Models\Event;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Realisation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Afficher le tableau de bord admin
     */
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_projects' => Realisation::count(),
            'total_products' => Product::count(),
            'total_events' => Event::count(),
            'total_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'unread_contacts' => Contact::where('status', 'new')->count(),
        ];

        // Dernières commandes
        $recentOrders = Order::with('user', 'product')
            ->latest()
            ->take(5)
            ->get();

        // Derniers messages
        $recentContacts = Contact::latest()
            ->take(5)
            ->get();

        // Prochains événements
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'recentContacts',
            'upcomingEvents'
        ));
    }
}
