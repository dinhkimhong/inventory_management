<?php

namespace App\Exports;

use App\Material;
use Maatwebsite\Excel\Concerns\FromCollection;

class MaterialsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Material::all();
    }
}
