<?php

namespace App\Imports;

use App\Imports\Sheets\ScoresPerCourseSheet;
use App\Score;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ScoresImport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            new ScoresPerCourseSheet,
        ];
    }
}
