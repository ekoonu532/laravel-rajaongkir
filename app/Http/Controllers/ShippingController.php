<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RajaOngkirService;

class ShippingController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    public function index()
    {
        $cities = $this->rajaOngkirService->getCityList();
        return view('index', compact('cities'));
    }


    public function calculateAjax(Request $request)
    {
        $origin = 501; // ID kota Yogyakarta
        $destination = $request->input('destination');
        $weight = $request->input('weight');
        $courier = $request->input('courier');

        $cost = $this->rajaOngkirService->getCost($origin, $destination, $weight, $courier);

        return response()->json($cost);
    }
}
