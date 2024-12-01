<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\ApiController;
use App\Http\Requests\api\StoreProductRequest;
use App\Http\Requests\api\UpdateProductRequest;
use App\Services\ProductService;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends ApiController
{


    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        try {
            $products = $this->productService->getAllProducts();
            return $this->sendSuccess($products);
        } catch (Exception $e) {
            return $this->sendError('Ürünler listelenirken bir hata oluştu.', 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->findProductById((int)$id);
            return $this->sendSuccess($product);
        } catch (Exception $e) {
            return $this->sendError(['message' => 'Ürün bulunamadı.'], 404);
        }
    }

    public function store(StoreProductRequest $request)
    {
        $data = $this->productService->storeProduct($request->validated());

        return $this->sendSuccess($data, 201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image');
            }

            $product = $this->productService->updateProduct($id, $data);

            return $this->sendSuccess($product, 200);
        } catch (\Exception $e) {
            return $this->sendError(['message' => 'Güncelleme sırasında bir hata oluştu.'], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $this->productService->deleteProduct($id);
            return response()->json(['success' => true, 'message' => 'Ürün başarıyla silindi.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
