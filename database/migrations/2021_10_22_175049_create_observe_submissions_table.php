<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObserveSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observe_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')
                ->nullable()
                ->constrained('submissions')
                ->onDelete('CASCADE');
            $table->bigInteger('department_id');
            $table->bigInteger('user_id');
            $table->dateTime('datetime')->nullable();
            $table->text('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observe_submissions');
    }
}
