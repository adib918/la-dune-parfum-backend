<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Request;

class UserAddressController extends Controller
{
    public function store(StoreAddressRequest $request){
        if(auth()->user()->address == null){
            $address = [];
            $add = ['apartment' => $request->apartment, 'floor' => $request->floor, 'building' => $request->building, 'road' => $request->road,
            'region' => $request->region, 'city' => $request->city, 'country' => $request->country];
            array_push($address, $add);
            auth()->user()->update([
                'address' => $address,
            ]);
        }else{
            $add = ['apartment' => $request->apartment, 'floor' => $request->floor, 'building' => $request->building, 'road' => $request->road,
            'region' => $request->region, 'city' => $request->city, 'country' => $request->country];
            $addresses = auth()->user()->address;
            array_push($addresses, $add);
            auth()->user()->update([
                'address' => $addresses,
            ]);
        }

        return response()->json(['message' => 'Your address has added successfully.'])->setStatusCode(200);
    }

    public function update($addressIndex, UpdateAddressRequest $request){
        $addresses = auth()->user()->address;
        $address = [
            'country' => $request->country,
            'city' => $request->city,
            'region' => $request->region,
            'road' => $request->road,
            'building' => $request->building,
            'floor' => $request->floor,
            'apartment' => $request->apartment,
        ];
        $addresses[$addressIndex] = $address;
        auth()->user()->update([
            'address' => $addresses
        ]);
        return response()->json(['message' => 'Your address has updated successfully.'])->setStatusCode(200);
    }

    public function destroy($addressIndex){
        $addresses = auth()->user()->address;
        Arr::forget($addresses, $addressIndex);
        auth()->user()->update([
            'address' => $addresses
        ]);
        return response()->json(['message' => 'Your address has removes successfully.'])->setStatusCode(200);
    }
}
