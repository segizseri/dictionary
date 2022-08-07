<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $countries = Country::all();
        return response()->json([
            "success" => true,
            "message" => "Country list",
            "data" => $countries
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $lang = [];
        $input = $request->all();
        if (isset($input['lang'])) {
            $lang[] = $input['lang'];
            unset($input['lang']);
        }
        $country = Country::create($input);
        $country->languages()->attach($lang);
        return response()->json([
            'success' => true,
            'city' => $country,
            'message' => 'Country created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Country $country): \Illuminate\Http\JsonResponse
    {
        if (is_null($country)) {
            return $this->sendError('City not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "Country found successfully.",
            "data" => $country,
            "languages" => $country->languages
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Country $country)
    {
        $input = $request->all();
        if (isset($input['lang'])) {
            $lang[] = $input['lang'];
            unset($input['lang']);
            $country->languages()->sync($lang);
        }

        $country->update($input);

        return response()->json([
            "success" => true,
            "message" => "Country updated successfully.",
            "data" => $country
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json([
            "success" => true,
            "message" => "Country deleted successfully.",
            "data" => $country
        ]);
    }
}
