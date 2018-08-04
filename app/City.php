<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\State;
class City extends Model
{
    use SoftDeletes;
   protected  $table = 'citys';

   public function state()
   {
       return $this->belongsTo(State::class);
   }
}
