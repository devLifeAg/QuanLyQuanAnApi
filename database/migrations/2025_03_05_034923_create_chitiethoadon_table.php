<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chitiethoadon', function (Blueprint $table) {
            $table->tinyInteger("ct_id",true,true);
            $table->tinyInteger("mon_id")->unsigned();
            $table->integer("ct_soluong");
            $table->double("ct_thanhtien");
            $table->tinyInteger("hd_id")->unsigned();
            $table->foreign('mon_id')->references('mon_id')->on('monan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('hd_id')->references('hd_id')->on('quanlyhoadon')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chitiethoadon');
        Schema::table('chitiethoadon', function (Blueprint $table) {
            $table->dropForeign(['chitiethoadon_mon_id_foreign', 'chitiethoadonhd_id_foreign']);
            $table->dropIndex(['chitiethoadon_mon_id_foreign', 'chitiethoadonhd_id_foreign']);
        });
    }
};
