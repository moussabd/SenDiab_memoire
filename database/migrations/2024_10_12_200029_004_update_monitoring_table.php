<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monitoring', function (Blueprint $table) {
            $table
                ->longText('comments_doctor')
                ->nullable()
                ->after('value');
            $table->renameColumn('comments', 'comments_patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monitoring', function (Blueprint $table) {
            $table->dropColumn('comments_doctor');
            $table->renameColumn('comments_patients', 'comments');
        });
    }
};
