<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Tampilkan detail event
     */
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        return view('event-detail', compact('event'));
    }

    /**
     * Tampilkan halaman checkout (ambil data event dari DB)
     */
    public function checkout(Event $event)
    {
        // Cek apakah stock masih ada
        if ($event->stock <= 0) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Maaf, tiket untuk event ini sudah habis.');
        }

        return view('checkout', compact('event'));
    }

    /**
     * Proses Checkout (Simpan Transaksi)
     */
    public function processCheckout(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
        ]);

        // 2. Ambil Data Event
        $event = Event::findOrFail($validated['event_id']);

        // 3. Cek Stock lagi (double check untuk mencegah race condition)
        if ($event->stock <= 0) {
            return back()->with('error', 'Maaf, stok tiket habis!');
        }

        // 4. Hitung Total Harga (Harga Event + Biaya Layanan Rp 5.000)
        $serviceFee = 5000;
        $totalPrice = $event->price + $serviceFee;

        // 5. Generate Order ID Unik
        $orderId = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        // 6. Simpan ke Database (Transactions)
        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'total_price' => $totalPrice,
            'status' => 'Pending', // Nanti bisa diubah jadi Success
        ]);

        // 7. Kurangi Stok Event
        $event->decrement('stock');

        // 8. Redirect ke halaman tiket
        return redirect()->route('ticket', $orderId)
            ->with('success', 'Pembelian berhasil! Order ID Anda: ' . $orderId);
    }

    /**
     * Tampilkan E-Ticket berdasarkan Order ID
     */
    public function ticket($order_id)
    {
        // Cari transaksi berdasarkan order_id
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        return view('ticket', compact('transaction'));
    }

    public function myTickets()
    {
        // Auto cleanup expired reservations (quick fix)
        \App\Models\Transaction::cleanupExpiredReservations();

        $userEmail = Auth::user()->email;
        
        // Ambil parameter dari URL (Filter & Search)
        $filter = request('filter', 'all'); // all, active, success, pending, expired
        $search = request('search', '');

        // 1. Hitung Stats (Selalu hitung semua, tidak terpengaruh filter/search)
        $stats = [
            'active' => Transaction::where('customer_email', $userEmail)
                ->whereIn('status', ['success', 'settlement'])
                ->whereHas('event', fn($q) => $q->where('date', '>=', now()))
                ->count(),
            'success' => Transaction::where('customer_email', $userEmail)
                ->whereIn('status', ['success', 'settlement'])
                ->count(),
            'pending' => Transaction::where('customer_email', $userEmail)
                ->whereIn('status', ['reserved', 'pending'])
                ->where('reserved_until', '>', now())
                ->count(),
            'expired' => Transaction::where('customer_email', $userEmail)
                ->where(function($q) {
                    $q->where('status', 'expired')
                      ->orWhere('status', 'failed')
                      ->orWhere('status', 'cancelled')
                      ->orWhere(function($subQ) {
                          $subQ->whereIn('status', ['reserved', 'pending'])
                               ->where('reserved_until', '<=', now());
                      });
                })
                ->count(),
        ];

        // 2. Build Query Utama
        $query = Transaction::where('customer_email', $userEmail)->with('event');

        // 3. Apply Search (Cari berdasarkan Order ID atau Nama Event)
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhereHas('event', function($eq) use ($search) {
                      $eq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // 4. Apply Filter
        switch ($filter) {
            case 'active':
                $query->whereIn('status', ['success', 'settlement'])
                      ->whereHas('event', fn($q) => $q->where('date', '>=', now()));
                break;
            case 'success':
                $query->whereIn('status', ['success', 'settlement']);
                break;
            case 'pending':
                $query->whereIn('status', ['reserved', 'pending'])
                      ->where('reserved_until', '>', now());
                break;
            case 'expired':
                $query->where(function($q) {
                    $q->where('status', 'expired')
                      ->orWhere('status', 'failed')
                      ->orWhere('status', 'cancelled')
                      ->orWhere(function($subQ) {
                          $subQ->whereIn('status', ['reserved', 'pending'])
                               ->where('reserved_until', '<=', now());
                      });
                });
                break;
            default:
                // 'all' - tidak ada filter tambahan
                break;
        }

        // 5. Eksekusi Query dengan Pagination & Pertahankan Query Params
        $transactions = $query->latest()->paginate(10)->appends(request()->query());

        return view('my-tickets', compact(
            'transactions', 
            'stats', 
            'filter', 
            'search'
        ));
    }
}