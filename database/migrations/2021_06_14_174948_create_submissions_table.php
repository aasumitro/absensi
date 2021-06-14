<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('SET NULL');
            $table->foreignId('absent_type_id')
                ->nullable()
                ->constrained('absent_types')
                ->onDelete('SET NULL');
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->onDelete('SET NULL');
            $table->foreignId('attachment_id')
                ->nullable()
                ->constrained('attachments')
                ->onDelete('SET NULL');

            $table->date('start_at');
            $table->date('end_at');
            $table->string('title');
            $table->string('description');
            $table->enum('status', [
                'ISSUED', 'ACCEPTED', 'REJECTED'
            ])->default('ISSUED');
            $table->string('notes')
                ->nullable()
                ->comment('when rejected, dont forget to make a reason');

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
        Schema::dropIfExists('submissions');
    }
}
