<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();

            // token as credentials (device & service)
            $table->string('fcm_token')
                ->nullable();
            $table->string('phone_id')
                ->nullable()
                ->unique();
            $table->string('telegram_id')
                ->nullable()
                ->unique();

            // credentials (access) and profile data
            $table->enum('as', [
                'NONE', 'PNS', 'THL'
            ])->default('NONE');
            $table->string('avatar')->nullable();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')
                ->nullable()
                ->unique();
            $table->string('phone')
                ->nullable()
                ->unique();
            $table->enum('status', [
                'ACTIVE', 'INACTIVE'
            ])->default('ACTIVE');

            // one-time-password section
            $table->string('passwordless')->nullable();
            $table->timestamp('passwordless_expiry')->nullable();

            // attend token section
            $table->string('attend_token')->nullable();
            $table->timestamp('attend_token_expiry')->nullable();

            // integration code token
            $table->string('integration_code')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
