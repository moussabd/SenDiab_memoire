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
        Schema::table('doctor_patient', function (Blueprint $table) {
            $table
                ->timestamp('deleted_at')
                ->nullable()
                ->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_patient', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
};
