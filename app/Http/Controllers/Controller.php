<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\Wash;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function index(){
		return view('welcome');
	}

	//Simple
	public function submit(Request $request){
		$license = $request->get('license');
		$truckBed = $request->get('truckBed');
		$vehicle_type = $request->get('vehicle_type');
		$truckMud = $request->get('truckMud');

		if ($this->checkForStolenPlates($license) === true){
			return new JsonResponse(['error' => 'Vehicle Is Stolen! No Car Wash For You!']);
		}

		if (isset($truckBed) && $truckBed == "true"){
			return new JsonResponse(['error' => 'Your Truck Bed Is Down, No Car Wash For You!']);
		}

		//Creating new vehicle db entry and checking for values
		$vehicle = Vehicle::where('license_plate', '=', $license)->first();
		if (!isset($vehicle)){
			$vehicle = new Vehicle();
			if ($vehicle_type === 'Truck'){
				$vehicle->type = 'Truck';
			}else{
				$vehicle->type = 'Car';
			}
			$vehicle->license_plate = $license;
			$vehicle->save();
		}

		//Vehicle is now made, now make a wash
		$wash = new Wash();
		$wash->vehicle_id = $vehicle->id;
		//Save has to be done twice to setup the relationship between the two models, setPrice relies on the vehicle -> wash relationship
		$wash->save();
		$wash->setPrice($truckMud);
		$wash->save();

		return new JsonResponse(['success' => 'Your vehicle will now be washed', 'license' => $license]);
	}

	public function transactionHistory($license){
		$vehicle = Vehicle::where('license_plate', '=', $license)->first();
		return view('transactionHistory')->with('transactions', $vehicle->washes()->orderBy('created_at', 'DESC')->get());
	}

	//This is broken out into its own function so that more license plates may be added in the future without cluttering submit form (might also have to hit an external API / DB in a real world case)
	public function checkForStolenPlates($license){
		if ($license == '1111111'){
			return true;
		}else{
			return false;
		}
	}



}
