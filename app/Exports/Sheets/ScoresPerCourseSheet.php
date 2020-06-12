<?php

namespace App\Exports\Sheets;

use App\Score;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ScoresPerCourseSheet implements FromQuery, WithTitle, WithHeadings
{
    private $_courseName;

    private $_courseId;

    public function __construct($courseId, $courseName)
    {
        $this->_courseId = $courseId;
        $this->_courseName = $courseName;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return Score::query()
            ->whereCourseId($this->_courseId)
            ->select('course_id', 'card_id', 'name', 'score')
            ->orderBy('card_id');
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->_courseName;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['课程ID', '学号', '姓名', '成绩'];
    }
}
