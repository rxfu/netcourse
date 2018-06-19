<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('assistants', function (Blueprint $table) {
			$table->string('id');
			$table->string('username', 20);
			$table->string('password', 255);
			$table->string('name', 50);
			$table->integer('department_id')->unsigned();
			$table->string('major', 100)->nullable();
			$table->string('phone', 20);
			$table->timestamps();

			$table->primary('id');
			$table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('assistants');
	}
}
