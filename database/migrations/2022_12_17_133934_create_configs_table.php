<?php

use App\Models\Config;
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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();

            $table->string('key');
            $table->json('value')->nullable();

            $table->timestamps();
        });

        Config::create([
            'key' => 'ssr_categories',
            'value' => [
                'AC',
                'ANTENNA',
                'BATTERY',
                'CABINET',
                'DISH',
                'GENERATOR',
                'MICROWAVE-EQUIP',
                'RECTIFIER',
                'RECTIFIER MODULE',
                'REPEATER',
                'TOWER',
            ]
        ]);

        Config::create([
            'key' => 'ssr_columns_sequence',
            'value' => [
                'department',
                'sub_department',
                'po_number',
                'condition',
                'supplier',
                'item_code',
                'description',
                'category',
                'uom',
                'center',
                'north',
                'south',
                'huawei',
                'zte',
                'ericsson',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
};
