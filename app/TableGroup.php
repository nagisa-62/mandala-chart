<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableGroup extends Model
{
    //
    protected $fillable = ['table_number', 'chart_id'];

    public function cells() {
        return $this->hasMany('App\Cell');
    }
    
}
