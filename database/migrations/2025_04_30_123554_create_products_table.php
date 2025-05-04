<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2);
        $table->string('image')->nullable();
        $table->boolean('active')->default(true);
        $table->string('status')->default('active');
        $table->timestamps();
    });

    Schema::table('products', function (Blueprint $table) {
        $table->boolean('active')->default(1);
    });

{
    Schema::table('products', function (Blueprint $table) {
        $table->enum('type', ['product', 'workshop'])->default('product')->after('image');
    });
}


    //workshop

    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->string('image');
        $table->enum('type', ['product', 'workshop'])->default('product'); 
        $table->json('gallery')->nullable();
        $table->timestamps();
    });
    
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
    

    
};
