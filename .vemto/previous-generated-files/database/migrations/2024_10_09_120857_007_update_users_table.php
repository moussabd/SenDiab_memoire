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
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname')->after('firstname');
            $table
                ->integer('age')
                ->nullable()
                ->after('profile_photo_path');
            $table->date('date_of_birth')->nullable();
            $table
                ->string('place_of_birth')
                ->nullable()
                ->after('date_of_birth');
            $table->string('telephone')->after('place_of_birth');
            $table
                ->string('cni')
                ->nullable()
                ->after('telephone');
            $table
                ->string('address')
                ->nullable()
                ->after('cni');
            $table
                ->enum('civility', ['Mme', 'M.', 'Mlle'])
                ->default('M.')
                ->nullable()
                ->after('address');
            $table
                ->enum('gender', ['male', 'female', 'other'])
                ->default('male')
                ->nullable()
                ->after('civility');
            $table
                ->timestamp('deleted_at')
                ->nullable()
                ->after('created_at');
            $table->renameColumn('firstname', 'firstname');
            $table->renameColumn('firstname', 'firstname');
            $table->string('phone_number')->after('age');
            $table
                ->string('firstname')
                ->nullable()
                ->after('phone_number');
            $table
                ->string('lastname', 255)
                ->nullable()
                ->change();
            $table->dropColumn('phonenumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('lastname');
            $table->dropColumn('age');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('place_of_birth');
            $table->dropColumn('telephone');
            $table->dropColumn('cni');
            $table->dropColumn('address');
            $table->dropColumn('civility');
            $table->dropColumn('gender');
            $table->dropColumn('deleted_at');
            $table->renameColumn('firstname', 'firstname');
            $table->renameColumn('firstname', 'firstname');
            $table->dropColumn('phone_number');
            $table->dropColumn('firstname');
            $table->string('lastname', 255)->change();
            $table->string('phonenumber', 255)->after('date_of_birth');
        });
    }
};
