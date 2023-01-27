<?php

namespace App\Imports;

use App\Models\Property;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PropertiesImport implements ToModel,WithBatchInserts,WithChunkReading,WithHeadingRow,WithValidation,ShouldQueue
{
    use Importable;

    public function batchSize(): int
    {
        return 100;
    }


    public function chunkSize(): int
    {
        return 100;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function rules(): array
    {
    return [
        'name'             => 'required|max:35',
        'owner'            => 'required|max:35',
        'line_1'            => 'required',
        'line_2'            => 'required',
        'postcode'            => 'required',
    ];
 
    }


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Property([
            "name" => $row["name"],
            "owner" => $row["owner"],
            "address_1" => $row["line_1"],
            "address_2" => $row["line_2"],
            "postcode" => $row["postcode"],
        ]);
    }
}
