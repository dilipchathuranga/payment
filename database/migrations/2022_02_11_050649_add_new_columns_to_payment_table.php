<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_payment_bills', function (Blueprint $table) {
            $table->text('project_name')->nullable();
            $table->text('supplier_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_payment_bills', function (Blueprint $table) {
            $table->dropColumn('project_name');
            $table->dropColumn('supplier_name');
        });
    }
}
