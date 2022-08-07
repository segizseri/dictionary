<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    /**
     * City list
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $cities = City::all();
        return response()->json([
            "success" => true,
            "message" => "City list",
            "data" => $cities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $lang = [];
        $input = $request->all();
        if (isset($input['lang'])) {
            $lang[] = $input['lang'];
            unset($input['lang']);
        }
        $city = City::create($input);
        $city->languages()->attach($lang);
        return response()->json([
            'success' => true,
            'city' => $city,
            'message' => 'City created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(City $city): \Illuminate\Http\JsonResponse
    {
        if (is_null($city)) {
            return $this->sendError('City not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "City found successfully.",
            "data" => $city,
            "country" => $city->getCountry(),
            "languages" => $city->languages
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, City $city): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        if (isset($input['lang'])) {
            $lang[] = $input['lang'];
            unset($input['lang']);
            $city->languages()->sync($lang);
        }

        $city->update($input);

        return response()->json([
            "success" => true,
            "message" => "City updated successfully.",
            "data" => $city
        ]);
    }

    /**
     * Delete City.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(City $city): \Illuminate\Http\JsonResponse
    {
        $city->delete();
        return response()->json([
            'success' => true,
            'message' => 'City deleted successfully'
        ]);
    }
}
