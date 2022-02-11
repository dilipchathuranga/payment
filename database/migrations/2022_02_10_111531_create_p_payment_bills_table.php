<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePPaymentBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_payment_bills', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->integer('bill_id');
            $table->date('invoice_date');
            $table->integer('project_id');
            $table->integer('supplier_id');
            $table->string('bill_refference');
            $table->string('pic_no')->nullable();
            $table->decimal('amount',$precision = 12, $scale = 2);
            $table->date('received_date');
            $table->text('status')->default(0);
            $table->text('priority')->default('D');
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
        Schema::dropIfExists('p_payment_bills');
    }
}
