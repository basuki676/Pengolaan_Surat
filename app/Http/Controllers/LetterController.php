<?php

namespace App\Http\Controllers;

use App\Models\result;
use App\Models\letter;
use App\Models\letter_type;
use App\Models\User;
use Illuminate\Http\Request;
use Excel;
use PDF;
use App\Exports\AllLetterExport;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // Mendapatkan data surat dari database dengan urutan berdasarkan letter_type_id secara ascending dan paginasi 5 surat
    public function getLetters()
    {
        // Mengambil data dari database
        $letters = Letter::orderBy('letter_type_id', 'ASC')->simplePaginate(5);
        $letterTypes = letter_type::get(); 
        $results = Result::get();

        // Inisialisasi array untuk menyimpan jumlah surat untuk setiap letter_type_id
        $letterCounts = [];

        // Loop melalui setiap surat untuk melakukan beberapa operasi tambahan
        foreach ($letters as $letter) {

            // Parse kolom recipients (asumsi dalam bentuk array)
            $recipientId = json_decode($letter->recipients, true);

            // Ambil data klasifikasi berdasarkan letter_type_id
            $letterTypeId = letter_type::find($letter->letter_type_id);

            // Tambahkan data klasifikasi ke dalam model surat
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

        // Mengembalikan tampilan dengan data surat, hasil, jenis surat, dan jumlah surat untuk setiap jenis surat
        return view('letter.letters.index', compact('letters', 'results', 'letterTypes', 'letterCounts'));
    }

    // Fungsi pencarian surat berdasarkan kata kunci pada field letter_perihal
    public function searchLetters(Request $request)
    {
        $keyword = $request->input('name');
        $letters = letter::where('letter_perihal', 'like', "%$keyword%")->orderBy('letter_type_id', 'ASC')->simplePaginate(5);
        $letterTypes = letter_type::get(); // Mengasumsikan bahwa LetterType adalah model untuk tabel letter_types
        $results = Result::get();

        // Inisialisasi array untuk menyimpan jumlah surat untuk setiap letter_type_id
        $letterCounts = [];

        foreach ($letters as $letter) {
            // Parse kolom recipients (asumsi dalam bentuk array)
            $recipientId = json_decode($letter->recipients, true);

            // Ambil data klasifikasi berdasarkan letter_type_id
            $letterTypeId = letter_type::find($letter->letter_type_id);

            // Tambahkan data klasifikasi ke dalam model surat
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

        // Mengembalikan tampilan hasil pencarian dengan data surat, hasil, jenis surat, dan jumlah surat untuk setiap jenis surat
        return view('letter.letters.index', compact('letters', 'results', 'letterTypes', 'letterCounts'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createLetters()
    {
        $classificate = letter_type::get();
        $user = User::where('role', 'guru')->get();

        // Mengembalikan tampilan formulir pembuatan surat dengan data jenis surat dan data pengguna dengan peran 'guru'
        return view('letter.letters.createLetter.create', compact('user', 'classificate'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_type_id' => 'required',
            'letter_perihal' => 'required',
            'recipients' => 'required|array',
            'content' => 'required',
            'notulis' => 'required'
        ]);
        
        // Menyimpan data surat ke dalam database
        letter::create([
            'letter_type_id' => $request->letter_type_id,
            'letter_perihal' => $request->letter_perihal,
            'recipients' => json_encode($request->recipients), // Simpan sebagai JSON
            'content' => $request->content,
            'attachment' => $request->attachment,
            'notulis' => $request->notulis
        ]);

        // Mengarahkan pengguna ke halaman data surat dengan pesan sukses
        return redirect()->route('letter.letters.data')->with('success', 'Berhasil Menambahkan Surat Baru!');
    }

    // Mengunduh surat dalam format PDF berdasarkan ID
    public function downloadPDF($id)
    {
        set_time_limit(300); // Set batas waktu menjadi 5 menit

        // get data yang akan ditampilkan di pdf
        $letter = letter::find($id);
        
        $letterTypes = letter_type::get(); // Mengasumsikan bahwa LetterType adalah model untuk tabel letter_types
        // Inisialisasi array untuk menyimpan jumlah data letter untuk setiap jenis surat
        $letterCounts = [];

        // Mendekode data penerima (recipients) dari format JSON ke dalam array asosiatif
        $recipientId = json_decode($letter->recipients, true);

        // Mengambil data pengguna dengan ID yang sesuai dari array penerima, hanya untuk pengguna dengan peran 'guru'
        $users = User::whereIn('id', $recipientId)->where('role', 'guru')->get();
        
        // Parse kolom recipients (asumsi dalam bentuk array)
        $recipientId = json_decode($letter->recipients, true);
        
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
        
        // buat nama file sesuai dengan letter_perihal
        $name = $letter->letter_perihal;

        // lokasi dan nama blade yang akan di-download ke pdf serta data yang akan ditampilkan
        $pdf = PDF::loadView('letter.letters.download', compact('letter', 'letterCounts', 'users'));

        // ketika di-download, nama file nya apa
        return $pdf->download($name . '.pdf');
    }

    // Mengunduh data surat dalam format Excel
    public function downloadExcel()
    {
        $file_name = 'Data Surat.xlsx';

        // Mengembalikan file Excel untuk diunduh
        return Excel::download(new AllLetterExport, $file_name);
    }



    /**
     * Display the specified resource.
     */
    public function show(letter $letter, $id)
    {
        $letter = letter::find($id);
        $letterTypes = letter_type::get(); // Mengasumsikan bahwa LetterType adalah model untuk tabel letter_types
        // Inisialisasi array untuk menyimpan jumlah data letter untuk setiap jenis surat
        $letterCounts = [];
        $recipientId = json_decode($letter->recipients, true);
        $users = User::whereIn('id', $recipientId)->where('role', 'guru')->get();
        $result = result::where('letter_id', $id)->first();

        // Tambahkan data pengguna ke dalam model surat
        $letter->letterResult = $result;

        // Parse kolom recipients (asumsi dalam bentuk array)
        $recipientId = json_decode($letter->recipients, true);

        // ambil data klasifikasi berdasarkan letter_type_id
        $letterTypeId = letter_type::find($letter->letter_type_id);

        // Tambahkan data klasifikasi ke dalam model surat
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

        // Mengembalikan tampilan halaman detail surat dengan data surat, jenis surat, jumlah surat untuk setiap jenis surat, dan data pengguna dengan peran 'guru'
        return view('letter.letters.result', compact('letter', 'letterCounts', 'users', 'result'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $letterType = letter_type::get();
        $letters = letter::find($id);
        $user = User::where('role', 'guru')->get();

        // Mengembalikan tampilan formulir pengeditan surat dengan data surat, jenis surat, dan data pengguna dengan peran 'guru'
        return view('letter.letters.edit', compact('user', 'letters', 'letterType'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, letter $letter, $id)
    {
        $request->validate([
            'letter_type_id' => 'required',
            'letter_perihal' => 'required',
            'recipients' => 'required|array',
            'content' => 'required',
            'notulis' => 'required'
        ]);

         // Memperbarui data surat dalam database
        letter::where('id', $id)->update([
            'letter_type_id' => $request->letter_type_id,
            'letter_perihal' => $request->letter_perihal,
            'recipients' => json_encode($request->recipients), // Simpan sebagai JSON
            'content' => $request->content,
            'attachment' => $request->attachment,
            'notulis' => $request->notulis
        ]);

        // Mengarahkan pengguna ke halaman data surat dengan pesan sukses
        return redirect()->route('letter.letters.data')->with('success', 'Berhasil Mengubah Data Surat!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // cari dan hapus data
        letter::where('id', $id)->delete();
        
        return redirect()->back()->with('delete', 'Berhasil Menghapus Data Surat');
    }
}
