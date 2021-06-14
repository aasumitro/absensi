<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('SET NULL');
            $table->foreignId('absent_type_id')
                ->nullable()
                ->constrained('absent_types')
                ->onDelete('SET NULL');
            $table->foreignId('device_id')
                ->nullable()
                ->constrained('devices')
                ->onDelete('SET NULL');
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->onDelete('SET NULL');
            $table->foreignId('attachment_id')
                ->nullable()
                ->constrained('attachments')
                ->onDelete('SET NULL');

            $table->enum('type', [
                'NONE', 'QRCODE_SCAN', 'QRCODE_GEN', 'PICTURE'
            ])->comment('NONE for ABSENT');
            $table->enum('status', ['ATTEND', 'ABSENT']);
            $table->date('date');
            $table->dateTime('datetime_in')->nullable();
            $table->dateTime('datetime_out')->nullable();
            $table->integer('timestamp_in')->nullable();
            $table->integer('timestamp_out')->nullable();
            $table->integer('overdue')->default(0);
            $table->integer('overtime')->default(0);
            $table->enum('by', [
                'USER', 'SYSTEM', 'ADMIN/OPERATOR'
            ])->default('USER');

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
        Schema::dropIfExists('attendances');
    }
}
