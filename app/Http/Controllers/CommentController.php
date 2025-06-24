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

            $komik->comments()->create([
                'user_id' => auth()->id(), 
                'content' => $request->content
            ]);

            return redirect()->back()->with('success', 'Comment posted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to post comment.');
        }
    }
}