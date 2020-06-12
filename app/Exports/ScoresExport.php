<?php

namespace App\Exports;

use App\Course;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use App\Exports\Sheets\ScoresPerCourseSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ScoresExport extends DefaultValueBinder implements WithMultipleSheets, WithCustomValueBinder
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $courses = Course::whereAssistantId(Auth::id())->get();
        foreach ($courses as $course) {
            $sheets[] = new ScoresPerCourseSheet($course->id, $course->name . '-' . $course->class);
        }

        return $sheets;
    }

    /**
     * Bind value to a cell.
     *
     * @param Cell $cell Cell to bind value to
     * @param mixed $value Value to bind in cell
     *
     * @return bool
     */
    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
