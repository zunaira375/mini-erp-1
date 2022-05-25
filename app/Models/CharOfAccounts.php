<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharOfAccounts extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_name', 'account_type', 'is_parent', 'parent_account_id'
    ];
}
