<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

	protected $table = "vehicles";

	public function washes(){
		return $this->hasMany('App\Wash', 'vehicle_id', 'id');
	}

	public function existingCustomer(){
		$washes = $this->washes()->count();
		if ($washes > 1){
			return true;
		}else{
			return false;
		}
	}
}
