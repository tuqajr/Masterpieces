<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('testimonials', function (Blueprint $table) {
        $table->boolean('approved')->default(false);
    });
}

public function down()
{
    Schema::table('testimonials', function (Blueprint $table) {
        $table->dropColumn('approved');
    });
}
};
