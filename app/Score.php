<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{

	protected $casts = [
		'is_confirmed' => 'boolean',
	];

	public function course()
	{
		return $this->belongsTo('App\Course');
	}
}
