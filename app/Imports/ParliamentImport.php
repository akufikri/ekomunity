<?php

namespace App\Imports;

use App\Models\Parliament;
use App\Models\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Log;

class ParliamentImport implements ToModel, WithStartRow, WithHeadingRow 
// ,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // Log::info($row);
        // Log::info($row['1']);

        if($row['1'] != "" && $row['1'] != null){
            $data = new Parliament();
            $data->id_state = State::where("state", "LIKE", "%". $row['1'] ."%")->first()->id_state;

            if(!$data->id_state){
                Log::info("State ". $row['1'] ." tidak ditemukan");
                throw new \Exception();
                return;
            }

            $cek_code = Parliament::where("code", "LIKE", "%". $row['2'] ."%")->get();
            Log::info($row['2']);
            Log::info($cek_code);
            if(!$cek_code->IsEmpty()){
                $message = "Code ". $row['2'] ." sudah digunakan";
                Log::info($message);
                throw new \Exception(serialize($message));
                return;
            }

            $data->code = $row['2'];
            $data->parliament = $row['3'];
            $data->description = $row['4'];
            
            return $data;
        }
    }

    public function startRow(): int
    {
        return 3;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function rules(): array
    // {
    //     return [
    //         // 'id' => 'required',
    //         'id_state' => 'required',
    //         'code' => 'required|min:2',
    //         'parliament' => 'required|min:2|unique:tb_parliament',
    //         // 'parliament' => 'required|min:2|unique:tb_parliament',
    //         'description' => 'required',
    //         'is_active' => 'required'
    //     ];
    // }
}
