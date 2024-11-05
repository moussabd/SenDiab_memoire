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
        Schema::table('parameter', function (Blueprint $table) {
            $table
                ->longText('notification_min')
                ->nullable()
                ->after('min_value');
            $table
                ->longText('notification_max')
                ->nullable()
                ->after('notification_min');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parameter', function (Blueprint $table) {
            $table->dropColumn('notification_max');
            $table->renameColumn('notification_min', 'notification');
        });
    }
};
