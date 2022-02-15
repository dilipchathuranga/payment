<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBankAccountAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_bank_account_attachments', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_id');
            $table->integer('supplier_id');
            $table->string('document_main');
            $table->string('document_path');
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
        Schema::dropIfExists('m_bank_account_attachments');
    }
}
