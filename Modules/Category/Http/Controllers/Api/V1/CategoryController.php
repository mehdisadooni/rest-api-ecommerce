<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\StoreRequest;
use Modules\Category\Http\Requests\UpdateRequest;
use Modules\Category\Transformers\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return successResponse([
            'categories' => CategoryResource::collection($categories),
            'links' => CategoryResource::collection($categories)->response()->getData()->links,
            'meta' => CategoryResource::collection($categories)->response()->getData()->meta,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
        ]);
        DB::commit();
        return successResponse(['category' => new CategoryResource($category)], 201, 'دسته بندی با موفقیت ایجاد شد.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return successResponse(['category' => new CategoryResource($category)], 200);

    }


    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Category $category)
    {
        DB::beginTransaction();
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
        ]);
        DB::commit();
        return successResponse(['category' => new CategoryResource($category)], 201, 'دسته بندی با موفقیت ویرایش شد.');
    }

    /**
     * Display the children  resource from storage.
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function children(Category $category)
    {
        return successResponse(['category' => new CategoryResource($category->load('children'))], 200);
    }

    /**
     * Display the parent  resource from storage.
     * @param Category $category
     * @return mixed
     */
    public function parent(Category $category)
    {
        return successResponse(['category' => new CategoryResource($category->load('parent'))], 200);
    }
}
