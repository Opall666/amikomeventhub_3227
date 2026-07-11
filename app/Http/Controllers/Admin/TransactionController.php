<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['event']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by order_id or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('event');
        return view('admin.transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Success,Failed,Cancelled',
        ]);

        $oldStatus = $transaction->status;
        $transaction->update(['status' => $validated['status']]);

        // Jika status berubah dari Success ke Failed/Cancelled, kembalikan stock
        if ($oldStatus === 'Success' && in_array($validated['status'], ['Failed', 'Cancelled'])) {
            $transaction->event->increment('stock');
        }
        
        // Jika status berubah ke Success, kurangi stock
        if ($oldStatus !== 'Success' && $validated['status'] === 'Success') {
            $transaction->event->decrement('stock');
        }

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Status transaksi berhasil diubah dari ' . $oldStatus . ' ke ' . $validated['status']);
    }
}