<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('courses', function (Blueprint $table) {
			$table->increments('id');
			$table->string('clsno', 30);
			$table->string('class', 20);
			$table->string('crsno', 8);
			$table->string('name', 50);
			$table->integer('stucount')->unsigned();
			$table->boolean('is_used')->default(false);
			$table->string('user_id')->nullable();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('courses');
	}
}
