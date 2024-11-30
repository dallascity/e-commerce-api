<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAllProducts()
    {
        return Product::all();
    }
    public function findProductById(int $id)
    {
        return Product::findOrFail($id);
    }
    public function storeProduct(array $data)
    {
        // Resmi kaydet
        $imagePath = $data['image']->store('products', 'public');

        // Ürünü veritabanına kaydet
        return Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'],
            'image' => $imagePath,
        ]);
    }
    public function updateProduct(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);



        if (isset($data['image'])) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $data['image']->store('products', 'public');
        }
        $data = array_merge($product->toArray(), $data);
        $product->update($data);

        return $product;
    }
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
    }
}
