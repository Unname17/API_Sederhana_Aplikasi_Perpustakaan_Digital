<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoansController extends Controller
{
    public function index(): JsonResponse
    {

        $dataLoans = Loans::all();
        return response()->json($dataLoans, 200);
    }
    // Menampilkan user berdasarkan ID
    public function show($id): JsonResponse
    {
        try {
            $loans = Loans::findOrFail($id);
            return response()->json($loans, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data Pinjaman Tidak Ketemu'], 404);
        }
    }

    // Menambahkan user baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|string|max:255',
            'book_id' => 'required|string|max:255',
        ]);

        $loans = Loans::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
        ]);

        return response()->json([
            'message' => 'Data Pinjaman berhasil dicatat.',
            'data' => $loans
        ], 201);
    }

    // Mengupdate data user
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $author = Loans::findOrFail($id);

            $request->validate([
                'user_id' => 'sometimes|string|max:255',
                'book_id' => 'sometimes|string|max:255',
            ]);

            // Hanya update field yang dikirim
            $data = $request->only(['user_id', 'book_id']);
            $author->update($data);
              
  
            return response()->json([
                'message' => $author->wasChanged()
                    ? 'Data Pinjaman berhasil diperbaharui.'
                    : 'Tidak ada perubahan pada data Pinjaman ini.',
                'data' => $author
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data Pinjaman not found'], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $loans = Loans::findOrFail($id);
            $loans->delete();
            return response()->json(['message' => 'Data Pinjaman Berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data Pinjaman tidak ditemukan.'], 404);
        }
    }
}
