<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Afficher la liste des commandes
     */
    public function index()
    {
        $orders = Order::with(['user', 'product'])
            ->latest()
            ->paginate(20);

        // Statistiques
        $stats = [
            'total' => Order::count(),
            'completed' => Order::where('status', 'completed')->count(),
            'pending' => Order::where('status', 'pending')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'revenue' => Order::where('status', 'completed')->sum('amount'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Afficher les détails d'une commande
     */
    public function show(Order $order)
    {
        $order->load(['user', 'product']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        try {
            $oldStatus = $order->status;
            $order->update(['status' => $validated['status']]);

            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('success', "Statut changé de '{$oldStatus}' à '{$validated['status']}'");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du statut.');
        }
    }

    /**
     * Supprimer une commande
     */
    public function destroy(Order $order)
    {
        try {
            $orderNumber = $order->order_number;
            $order->delete();

            return redirect()
                ->route('admin.orders.index')
                ->with('success', "Commande #{$orderNumber} supprimée avec succès.");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
}
