<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;  

class ShareModel extends Model
{
    //
    protected $table = 'share';
    protected $filename = [
    	'id_contracts',
    	'id_user_send',
    	'id_user_receive',
    	'status',
    ];

    public function contracts(){
    	return $this->belongsTo('App\ContractsModel' , 'id_contracts' , 'id');
    }

    public function usersend(){
    	return $this->belongsTo('App\User' , 'id_user_send' , 'id');
    }

    public function userreceive(){
    	return $this->belongsTo('App\User' , 'id_user_receive' , 'id');
    }
}
