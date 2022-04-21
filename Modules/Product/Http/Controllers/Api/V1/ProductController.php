<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductImage;
use Modules\Product\Http\Requests\StoreRequest;
use Modules\Product\Http\Requests\UpdateRequest;
use Modules\Product\Transformers\V1\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(1);
        return successResponse([
            'products' => ProductResource::collection($products->load('images')),
            'links' => ProductResource::collection($products)->response()->getData()->links,
            'meta' => ProductResource::collection($products)->response()->getData()->meta,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        /**
         *Store primary image of Product
         */
        $primaryImageName = Carbon::now()->microsecond . '.' . $request->primary_image->extension();
        $request->primary_image->storeAs('images/products', $primaryImageName, 'public');

        /**
         *Store images of Product when has  in request
         */
        if ($request->has('images')) {
            $fileNameImages = [];
            foreach ($request->images as $image) {
                $imageName = Carbon::now()->microsecond . '.' . $image->extension();
                $image->storeAs('images/products', $imageName, 'public');
                array_push($fileNameImages, $imageName);
            }
        }

        /**
         *Create Product
         */
        $product = Product::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'primary_image' => $primaryImageName,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'delivery_amount' => $request->delivery_amount,
            'description' => $request->description,
        ]);

        /**
         *Create Images when has in request
         */
        if ($request->has('images')) {
            foreach ($fileNameImages as $fileNameImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage
                ]);
            }
        }
        DB::commit();
        return successResponse(new ProductResource($product->load('images')), 201, 'محصول با موفقیت ایجاد شد.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return successResponse(['product' => new ProductResource($product->load('images'))], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        DB::beginTransaction();
        /**
         *Store primary image of Product
         */
        if ($request->has('primary_image')) {
            $primaryImageName = Carbon::now()->microsecond . '.' . $request->primary_image->extension();
            $request->primary_image->storeAs('images/products', $primaryImageName, 'public');
        }
        /**
         *update images of Product when has  in request
         */
        if ($request->has('images')) {
            $fileNameImages = [];
            foreach ($request->images as $image) {
                $imageName = Carbon::now()->microsecond . '.' . $image->extension();
                $image->storeAs('images/products', $imageName, 'public');
                array_push($fileNameImages, $imageName);
            }
        }

        /**
         *update Product
         */
        $product->update([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'primary_image' => $request->has('primary_image') ? $primaryImageName : $product->primary_image,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'delivery_amount' => $request->delivery_amount,
            'description' => $request->description,
        ]);

        /**
         *update Images when has in request
         */
        if ($request->has('images')) {
            foreach ($product->images as $productImage) {
                $productImage->delete();
            }
            foreach ($fileNameImages as $fileNameImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage
                ]);
            }
        }
        DB::commit();
        return successResponse(['product' => new ProductResource($product->load('images'))], 200, 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return successResponse(['product' => new ProductResource($product)], 200, 'product deleted successfully');
    }
}
