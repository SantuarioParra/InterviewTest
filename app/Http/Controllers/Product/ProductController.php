<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @method productService($validate)
 */
class ProductController extends Controller
{
    private $product;
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * ProductController constructor.
     * @param Product $product
     * @param ProductService $productService
     */
    public function __construct(Product $product, ProductService $productService)
    {
        $this->product = $product;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(['products'=>$this->product->showall()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        return $this->productService->createProduct($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return $this->productService->showProduct($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, $id)
    {
        return $this->productService->updateProduct($request->validated(),$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->productService->deleteProduct($id);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function restore($id)
    {
        return $this->productService->restoreProduct($id);
    }
}
