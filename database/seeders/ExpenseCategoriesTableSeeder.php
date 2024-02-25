<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            "Food/Raw Materials",
            "Utilities",
            "Labor",
            "Equipment",
            "Maintenance/Repairs",
            "Marketing",
            "Salaries",
            "Rent",
            "Gas Refill",
            "Data/Airtime",
            "Non-Alcoholic Beverages",
            "Alcoholic Beverages",
            "Area Council/Government Fees"
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create(['name' => $category]);
        }
    }
}

