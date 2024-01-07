<?php

namespace App\Exports;

use App\Models\letter_type;
use Maatwebsite\Excel\Concerns\FromCollection;
// untuk menggunakan func Headings
use Maatwebsite\Excel\Concerns\WithHeadings;
// untuk menggunakan func map
use Maatwebsite\Excel\Concerns\WithMapping;


class LetterExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $letterCounts;

    public function __construct($letterCounts)
    {
        $this->letterCounts = $letterCounts;
    }
    public function collection()
    {
        return letter_type::with('letters')->get();
    }

    public function headings() : array
    {
        return [
            "Kode Surat", "Klasifikasi Surat", "Surat Tertaut"
        ];
    }

    // map = memanipulasi data databases sebelum di tampilkan ke excel
    public function map($item): array
    {
        // Dapatkan jumlah surat berdasarkan letter_type_id
        $letterCount = $this->letterCounts[$item->letter_code] ?? 0;

        return [
            $item->letter_code . '-' . $letterCount,
            $item->name_type,
            $letterCount,
        ];
    }
}
