<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	protected $connection = 'pgsql';

	protected $table = 't_xs_zxs';
}
