<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

	public function scores() {
		return $this->hasMany('App\Score', 'id', 'course_id');
	}
}
