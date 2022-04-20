<?php

namespace Modules\Brand\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Http\Requests\StoreRequest;
use Modules\Brand\Http\Requests\UpdateRequest;
use Modules\Brand\Transformers\V1\BrandResource;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::paginate(10);
        return successResponse([
            'brands' => BrandResource::collection($brands),
            'links' => BrandResource::collection($brands)->response()->getData()->links,
            'meta' => BrandResource::collection($brands)->response()->getData()->meta,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $brand = Brand::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);
        DB::commit();
        return successResponse(['brand' => new BrandResource($brand)], 201, 'برند با موفقیت ایجاد شد.');
    }

    /**
     * Show the specified resource.
     * @param Brand $brand
     */
    public function show(Brand $brand)
    {
        return successResponse(['brand' => new BrandResource($brand)], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Brand $brand
     */
    public function update(UpdateRequest $request, Brand $brand)
    {
        $brand->update([
            'name' => $request->name,
            'display_name' => $request->display_name
        ]);
        return successResponse(['brand' => new BrandResource($brand)], 201, 'برند مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     * @param Brand $brand
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return successResponse(['brand' => new BrandResource($brand)], 200, 'برند مورد نظر با موفقیت حذف شد.');
    }
}
