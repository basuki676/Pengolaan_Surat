<?php

namespace App\Exports;

use App\Models\letter;
use Maatwebsite\Excel\Concerns\FromCollection;
// untuk menggunakan func Headings
use Maatwebsite\Excel\Concerns\WithHeadings;
// untuk menggunakan func map
use Maatwebsite\Excel\Concerns\WithMapping;


class AllLetterExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return letter::with('letter')->get();
    }

    public function headings() : array
    {
        return [
            "Nomor Surat", "Perihal", "Tanggal Keluar", "Penerima Surat", "Notulis", "Hasil Rapat"
        ];
    }

    // map = memanipulasi data databases sebelum di tampilkan ke excel
    public function map($letter) : array
    {
            return [
                $letter ['letter_type_id'],
                $letter ['letter_perihal'],
                $letter ['created_at'],
                $letter ['recipients'],
                $letter ['notulis'],
                'Belum Dibuat',
            ];
        
    }
}
