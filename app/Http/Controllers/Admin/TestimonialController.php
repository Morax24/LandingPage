<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        // HANYA ambil yang type = 'testimonial'
        $query = Contact::testimonial();

        // Search filter
        if($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('message', 'like', "%$search%");
            });
        }

        // Status filter
        if($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $testimonials = $query->orderBy('created_at', 'desc')->paginate(10);

        // Stats - HANYA untuk testimonial
        $stats = [
            'total' => Contact::testimonial()->count(),
            'pending' => Contact::testimonial()->pending()->count(),
            'approved' => Contact::testimonial()->approved()->count(),
            'rejected' => Contact::testimonial()->rejected()->count(),
        ];

        return view('admin.testimonials', compact('testimonials', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // PASTIKAN type = 'testimonial' untuk admin
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'institution' => $request->institution,
            'message' => $request->message,
            'type' => 'testimonial',
            'status' => $request->status,
            'approved_at' => $request->status == 'approved' ? now() : null,
            'approved_by' => $request->status == 'approved' ? auth()->id() : null,
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan!');
    }

    public function approve($id)
    {
        $testimonial = Contact::findOrFail($id);
        $testimonial->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Testimoni disetujui!');
    }

    public function reject($id)
    {
        $testimonial = Contact::findOrFail($id);
        $testimonial->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Testimoni ditolak!');
    }

    public function destroy($id)
    {
        $testimonial = Contact::findOrFail($id);
        $testimonial->delete();

        return back()->with('success', 'Testimoni dihapus!');
    }
}
