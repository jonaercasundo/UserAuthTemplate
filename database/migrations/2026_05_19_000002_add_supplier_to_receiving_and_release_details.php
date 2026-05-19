<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('receiving_details', function (Blueprint $table) {
            if (!Schema::hasColumn('receiving_details', 'supplier_id')) {
                $table->unsignedBigInteger('supplier_id')->nullable()->after('product_name');
                $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            }
        });

        Schema::table('release_details', function (Blueprint $table) {
            if (!Schema::hasColumn('release_details', 'supplier_id')) {
                $table->unsignedBigInteger('supplier_id')->nullable()->after('product_name');
                $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('receiving_details', function (Blueprint $table) {
            if (Schema::hasColumn('receiving_details', 'supplier_id')) {
                $table->dropForeign(['supplier_id']);
                $table->dropColumn('supplier_id');
            }
        });

        Schema::table('release_details', function (Blueprint $table) {
            if (Schema::hasColumn('release_details', 'supplier_id')) {
                $table->dropForeign(['supplier_id']);
                $table->dropColumn('supplier_id');
            }
        });
    }
};
