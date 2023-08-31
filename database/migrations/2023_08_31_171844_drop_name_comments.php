<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->renameColumn('assingee_id', 'assignee_id');
            $table->renameColumn('assigner_id', 'receiver_id');
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->renameColumn('assignee_id', 'assingee_id');
            $table->renameColumn('receiver_id', 'assigner_id');
        });
    }
}
