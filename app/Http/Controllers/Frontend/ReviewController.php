<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\OrderItem; // Import OrderItem
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'rating' => 'required|in:1,2,3,4,5',
        ]);

        $product_id = $request->product_id;
        $user_id = Auth::id();

        // Cek riwayat pembelian (tetap)
        $hasPurchased = OrderItem::whereHas('order', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->where('product_id', $product_id)->exists();

        if (!$hasPurchased) {
            return response()->json(['error' => 'Anda harus membeli produk ini untuk memberikan ulasan.'], 403);
        }

        // Cek duplikasi ulasan (tetap)
        $alreadyReviewed = Review::where('user_id', $user_id)->where('product_id', $product_id)->exists();
        if ($alreadyReviewed) {
            return response()->json(['error' => 'Anda sudah pernah memberikan ulasan untuk produk ini.'], 409);
        }

        // Simpan ulasan baru dengan status 'approved'
        $review = Review::create([
            'product_id' => $product_id,
            'user_id' => $user_id,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'status' => 'approved', // <-- PERUBAHAN: Langsung disetujui
            'created_at' => Carbon::now(),
        ]);

        // Ambil data review yang baru dibuat beserta relasi user
        $newReview = Review::with('user')->find($review->id);

        // Kirim response sukses beserta data review baru
        return response()->json([
            'success' => 'Terima kasih! Ulasan Anda telah berhasil dipublikasikan.',
            'review' => $newReview // <-- TAMBAHAN: Kirim data ulasan baru
        ]);
    }
}