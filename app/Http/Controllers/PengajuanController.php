<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'no_tlp' => [
                'required',
                'string',
                'regex:/^(08[0-9]{8,11}|(\+62|62)[8-9][0-9]{7,10}|(\+62|62)[2-7][0-9]{7,9})$/',
                'min:10',
                'max:15'
            ],
            'description' => 'required|string|min:10|max:1000',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal 255 karakter',

            'no_tlp.required' => 'Nomor telepon wajib diisi',
            'no_tlp.string' => 'Nomor telepon harus berupa teks',
            'no_tlp.regex' => 'Format nomor telepon tidak valid. Gunakan format Indonesia yang benar (08xxxxxxxxxx atau +628xxxxxxxxxx)',
            'no_tlp.min' => 'Nomor telepon minimal 10 digit',
            'no_tlp.max' => 'Nomor telepon maksimal 15 digit',

            'description.required' => 'Deskripsi wajib diisi',
            'description.string' => 'Deskripsi harus berupa teks',
            'description.min' => 'Deskripsi minimal 10 karakter',
            'description.max' => 'Deskripsi maksimal 1000 karakter',

            'image.*.image' => 'File harus berupa gambar',
            'image.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'image.*.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        $validator->after(function ($validator) use ($request) {
            $phoneNumber = $request->no_tlp;

            if ($phoneNumber) {
                $cleanedNumber = preg_replace('/[\s\-\(\)]/', '', $phoneNumber);
                $validPatterns = [
                    '/^08[0-9]{8,11}$/',
                    '/^(\+62|62)[8-9][0-9]{7,10}$/',
                    '/^(\+62|62)[2-7][0-9]{7,9}$/'
                ];

                $isValid = false;
                foreach ($validPatterns as $pattern) {
                    if (preg_match($pattern, $cleanedNumber)) {
                        $isValid = true;
                        break;
                    }
                }

                if (!$isValid) {
                    $validator->errors()->add('no_tlp', 'Nomor telepon harus menggunakan format Indonesia yang valid');
                }
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang dimasukkan tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $normalizedPhone = $this->normalizePhoneNumber($request->no_tlp);
            $imagePaths = [];

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    if (!in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Format file tidak didukung. Hanya jpg, jpeg, png, dan gif yang diizinkan.'
                        ], 422);
                    }

                    $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('pengajuan-images', $filename, 'public');
                    $imagePaths[] = $path;
                }
            }

            $pengajuan = Pengajuan::create([
                'name' => trim($request->name),
                'no_tlp' => $normalizedPhone,
                'description' => trim($request->description),
                'images' => $imagePaths,
                'status' => 'pending'
            ]);

           $adminUsers = User::whereIn('role', ['admin', 'super_admin'])->get();
            if ($adminUsers->isNotEmpty()) {
                Notification::make()
                    ->title('Pengajuan Baru dari ' . $request->name)
                    ->body(Str::limit($request->description, 100))
                    ->success()
                    ->sendToDatabase($adminUsers);
            } else {
                Log::warning('Tidak ada admin yang ditemukan untuk mengirim notifikasi');
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil dikirim! Kami akan segera meninjau pengajuan Anda.',
                'data' => [
                    'id' => $pengajuan->id,
                    'name' => $pengajuan->name,
                    'no_tlp' => $pengajuan->no_tlp,
                    'status' => $pengajuan->status_label ?? $pengajuan->status
                ]
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan pengajuan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan pengajuan. Silakan coba lagi.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    private function normalizePhoneNumber($phoneNumber)
    {
        $cleaned = preg_replace('/[\s\-\(\)]/', '', $phoneNumber);
        if (preg_match('/^\+62(.+)$/', $cleaned, $matches)) {
            return '0' . $matches[1];
        } elseif (preg_match('/^62(.+)$/', $cleaned, $matches)) {
            return '0' . $matches[1];
        }

        return $cleaned;
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
                'images' => $pengajuan->images ? array_map(function ($image) {
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
