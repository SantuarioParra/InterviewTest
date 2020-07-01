<?php


namespace App\Services\Product;


use App\Product;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductService
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     *
     * @param $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function showAllProduct($itemsPerPage)
    {
        try {
            return $this->product->withoutTrashed()->where('status','!=',false)->paginate($itemsPerPage);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }
    /**
     * @param $validatedRequest
     * @return JsonResponse
     */
    public function createProduct($validatedRequest)
    {
        try {
            $validatedRequest['slug'] = str_replace(' ', '-', $validatedRequest['slug']);
            return $this->product->create($validatedRequest) ?
                response()->json(['message' => trans('messages.201_CREATE_PRODUCT')], 201) :
                response()->json(['message' => trans('messages.400_CREATE_PRODUCT')], 400);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $validatedRequest
     * @param $id
     * @return JsonResponse
     */
    public function updateProduct($validatedRequest, $id)
    {
        try {
            $validatedRequest['slug'] = str_replace(' ', '-', $validatedRequest['slug']);
            return $this->product->findOrFail($id)->fill($validatedRequest)->save() ?
                response()->json(['message' => trans('messages.200_UPDATE_PRODUCT')], 200) :
                response()->json(['message' => trans('messages.400_UPDATE_PRODUCT')], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_PRODUCT_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteProduct($id)
    {
        try {
            return $this->product->findOrFail($id)->delete() ?
                response()->json(['message' => trans('messages.200_DELETE_PRODUCT')], 200) :
                response()->json(['message' => trans('messages.400_DELETE_PRODUCT')], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_PRODUCT_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function restoreProduct($id)
    {
        try {
            return $this->product->withTrashed()->findOrFail($id)->restore() ?
                response()->json(['message' => trans('messages.200_RESTORE_PRODUCT')], 200) :
                response()->json(['message' => trans('messages.400_RESTORE_PRODUCT')], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_PRODUCT_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

    /**
     * @param $value
     * @return JsonResponse
     */
    public function showProduct($value)
    {
        try {
            if (is_numeric($value)) {
                $product = $this->product->withoutTrashed()->find($value);
                return $product != null ?
                    response()->json(['product' => $product], 200) :
                    response()->json(['message' => trans('messages.404_PRODUCT_NOT_FOUND')], 404);
            } else {
                $product = $this->product->withoutTrashed()->where('slug', $value)->first();
                return $product != null ?
                    response()->json(['product' => $product], 200) :
                    response()->json(['message' => trans('messages.404_PRODUCT_NOT_FOUND')], 404);
            }
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR')], 500);
        }
    }

}
