<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->string('name');
            $table->unsignedBigInteger('assigner');
            $table->foreign("assigner")->references("id")->on("users")->onDelete("cascade");
            $table->integer('user_id')->nullable();
            $table->integer('priority')->default(0);
            $table->string('description')->nullable();
            $table->integer('likes')->default(0);
            $table->boolean('completed')->default(false);
            $table->boolean('late')->default(false);
            $table->timestamp('due_date')->nullable();
            $table->string('task_reply')->nullable();
            // $table->date('due_date')->nullable();
            $table->date('date_submit')->nullable();
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
        Schema::dropIfExists('task');
    }
}
