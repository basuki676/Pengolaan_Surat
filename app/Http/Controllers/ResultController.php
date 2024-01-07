<?php

namespace App\Http\Controllers;

use App\Models\result;
use App\Models\letter;
use App\Models\letter_type;
use App\Models\User;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data surat dari database
        $letters = Letter::orderBy('letter_type_id', 'ASC')->simplePaginate(5);
        $letterTypes = letter_type::get(); 
        $results = Result::get();

        // Inisialisasi array untuk menyimpan jumlah surat untuk setiap letter_type_id
        $letterCounts = [];

        foreach ($letters as $letter) {
            // Ambil data pengguna notulis
            $notulisUser = User::find($letter->notulis);

            // Tambahkan data pengguna notulis ke dalam model surat
            $letter->notulisUserData = $notulisUser;

            // Parse kolom recipients (asumsi dalam bentuk array)
            $recipientId = json_decode($letter->recipients, true);

            // Ambil data klasifikasi berdasarkan letter_type_id
            $letterTypeId = letter_type::find($letter->letter_type_id);

            // Tambahkan data pengguna ke dalam model surat
            $letter->letterTypeId = $letterTypeId;

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

        // Mengembalikan tampilan halaman indeks dengan data surat, hasil rapat, jenis surat, dan jumlah surat untuk setiap jenis surat
        return view('result.index', compact('letters', 'results', 'letterTypes', 'letterCounts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $letter = Letter::find($id);

        // Decode JSON jika kolom recipients berbentuk JSON
        $recipients = json_decode($letter->recipients, true);

        // Menemukan pengguna dengan ID yang terdapat di recipients
        $users = User::whereIn('id', $recipients)->where('role', 'guru')->get();
        
        // Mengembalikan tampilan formulir pembuatan hasil rapat dengan data pengguna dan surat
        return view('result.create', compact('users', 'letter'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'letter_id' => 'required',
            'notes' => 'required',
            'presence_recipients' => 'required|array',
        ]);

        Result::create([
            'letter_id' => $request->letter_id,
            'notes' => $request->notes,
            'presence_recipients' => json_encode($request->presence_recipients), // Simpan sebagai JSON
        ]);

        // Mengarahkan pengguna ke halaman data hasil rapat dengan pesan sukses       
        return redirect()->route('result.data')->with('success', 'Berhasil Membuat Hasil Rapat!');
    }


    /**
     * Display the specified resource.
     */
    public function show(letter $letter, $id)
    {
        $letter = letter::find($id);
        $letterType = letter_type::get();
        // Inisialisasi array untuk menyimpan jumlah data letter untuk setiap jenis surat
        $letterCounts = [];
        $recipientId = json_decode($letter->recipients, true);
        $users = User::where('role', 'guru')->get();
        $result = result::where('letter_id', $id)->first();

        // Tambahkan data pengguna ke dalam model surat
        $letter->letterResult = $result;

        // Parse kolom recipients (asumsi dalam bentuk array)
        $recipientId = json_decode($letter->recipients, true);

        // Ambil data klasifikasi berdasarkan letter_type_id
        $letterTypeId = letter_type::find($letter->letter_type_id);

        // Tambahkan data pengguna ke dalam model surat
        $letter->letterTypeId = $letterTypeId;

        // Ambil data pengguna berdasarkan ID
        $recipients = User::whereIn('id', $recipientId)->get();

        // Tambahkan data pengguna ke dalam model surat
        $letter->recipientsData = $recipients;

        // Ambil data pengguna notulis
        $notulisUser = User::find($letter->notulis);

        // Tambahkan data pengguna notulis ke dalam model surat
        $letter->notulisUserData = $notulisUser;

        // Hitung jumlah surat untuk setiap letter_type_id
        if (!isset($letterCounts[$letter->letter_type_id])) {
            $letterCounts[$letter->letter_type_id] = 1;
        } else {
            $letterCounts[$letter->letter_type_id]++;
        }

        // Mengembalikan tampilan halaman detail hasil rapat dengan data surat, jenis surat, hasil rapat, pengguna, dan jumlah surat untuk setiap jenis surat
        return view('result.detail', compact('letter', 'letterCounts', 'users', 'result'));
    }

    // pencarian surat
    public function search(Request $request)
    {
        $keyword = $request->input('name');
        $letters = letter::where('letter_perihal', 'like', "%$keyword%")->orderBy('letter_type_id', 'ASC')->simplePaginate(5);
        $letterTypes = letter_type::get(); 
        $results = Result::get();

        // Inisialisasi array untuk menyimpan jumlah surat untuk setiap letter_type_id
        $letterCounts = [];

        foreach ($letters as $letter) {
            
            // Parse kolom recipients (asumsi dalam bentuk array)
            $recipientId = json_decode($letter->recipients, true);
            
            $letterTypeId = letter_type::find($letter->letter_type_id);
            
            // Tambahkan data pengguna ke dalam model surat
            $letter->letterTypeId = $letterTypeId;
            
            // Ambil data pengguna berdasarkan ID
            $recipients = User::whereIn('id', $recipientId)->get();
            
            // Tambahkan data pengguna ke dalam model surat
            $letter->recipientsData = $recipients;
            
            // Ambil data pengguna notulis
            $notulisUser = User::find($letter->notulis);

            // Tambahkan data pengguna notulis ke dalam model surat
            $letter->notulisUserData = $notulisUser;

            // Hitung jumlah surat untuk setiap letter_type_id
            if (!isset($letterCounts[$letter->letter_type_id])) {
                $letterCounts[$letter->letter_type_id] = 1;
            } else {
                $letterCounts[$letter->letter_type_id]++;
            }
        }
    
        // Mengembalikan tampilan hasil pencarian dengan data surat, hasil rapat, jenis surat, dan jumlah surat untuk setiap jenis surat
        return view('result.index',  compact('letters', 'results', 'letterTypes', 'letterCounts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(result $result)
    {
        //
    }
}
