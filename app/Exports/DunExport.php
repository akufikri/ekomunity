<?php

namespace App\Exports;

use App\Models\Dun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DunExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dun::select("id", "id_state", "id_parliament", "code", "dun", "description", "is_active")->get();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["ID", "ID State", "ID Parlimen", "Code", "Dun", "Description", "Status"];
    }
}
