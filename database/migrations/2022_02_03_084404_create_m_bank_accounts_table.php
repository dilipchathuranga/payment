<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_id');
            $table->integer('branch_id');
            $table->integer('supplier_id');
            $table->string('supplier_name');
            $table->string('supplier_email');
            $table->string('supplier_telephone');
            $table->string('account_no');
            $table->string('account_name');
            $table->string('holder_nic');
            $table->integer('action_by');
            $table->tinyInteger('status');
            $table->tinyInteger('can_delete');
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
        Schema::dropIfExists('m_bank_accounts');
    }
}
