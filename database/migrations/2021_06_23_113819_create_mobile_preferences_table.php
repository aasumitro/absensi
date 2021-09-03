<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attachment_id')
                ->nullable()
                ->constrained('attachments')
                ->onDelete('SET NULL');

            $table->string('action_link')
                ->nullable();
            $table->string('title')
                ->nullable();
            $table->string('description')
                ->nullable();
            $table->dateTime("live_date_show")
                ->nullable();
            $table->dateTime("live_date_hide")
                ->nullable();

            $table->enum("type", ['SLIDER', 'ANNOUNCEMENT']);
            // display as popup
            $table->integer('popup')->default(0);
            // display as banner
            $table->integer('banner')->default(0);

            $table->enum("status", ['SHOW', 'HIDE']);

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
        Schema::dropIfExists('mobile_preferences');
    }
}
