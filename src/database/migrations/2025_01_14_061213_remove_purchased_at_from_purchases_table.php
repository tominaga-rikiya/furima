<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePurchasedAtFromPurchasesTable extends Migration
{
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('purchased_at'); // purchased_atカラムを削除
        });
    }

    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->timestamp('purchased_at')->nullable(); // ロールバック時に再追加
        });
    }
}
