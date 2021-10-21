<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->char('origin_id', 50)
                ->nullable()
                ->unique();

            // relation
            $table->foreignId('timezone_id')
                ->nullable()
                ->default(2) //default WITA (2)
                ->constrained('timezones')
                ->onDelete('SET NULL');

            // data
            $table->string('name');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('max_att_in')->default('08:00');
            $table->string('min_att_out')->default('16:30');
            $table->integer('min_att_acc')->default(180)
                ->comment('minimum attend time 180min = 3 hrs; if max_att_in=08:00 AM; max_att_in-min_att_acc = 05:00 AM');
            $table->integer('max_att_acc')->default(60)
                ->comment('overtime can attend in minute');

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
        Schema::dropIfExists('departments');
    }
}
