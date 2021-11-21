<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCurrency extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'users_currency';

    public function getCurrency(){
        $record = UserCurrency::where('user_id', auth()->user()->id)->first();
        return $record->currency;
    }
}