<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wash extends Model
{

	protected $table = "washes";

	public function vehicle(){
		return $this->hasMany('App\Vehicle', 'id', 'vehicle_id');
	}

	public function setPrice($bedMud = null)
	{
		//Get base price based on type
		switch ($this->vehicle()->first()->type) {
			case 'truck':
				$price = 10;
				if ($bedMud == 'true') {
					$price += 2;
				}
				break;
			case 'car':
				$price = 5;
				break;
			default:
				//This should never happen because of the fact that every wash has a vehicle, and every vehicle has one of the above types.
				return null;
				break;
		}

		//Apply 50% discount if applicable
		if ($this->vehicle()->first()->existingCustomer() === true) {
			$price = $price / 2;
		}

		//Save the price to the car wash
		$this->price = $price;
		$this->save();
	}
}
