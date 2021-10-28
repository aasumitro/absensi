<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')
                ->constrained('departments')
                ->onDelete('CASCADE');

            $table->enum('display', ['DASHBOARD', 'DEVICE'])
                ->default('DASHBOARD');
            $table->string('name');
            $table->string('unique_id')
                ->unique();
            $table->string('device_id')
                ->unique()
                ->nullable();
            $table->decimal('latitude', 10, 8)
                ->nullable();
            $table->decimal('longitude', 11, 8)
                ->nullable();
            $table->string('password');

            $table->enum('refresh_time_mode', ['MINUTES', 'SECONDS'])
                ->default('MINUTES');
            $table->integer('refresh_time')
                ->default(1)->comment('if RTM === SECOND ? 60(s) : 1(m)');
            $table->string('session_token');

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
        Schema::dropIfExists('devices');
    }
}
