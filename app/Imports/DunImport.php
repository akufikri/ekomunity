<?php

namespace App\Imports;

use App\Models\Dun;
use App\Models\Parliament;
use App\Models\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Log;

class DunImport implements ToModel, WithStartRow, WithHeadingRow 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if($row['1'] != "" && $row['1'] != null){
            $data = new Dun();
            $data->id_state = State::where("state", "LIKE", "%". $row['1'] ."%")->first()->id_state;
            if(!$data->id_state){
                Log::info("State ". $row['1'] ." tidak ditemukan");
                throw new \Exception();
                return;
            }

            $data->id_parliament = Parliament::where("parliament", "LIKE", "%". $row['2'] ."%")->first()->id;
            if(!$data->id_parliament){
                Log::info("Parlimen ". $row['2'] ." tidak ditemukan");
                throw new \Exception();
                return;
            }

            $cek_code = Dun::where("code", "LIKE", "%". $row['3'] ."%")->get();
            Log::info($row['3']);
            Log::info($cek_code);
            if(!$cek_code->IsEmpty()){
                $message = "Code ". $row['3'] ." sudah digunakan";
                Log::info($message);
                throw new \Exception(serialize($message));
                return;
            }

            $data->code = $row['3'];
            $data->dun = $row['4'];
            $data->description = $row['5'];
            
            return $data;
        }
    }

    public function startRow(): int
    {
        return 3;
    }

}
