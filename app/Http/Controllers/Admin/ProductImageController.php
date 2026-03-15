<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function destroy(ProductImage $image)
    {
        $productId = $image->product_id;

        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()
            ->route('admin.products.edit', $productId)
            ->with('success', 'Imagen eliminada correctamente.');
    }
}