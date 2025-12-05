<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')
                        ->where('is_approved', true)
                        ->latest()
                        ->paginate(6);

        return view('landing', compact('reviews'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Silakan login terlebih dahulu');
        }

        $request->validate([
            'review' => 'required|string|min:10|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'review' => $request->review,
            'rating' => $request->rating,
            'is_approved' => false,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Review Anda akan ditampilkan setelah disetujui.');
    }

    public function admin()
    {
        $reviews = Review::with('user')
                        ->latest()
                        ->paginate(10);

        return view('admin.reviews', compact('reviews'));
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Review berhasil disetujui');
    }

    public function delete($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review berhasil dihapus');
    }
}
