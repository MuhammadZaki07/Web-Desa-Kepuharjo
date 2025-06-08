<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|min:2',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'comment' => 'required|string|max:1000|min:10',
            'page_url' => 'required|url|max:500',
            'page_title' => 'nullable|string|max:255'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 2 karakter.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'website.url' => 'Format website tidak valid. Contoh: https://example.com',
            'comment.required' => 'Komentar wajib diisi.',
            'comment.min' => 'Komentar minimal 10 karakter.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
            'page_url.required' => 'URL halaman tidak valid.',
            'page_url.url' => 'URL halaman tidak valid.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('comment_error', true);
        }

        $duplicateCheck = Comment::where('email', $request->email)
            ->where('comment', $request->comment)
            ->where('page_url', $request->page_url)
            ->where('created_at', '>', now()->subMinutes(5))
            ->exists();

        if ($duplicateCheck) {
            return back()->withErrors([
                'comment' => 'Komentar yang sama sudah dikirim sebelumnya.'
            ])->withInput()->with('comment_error', true);
        }

        try {
            Comment::create([
                'name' => $request->name,
                'email' => $request->email,
                'website' => $request->website,
                'comment' => $request->comment,
                'page_url' => $request->page_url,
                'page_title' => $request->page_title,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return back()->with('comment_success', 'Komentar berhasil dikirim!');

        } catch (\Exception $e) {
            return back()->withErrors([
                'comment' => 'Terjadi kesalahan saat menyimpan komentar. Silakan coba lagi.'
            ])->withInput()->with('comment_error', true);
        }
    }

    public function getCommentsForPage($url)
    {
        return Comment::forPage($url)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
