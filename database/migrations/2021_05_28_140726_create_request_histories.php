<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('request_id');
            $table->integer('category_id_before');
            $table->integer('category_id_current');
            $table->text('content_before');
            $table->text('content_current');
            $table->dateTime('due_date_before');
            $table->dateTime('due_date_current');
            $table->integer('admin_id_before');
            $table->integer('admin_id_current');
            $table->enum('status_admin_before',['Open','In progress','Close']);
            $table->enum('status_admin_current',['Open','In progress','Close']);
            $table->enum('status_manager_before',['Open','Approve','Reject']);
            $table->enum('status_manager_current',['Open','Approve','Reject']);
            $table->enum('priority_before',['High','Medium','Low']);
            $table->enum('priority_current',['High','Medium','Low']);
            $table->string('title_before');
            $table->string('title_current');
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
        Schema::dropIfExists('request_histories');
    }
}