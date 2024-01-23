<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserVerification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create("user_verification", function (Blueprint $table) {
            $table->id();
            $table->string("verificationToken")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->string("userName");
            $table->string("userEmail");
            $table->timestamp("startVerification")->nullable();
            $table->timestamp("expireVerification")->nullable();
            $table->enum("emailStatus", ["true", "false"])->default("false");
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
        Schema::dropIfExists("user_verification");
    }
}
