<?php

namespace App\Imports;

use App\Score;
use App\Course;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ScoresImport implements OnEachRow, WithStartRow
{
    /**
     * @param \Maatwebsite\Excel\Row $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        $courseId = $row[0];
        $cardId = $row[3];
        $name = $row[4];
        $score = $row[5] ?? 0;
        $exists = Course::whereAssistantId(Auth::id())
            ->whereId($courseId)
            ->exists();

        if ($exists) {
            Score::whereCourseId($courseId)
                ->whereCardId($cardId)
                ->whereIsConfirmed(false)
                ->update(['score' => $score]);
        }
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
