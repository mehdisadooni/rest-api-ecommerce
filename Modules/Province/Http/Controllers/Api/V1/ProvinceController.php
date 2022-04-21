<?php

namespace Modules\Province\Http\Controllers\Api\V1;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Province\Entities\Province;
use Modules\Province\Http\Requests\StoreRequest;
use Modules\Province\Http\Requests\UpdateRequest;
use Modules\Province\Transformers\ProvinceResource;

class ProvinceController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * Return All Provinces with paginate
     */
    public function index()
    {
        $provinces = Province::paginate();
        return successResponse([
            'provinces' => ProvinceResource::collection($provinces->load('cities')),
            'links' => ProvinceResource::collection($provinces)->response()->getData()->links,
            'meta' => ProvinceResource::collection($provinces)->response()->getData()->meta,
        ], 200);
    }

    /**
     * store Province
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $province = Province::create([
            'name' => $request->name,
        ]);
        DB::commit();
        return successResponse(['province' => new ProvinceResource($province)], 201, 'استان با موفقیت با موفقیت ایجاد شد.');
    }

    /**
     * Show the specified resource.
     * @param Province $province
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Province $province)
    {
        return successResponse(['province' => new ProvinceResource($province)], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Province $province
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Province $province)
    {
        $province->update([
            'name' => $request->name,
        ]);
        return successResponse(['province' => new ProvinceResource($province)], 201, 'استان مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     * @param Province $province
     */
    public function destroy(Province $province)
    {
        $province->delete();
        return successResponse(['province' => new ProvinceResource($province)], 200, 'استان مورد نظر با موفقیت حذف شد.');
    }
}
