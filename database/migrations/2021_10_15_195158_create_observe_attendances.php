<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObserveAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observe_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')
                ->nullable()
                ->constrained('attendances')
                ->onDelete('CASCADE');
            $table->bigInteger('department_id');
            $table->bigInteger('user_id');
            $table->date('date');
            $table->dateTime('datetime')->nullable();
            $table->text('data');
            $table->enum('type', ['ABSENT', 'IN', 'OUT'])->default('IN');
            $table->enum('type_detail', ['NONE', 'SAKIT', 'CUTI', 'TANPA KETERANGAN'])->default('NONE');
            $table->enum('status', ['NONE', 'ON_TIME', 'OVERTIME'])->default('NONE');
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
        Schema::dropIfExists('observe_attendances');
    }
}
