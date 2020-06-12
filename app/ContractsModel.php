<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractsModel extends Model
{
    //
    protected $table = 'contracts';
    protected $filename = [
    	'name',
    	'description',
    	'value',
    	'contract_id',
    	'user_id'
    ];

    public function user(){
    	return $this->belongsTo('App\User' , 'user_id' , 'id');
    }

    public function share(){
        return $this->hasMany('App\ShareModel' , 'id_contracts' , 'id');
    }

}
