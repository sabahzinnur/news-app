<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_credentials', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')
                ->nullable('false')
                ->comment('Related user id');
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('patronymic')->nullable();
            $table->date('birthday')->nullable();
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
        Schema::dropIfExists('users_credentials');
    }
}
