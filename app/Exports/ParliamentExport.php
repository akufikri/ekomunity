<?php

namespace App\Exports;

use App\Models\Parliament;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParliamentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Parliament::select("id", "id_state", "code", "parliament", "description", "is_active")->get();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["ID", "ID State", "Code", "Parlimen", "Description", "Status"];
    }
}
