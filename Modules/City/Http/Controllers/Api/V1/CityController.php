<?php

namespace Modules\City\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\StoreRequest;
use Modules\City\Http\Requests\UpdateRequest;
use Modules\City\Transformers\CityResource;
use Modules\Province\Entities\Province;

class CityController extends Controller
{
    /**
     * Return All Cities with paginate
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $provinces = City::paginate();
        return successResponse([
            'cities' => CityResource::collection($provinces->load('province')),
            'links' => CityResource::collection($provinces)->response()->getData()->links,
            'meta' => CityResource::collection($provinces)->response()->getData()->meta,
        ], 200);
    }

    /**
     * store city
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $province = Province::findOrFail($request->province_id);
        $city = $province->cities()->create([
            'name' => $request->name,
        ]);
        DB::commit();
        return successResponse(['city' => new CityResource($city)], 201, 'شهرستان با موفقیت ایجاد شد.');
    }

    /**
     * Show the specified resource.
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(City $city)
    {
        return successResponse(['city' => new CityResource($city)], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, City $city)
    {
        $city->update([
            'name' => $request->name,
        ]);
        return successResponse(['city' => new CityResource($city)], 201, 'شهرستان مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     * @param City $city
     */
    public function destroy(City $city)
    {
        $city->delete();
        return successResponse(['city' => new CityResource($city)], 200, 'شهرستان مورد نظر با موفقیت حذف شد.');
    }

}
