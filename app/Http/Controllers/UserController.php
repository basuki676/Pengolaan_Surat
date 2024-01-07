<?php

namespace App\Http\Controllers;

use App\Models\letter_type;
use App\Models\letter;
use App\Models\result;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menghitung jumlah pengguna dengan peran 'staff' dan 'guru'
        $usersStaff = User::where('role', 'staff')->count();
        $usersGuru = User::where('role', 'guru')->count();

        // Menghitung jumlah seluruh klasifikasi surat dan surat
        $allClassificate = letter_type::count();
        $allLetters = letter::count();

        // Mengembalikan tampilan halaman dashboard dengan data statistik
        return view('dashboard', compact('usersGuru','usersStaff', 'allClassificate', 'allLetters'));
    }
    
    // Menampilkan data pengguna dengan peran 'guru'
    public function getDataGuru()
    {
        // Mengambil data pengguna dengan peran 'guru' dan menampilkannya dalam halaman indeks pengguna guru
        $users = User::where('role', 'guru')->orderBy('name', 'ASC')->simplePaginate(5);
        return view('user.guru.index', compact('users'));
    }

    // Menampilkan data pengguna dengan peran 'staff'
    public function getDataStaff()
    {
        // Mengambil data pengguna dengan peran 'staff' dan menampilkannya dalam halaman indeks pengguna staff
        $users = User::where('role', 'staff')->orderBy('name', 'ASC')->simplePaginate(5);
        return view('user.staff.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function createGuru()
    {
        // Mengembalikan tampilan formulir pembuatan pengguna guru
        return view('user.guru.create');
    }

    public function createStaff()
    {
        // Mengembalikan tampilan formulir pembuatan pengguna staff
        return view('user.staff.create');
    }

    //  pencarian pengguna dengan peran 'guru'
    public function searchGuru(Request $request)
    {
        $keyword = $request->input('name');

        // Mencari dan menampilkan data pengguna 'guru' yang sesuai dengan kata kunci
        $users = User::where('name', 'like', "%$keyword%")->where('role', 'guru')->orderBy('name', 'ASC')->simplePaginate(5);
        return view('user.guru.index', compact('users'));
    }

    //  pencarian pengguna dengan peran 'staff'
    public function searchStaff(Request $request)
    {
        $keyword = $request->input('name');

        // Mencari dan menampilkan data pengguna 'staff' yang sesuai dengan kata kunci
        $users = User::where('name', 'like', "%$keyword%")->where('role', 'staff')->orderBy('name', 'ASC')->simplePaginate(5);
        return view('user.staff.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|min:5',
            'role' => 'required'
        ]);

        // Ambil tiga karakter pertama dari nama dan email
        $namaUser = substr($request->name, 0, 3);
        $emailUser = substr($request->email, 0, 3);

        // Gabungkan tiga karakter pertama dari nama dan email sebagai password default
        $defaultPassword = Hash::make($namaUser . $emailUser);

        // Buat pengguna baru dengan data yang valid
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $defaultPassword
        ]);

        // Mengarahkan pengguna kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil Menambahkan Data Baru!');
    }


    /**
     * Display the specified resource.
     */
    public function show(result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        // Mendapatkan data pengguna berdasarkan ID
        $user = User::find($id);

        // Memilih tampilan pengeditan berdasarkan peran pengguna
        if ($user->role == 'staff') {
            return view('user.staff.edit', compact('user'));
        }
        else {
            return view('user.guru.edit', compact('user'));
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|min:5',
            'role' => 'required',
            'password' => 'required'
        ]);

        // Membuat hash dari password baru
        $hashedPassword = Hash::make($request->password);

        // Memperbarui data pengguna berdasarkan ID
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $hashedPassword,
        ]);

        // Mengarahkan pengguna kembali ke halaman data pengguna sesuai peran
        if ($request->role == 'staff') {
            return redirect()->route('user.staff.data')->with('success', 'Berhasil Mengubah Data Pengguna!');
        }
        else {
            return redirect()->route('user.guru.data')->with('success', 'Berhasil Mengubah Data Pengguna!');
        }

    }

    // Menangani proses login pengguna
    public function authLogin (request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // simpan data dari inputan email dan password ke dalam variable untuk memudahkan pemanggilnya
        $user = $request->only(['email', 'password']);

        // attempt : mengecek kecocokan email dan password kemudian menyimpan nya ke dalam class Auth 
        // (Memberi identitas data riwayat login ke projectnya)
        if (Auth::attempt($user)) {
            // perbedaan redirect() dan redirect()->route ?
            return redirect('/dashboard'); 
            // memanggil lewat path /
        } else {
            return redirect()->back()->with('failed', 'Login gagal! silahkan coba lagi');
        } // memanggil lewat name
    }

    //  Menangani proses logout pengguna
    public function logout(){

        // Logout pengguna dan mengarahkan ke halaman login
        Auth::logout();
        return redirect()->route('login'); 
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // cari dan hapus data
        User::where('id', $id)->delete();
        return redirect()->back()->with('delete', 'Berhasil Menghapus Data Pengguna');
    }
}
