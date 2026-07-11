<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto cleanup expired reservations
        \App\Models\Transaction::cleanupExpiredReservations();
        // Stats Cards
        $totalRevenue = Transaction::whereIn('status', ['success', 'settlement'])->sum('total_price');
        $totalTicketsSold = Transaction::whereIn('status', ['success', 'settlement'])->count();
        $activeEvents = Event::where('date', '>=', now())->count();
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // Recent Transactions (5 terakhir)
        $recentTransactions = Transaction::with(['event'])
            ->latest()
            ->take(5)
            ->get();

        // Top Events (by revenue)
        $topEvents = Event::withCount(['transactions as total_sold' => function($query) {
                $query->whereIn('status', ['success', 'settlement']);
            }])
            ->withSum(['transactions as total_revenue' => function($query) {
                $query->whereIn('status', ['success', 'settlement']);
            }], 'total_price')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        // Monthly Revenue (last 6 months)
        $monthlyRevenue = Transaction::whereIn('status', ['success', 'settlement'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalTicketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'topEvents',
            'monthlyRevenue'
        ));
    }
}