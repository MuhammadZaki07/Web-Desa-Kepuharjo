<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\User;
use App\Notifications\PengajuanBaruNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:20',
            'description' => 'required|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'name.required' => 'Nama wajib diisi',
            'no_tlp.required' => 'Nomor telepon wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
            'image.*.image' => 'File harus berupa gambar',
            'image.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'image.*.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $imagePaths = [];

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('pengajuan-images', $filename, 'public');
                    $imagePaths[] = $path;
                }
            }

            $pengajuan = Pengajuan::create([
                'name' => $request->name,
                'no_tlp' => $request->no_tlp,
                'description' => $request->description,
                'images' => $imagePaths,
                'status' => 'pending'
            ]);

            $adminUsers = User::whereHas('roles', function($query) {
                $query->where('name', 'admin');
            })->get();

            foreach ($adminUsers as $admin) {
                $admin->notify(new PengajuanBaruNotification($pengajuan));
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil dikirim! Kami akan segera meninjau pengajuan Anda.',
                'data' => [
                    'id' => $pengajuan->id,
                    'name' => $pengajuan->name,
                    'status' => $pengajuan->status_label
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan pengajuan. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Pengajuan $pengajuan)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $pengajuan->id,
                'name' => $pengajuan->name,
                'no_tlp' => $pengajuan->no_tlp,
                'description' => $pengajuan->description,
                'images' => $pengajuan->images ? array_map(function($image) {
                    return Storage::url($image);
                }, $pengajuan->images) : [],
                'status' => $pengajuan->status,
                'status_label' => $pengajuan->status_label,
                'created_at' => $pengajuan->created_at->format('d M Y H:i'),
                'whatsapp_url' => $pengajuan->whatsapp_url
            ]
        ]);
    }
}
