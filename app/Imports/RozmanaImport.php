<?php

namespace App\Imports;

use App\Models\Rozmana;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class RozmanaImport implements ToModel, WithHeadingRow,WithUpserts,WithValidation
{
    use Importable;
    public function __construct(public int $therapist_id)
    {
    }

    public function model(array $row)
    {
        return new Rozmana([
            'title' => $row['title'],
            'description' => $row['description'],
            'date' => $row['date'],
            'therapist_id'=>$this->therapist_id
        ]);
    }

    public function uniqueBy()
    {
       return ['therapist_id','date'];
    }

    public function rules(): array
    {
        return [
            '*.title' => 'required|string',
            '*.description' => 'required|string',
            '*.date' => 'required|date_format:d-m',
        ];
    }
}
