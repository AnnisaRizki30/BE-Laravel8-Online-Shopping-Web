<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductGalleryResource;
use App\Models\ProductGallery;

class ProductGalleryController extends Controller
{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 public function index()
 {
 //get galleries
 $products = Product::latest()->get();
 //return with Api Resource
 return new ProductResource(true, 'List Data Product',
 $products);
 }

 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 public function galleries()
 {
  //get galleries
 $products = Product::with('galleries.product')->latest()->get();
 //return with Api Resource
 return new ProductResource(true, 'List Data Product Galleries', $products);
 }
}
