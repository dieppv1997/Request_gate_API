<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id');
            $table->text('content');
            $table->dateTime('due_date');
            $table->integer('user_id');
            $table->integer('admin_id');
            $table->enum('status_admin',['Open','In progress','Close']);
            $table->enum('status_manager',['Approve','Reject']);
            $table->enum('priority',['High','Medium','Low']);
            $table->integer('department_id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('title');
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
