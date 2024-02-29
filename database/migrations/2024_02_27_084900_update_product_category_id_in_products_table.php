<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

class UpdateProductCategoryIdInProductsTable extends Migration
{
    public function up()
    {
        Product::where('category', 'like', '%Alc%')->update(['product_category_id' => 9]);
        Product::where('category', 'like', '%Drinks')->update(['product_category_id' => 10]);
    }

    public function down()
    {
        // If you need to rollback, you can revert the changes here.
        // However, be cautious about the data integrity when rolling back migrations.
    }
};