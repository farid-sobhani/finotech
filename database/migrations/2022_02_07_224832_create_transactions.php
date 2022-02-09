<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('deposit');
            $table->string('phone');
            $table->string('second_password');
            $table->string('description', 30);
            $table->string('destination_first_name');
            $table->string('destination_last_name');
            $table->string('destination_account_number');
            $table->string('ref_code', 30)->nullable();
            $table->time('inquiry_time')->nullable();
            $table->date('inquiry_date')->nullable();
            $table->string('message')->nullable();
            $table->string('payment_number')->nullable();
            $table->enum('type', ['internal', 'paya'])->nullable();
            $table->enum('status', ['done', 'failed','pending']);
            $table->string('error')->nullable();
            $table->string('track_id')->unique();
            $table->timestamps();
            $table->foreignId('user_id')
                ->references('id')->on('users')
                ->onDelete('SetNull');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
