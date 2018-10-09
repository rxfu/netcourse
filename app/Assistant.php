<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assistant extends Model {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 'name', 'department_id', 'major', 'phone',
	];
}
