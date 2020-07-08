<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
  protected $table = 'link_lists';

  protected $dates = ['created_at','updated_at'];

  public function user()
  {
    return $this->belongsTo(User::class,'user_id');
  }
}
