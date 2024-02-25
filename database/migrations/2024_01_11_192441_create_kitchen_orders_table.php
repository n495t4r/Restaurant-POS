<?php

// database/migrations/xxxx_xx_xx_create_kitchen_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitchenOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('kitchen_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->text('details');
            $table->boolean('is_done')->default(false);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kitchen_orders');
    }
};
