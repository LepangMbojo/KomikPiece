<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\KomikIndex;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
   public function store(Request $request, KomikIndex $komik)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        try {
            // Gunakan relasi untuk membuat komentar baru.
            // 'komik_id' akan diisi secara otomatis oleh Laravel.
            $komik->comments()->create([
                'user_id' => auth()->id(), // 'user_id' dan 'content' tetap perlu ada di $fillable
                'content' => $request->content
            ]);

            return redirect()->back()->with('success', 'Comment posted successfully!');

        } catch (\Exception $e) {
            // Log error untuk debugging jika perlu
            // Log::error('Failed to post comment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to post comment.');
        }
    }
}