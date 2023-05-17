<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_profile', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('bio')->nullable();
            $table->string('pronounce', 100)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->integer('user_id')->nullable()->comment('LOOKUP users.id');
            $table->string('color', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_profile');
    }
};
