<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/countries",
     * summary="Get All Country",
     * description="Get Country List",
     * operationId="GetCountryList",
     * tags={"CountryList"},
     * security={ {"bearer": {} }},
     * @OA\Parameter(
     *    description="All Country",
     *    in="path",
     *    name="",
     *    required=false,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * )
     * )
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
     * @OA\Post(
     * path="/api/countries",
     * operationId="Country",
     * tags={"Country"},
     * summary="Country",
     * description="Country create",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"title"},
     *               @OA\Property(property="title", type="text"),
     *
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Country create Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Country create Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
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
     * @OA\Get(
     * path="/api/countries",
     * summary="Get All Country",
     * description="Get Country List",
     * operationId="GetCountryList",
     * tags={"CountryList"},
     * security={ {"bearer": {} }},
     * @OA\Parameter(
     *    description="All Country",
     *    in="path",
     *    name="countryId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * )
     * )
     */
    public function show(Country $country)
    {
        if (is_null($country)) {
            return $this->sendError('Country not found.');
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
