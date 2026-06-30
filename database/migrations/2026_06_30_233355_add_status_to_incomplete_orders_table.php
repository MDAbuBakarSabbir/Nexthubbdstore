<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('incomplete_orders', 'status')) {
            Schema::table('incomplete_orders', function (Blueprint $table) {
                $table->string('status')->default('incomplete');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('incomplete_orders', 'status')) {
            Schema::table('incomplete_orders', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
