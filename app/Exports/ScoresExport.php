<?php

namespace App\Exports;

use App\Score;
use App\Course;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ScoresExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Score::join('courses', function ($join) {
            $join->on('scores.course_id', 'courses.id')
                ->where('courses.assistant_id', Auth::id());
        })
            ->select('course_id', 'courses.name AS course', 'class', 'card_id', 'scores.name', 'score')
            ->orderBy('card_id')
            ->get();
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

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['课程ID', '课程名称', '班级', '学号', '姓名', '成绩'];
    }
}
