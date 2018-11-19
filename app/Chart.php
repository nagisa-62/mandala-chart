<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    //
    protected $fillable = ['chart_number', 'chart_name', 'user_id'];
    
    public function tableGroups() {
        return $this->hasMany('App\TableGroup');
    }
    
}
