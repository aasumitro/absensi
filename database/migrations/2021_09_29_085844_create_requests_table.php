<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->enum("type", ['SUGGEST', 'NEW_FEATURE', 'ADMIN_ACCOUNT']);
            $table->enum("status", ['NONE', 'EXIST']);
            $table->text('value');
            $table->enum("commit", [
                'ISSUED', 'ACCEPTED', 'REJECTED'
            ])->default('ISSUED');
            $table->bigInteger('commit_by');
            $table->bigInteger('recommit_by')
                ->nullable();
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
        Schema::dropIfExists('requests');
    }
}
