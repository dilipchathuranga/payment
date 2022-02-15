<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_bank_account_attachment extends Model
{
    protected $table = 'm_bank_account_attachments';
    protected $fillables = ['bank_id', 'supplier_id', 'document_main', 'document_path'];

    public function bank(){

        return $this->belongsTo(m_bank::class, 'bank_id', 'id');

    }

    public function bank_account(){

        return $this->belongsTo(m_bank_account::class, 'supplier_id', 'id');

    }
}


