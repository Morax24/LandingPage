<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumReplyController;
use App\Http\Controllers\Admin\ForumReplyController as AdminForumReplyController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\DashboardController;

// ============================================
// SERVE MEDIA FILES FROM PUBLIC FOLDER
// ============================================
Route::get('/media/{filename}', function ($filename) {
    $path = public_path('media/' . $filename);

    if (!file_exists($path)) {
        abort(404, 'File not found');
    }

    $mime = mime_content_type($path);
    return response()->file($path, [
        'Content-Type' => $mime,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('filename', '.*')->name('media.file');

// ============================================
// LANDING PAGE
// ============================================
Route::get('/', [LandingController::class, 'index'])->name('home');

// ============================================
// CONTACT FORM
// ============================================
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ============================================
// FORUM REPLIES
// ============================================
Route::post('/forum/reply', [ForumReplyController::class, 'store'])->name('forum.reply.store');
Route::get('/forum/{contactId}/replies', [ForumReplyController::class, 'getReplies'])->name('forum.replies.get');

// ============================================
// AUTHENTICATION (BREEZE)
// ============================================
require __DIR__.'/auth.php';

// ============================================
// USER DASHBOARD
// ============================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// ADMIN ROUTES
// ============================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Contacts
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/{id}/approve', [AdminContactController::class, 'approve'])->name('contacts.approve');
    Route::post('/contacts/{id}/reject', [AdminContactController::class, 'reject'])->name('contacts.reject');
    Route::post('/contacts/{id}/notes', [AdminContactController::class, 'updateNotes'])->name('contacts.notes');

    // Bulk Contacts
    Route::post('/contacts/bulk-approve', [AdminContactController::class, 'bulkApprove'])->name('contacts.bulk-approve');
    Route::post('/contacts/bulk-reject', [AdminContactController::class, 'bulkReject'])->name('contacts.bulk-reject');
    Route::post('/contacts/bulk-delete', [AdminContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');

    // Media Management
    // Media Management
Route::prefix('media')->name('media.')->group(function () {
    Route::get('/', [MediaController::class, 'index'])->name('index');
    Route::get('/create', [MediaController::class, 'create'])->name('create');
    Route::post('/', [MediaController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [MediaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [MediaController::class, 'update'])->name('update');
    Route::delete('/{id}', [MediaController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/toggle-active', [MediaController::class, 'toggleActive'])->name('toggle-active');

    // Bulk Actions - TAMBAHKAN PARAMETER OPSIONAL
    Route::post('/bulk-delete', [MediaController::class, 'bulkDelete'])->name('bulk-delete');
    Route::post('/bulk-toggle-active', [MediaController::class, 'bulkToggleActive'])->name('bulk-toggle-active');
});

    // Forum Replies
    Route::get('/forum-replies', [AdminForumReplyController::class, 'index'])->name('forum-replies.index');
    Route::post('/forum-replies/{id}/approve', [AdminForumReplyController::class, 'approve'])->name('forum-replies.approve');
    Route::post('/forum-replies/{id}/reject', [AdminForumReplyController::class, 'reject'])->name('forum-replies.reject');
    Route::delete('/forum-replies/{id}', [AdminForumReplyController::class, 'destroy'])->name('forum-replies.destroy');
    Route::post('/forum-replies/bulk-approve', [AdminForumReplyController::class, 'bulkApprove'])->name('forum-replies.bulk-approve');
    Route::post('/forum-replies/bulk-delete', [AdminForumReplyController::class, 'bulkDelete'])->name('forum-replies.bulk-delete');
});
