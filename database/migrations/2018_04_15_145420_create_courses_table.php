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
			$table->string('name', 50);
			$table->string('class', 20);
			$table->string('campus', 10);
			$table->boolean('is_used')->default('false');
			$table->integer('assistant_id');
			$table->timestamps();

			$table->foreign('assistants_id')->references('id')->on('assistants')->onUpdate('cascade')->onDelete('cascade');
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
