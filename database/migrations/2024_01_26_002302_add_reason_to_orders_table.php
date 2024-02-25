<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('reason')->nullable()->after('user_id');
            // Add the new 'reason' column after the 'user_id' column and allow it to be nullable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('reason');
            // Drop the 'reason' column if the migration is rolled back
        });
    }
};
