<?php

namespace App\Http\Controllers;

use App\Models\letter_type;
use App\Models\letter;
use Illuminate\Http\Request;
use App\Models\User;
use Excel;
use App\Exports\LetterExport;

class LetterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // Mendapatkan semua jenis surat untuk ditampilkan dalam halaman indeks
    public function getClassificate()
    {
        // Ambil semua jenis surat
        $letterTypes = letter_type::orderBy('letter_code', 'ASC')->simplePaginate(5);
        $letters = Letter::get();

        // Inisialisasi array untuk menyimpan jumlah data letter untuk setiap jenis surat
        $letterCounts = [];

        // Loop melalui setiap jenis surat
        foreach ($letters as $letter) {
            // Hitung jumlah surat untuk setiap letter_type_id
            if (!isset($letterCounts[$letter->letter_type_id])) {
                $letterCounts[$letter->letter_type_id] = 1;
            } else {
                $letterCounts[$letter->letter_type_id]++;
            }
        }

        // Mengembalikan tampilan halaman indeks dengan data jenis surat dan jumlah surat untuk setiap jenis surat
        return view('letter.classificate.index', compact('letterTypes', 'letterCounts'));
    }

    // Fungsi pencarian 
    public function searchClassificate(Request $request)
    {
        $keyword = $request->input('name');
        $letterTypes = letter_type::where('name_type', 'like', "%$keyword%")->orderBy('name_type', 'ASC')->simplePaginate(5);
        $letters = Letter::get();

        // Inisialisasi array untuk menyimpan jumlah data letter untuk setiap jenis surat
        $letterCounts = [];

        // Loop melalui setiap jenis surat
        foreach ($letters as $letter) {
            // Hitung jumlah surat untuk setiap letter_type_id
            if (!isset($letterCounts[$letter->letter_type_id])) {
                $letterCounts[$letter->letter_type_id] = 1;
            } else {
                $letterCounts[$letter->letter_type_id]++;
            }
        }

        // Mengembalikan tampilan hasil pencarian dengan data jenis surat dan jumlah surat untuk setiap jenis surat
        return view('letter.classificate.index', compact('letterTypes', 'letterCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createClassificate()
    {
        // Mengembalikan tampilan formulir pembuatan jenis surat
        return view('letter.classificate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_code' => 'required|min:6',
            'name_type' => 'required',
        ]);
    
        // Buat klasifikasi surat baru dengan data yang valid
        letter_type::create([
            'letter_code' => $request->letter_code,
            'name_type' => $request->name_type
        ]);

        // Mengarahkan pengguna ke halaman data jenis surat dengan pesan sukses
        return redirect()->route('letter.classificate.data')->with('success', 'Berhasil Menambahkan Klasifikasi Surat Baru!');
    }

    // Mengunduh data jenis surat dalam format Excel
    public function downloadExcel()
    {
        // Lakukan perhitungan jumlah surat di sini dan simpan dalam $letterCounts
        $letterCounts = [];

        $file_name = 'Klasifikasi Surat.xlsx';

        // Buat instance dari LetterExport dan berikan $letterCounts
        $export = new LetterExport($letterCounts);

        // Mengembalikan file Excel untuk diunduh
        return Excel::download($export, $file_name);
    }

    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $letterTypes = letter_type::find($id);
        $dataLetter = letter::where('letter_type_id', $id)->get();

        // Inisialisasi array untuk menyimpan jumlah data letter untuk setiap jenis surat
        $letterCounts = [];

        // Loop melalui setiap jenis surat
        foreach ($dataLetter as $letter) {
            // Parse kolom recipients (asumsi dalam bentuk array)
            $recipientId = json_decode($letter->recipients, true);

            // Ambil data pengguna berdasarkan ID
            $recipients = User::whereIn('id', $recipientId)->get();

            // Tambahkan data pengguna ke dalam model surat
            $letter->recipientsData = $recipients;

            // Hitung jumlah surat untuk setiap letter_type_id
            if (!isset($letterCounts[$letter->letter_type_id])) {
                $letterCounts[$letter->letter_type_id] = 1;
            } else {
                $letterCounts[$letter->letter_type_id]++;
            }
        }

        // Mengembalikan tampilan halaman detail jenis surat dengan data jenis surat, data surat, dan jumlah surat untuk setiap jenis surat
        return view('letter.classificate.detail', compact('letterTypes','dataLetter', 'letterCounts'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $letter_type = letter_type::find($id);
        $letter_code = $letter_type['letter_code'];

        // Mengembalikan tampilan formulir pengeditan jenis surat dengan data jenis surat dan kode surat
        return view('letter.classificate.edit', compact('letter_type', 'letter_code'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'letter_code' => 'required|min:6',
            'name_type' => 'required',
        ]);

        // Memperbarui data jenis surat dalam database
        letter_type::where('id', $id)->update([
            'letter_code' => $request->letter_code,
            'name_type' => $request->name_type
        ]);

         // Mengarahkan pengguna ke halaman data jenis surat dengan pesan sukses
        return redirect()->route('letter.classificate.data')->with('success', 'Berhasil Mengubah Data Klasifikasi Surat!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // cari dan hapus data
        letter_type::where('id', $id)->delete();
        return redirect()->back()->with('delete', 'Berhasil Menghapus Data Surat Klasifikasi');
    }
}
