<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Carbon\Carbon; 
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AdminReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews.index', ['title' => 'Data Ulasan']);
    }

   public function data()
{
    $reviews = Review::with(['product', 'user'])->latest();

    return DataTables::of($reviews)
        ->addIndexColumn()
        ->editColumn('comment', function ($review) {
            $comment = Str::limit($review->comment, 40);
            if ($review->admin_reply) {
                $comment .= ' <span class="badge badge-success">Dibalas</span>';
            }
            return $comment;
        })
        
        // SOLUSI: Tambahkan kembali kolom 'rating' dengan logika bintang
        ->addColumn('rating', function ($review) {
            $stars = '';
            for ($i = 1; $i <= $review->rating; $i++) {
                // Gunakan ikon bintang dari Font Awesome dengan warna kuning
                $stars .= '<i class="fas fa-star text-warning"></i>';
            }
            return $stars;
        })

        ->addColumn('action', function ($review) {
            $replyBtn = '
                <button type="button" class="btn btn-sm btn-info btn-reply" 
                        data-id="' . $review->id . '"
                        data-comment="' . e($review->comment) . '"
                        data-reply="' . e($review->admin_reply) . '"
                        data-toggle="tooltip" title="Balas Ulasan">
                    <i class="fas fa-reply"></i>
                </button>
            ';

            $deleteForm = '
                <form action="' . route('admin.reviews.destroy', $review->id) . '" method="POST" class="d-inline-block form-delete">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus Ulasan">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            ';
            return $replyBtn . ' ' . $deleteForm;
        })
        ->rawColumns(['rating', 'action', 'comment'])
        ->make(true);
}
        // BARU: Method untuk menyimpan balasan
    public function storeReply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $review = Review::findOrFail($id);
        $review->update([
            'admin_reply' => $request->admin_reply,
            'replied_at' => Carbon::now(),
        ]);

        // Return response JSON untuk AJAX
        return response()->json(['success' => 'Balasan berhasil dikirim!']);
    }
    
    // Method updateStatus() DIHAPUS

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Ulasan berhasil dihapus!');
    }
}
