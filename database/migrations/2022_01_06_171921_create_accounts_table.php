<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->string('address')->nullable();
            $table->boolean('checked')->default(false);
            $table->text('description')->nullable();
            $table->string('interest')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('email')->unique();
            $table->string('account')->unique();
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
        Schema::dropIfExists('accounts');
    }
}
