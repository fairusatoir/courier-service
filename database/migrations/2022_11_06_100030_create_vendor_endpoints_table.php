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
        Schema::create('vendor_endpoints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->enum('mode',['sit', 'stg', 'prod']);
            $table->string('endpoint')->nullable(false);
            $table->string('key')->nullable(true);
            $table->string('keyCallback')->nullable(true);
            $table->string('username')->nullable(true);
            $table->string('password')->nullable(true);
            $table->text('description')->nullable(true);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_endpoints');
    }
};
