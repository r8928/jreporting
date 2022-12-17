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
        Schema::create('ssr_reports', function (Blueprint $table) {
            $table->id();

            $table->string('department')->nullable();
            $table->string('sub_department')->nullable();
            $table->string('po_number')->nullable();
            $table->string('condition')->nullable();
            $table->string('supplier')->nullable();
            $table->string('item_code')->nullable();
            $table->string('description')->nullable();
            $table->string('category')->nullable();
            $table->string('uom')->nullable();
            $table->float('center')->default(0);
            $table->float('north')->default(0);
            $table->float('south')->default(0);
            $table->float('huawei')->default(0);
            $table->float('zte')->default(0);
            $table->float('ericsson')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ssr_reports');
    }
};
