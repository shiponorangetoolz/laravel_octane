<?php

namespace App\Imports;

use App\Helper\Helpers;
use App\Models\File;
use Illuminate\Support\Collection;
use Laravel\Octane\Facades\Octane;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FileImport implements ToCollection
{

    public function collection(Collection $collection)
    {
        // TODO: Implement collection() method.
    }
}
