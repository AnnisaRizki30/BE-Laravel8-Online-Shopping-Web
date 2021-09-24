<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Illuminate\Support\Str;
use App\Http\Resources\ProductGalleryResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
 $galleries = ProductGallery::with('product')->when(request()->q,
function($galleries) {
 $galleries = $galleries->where('title', 'like', '%'.
request()->q . '%');
 })->latest()->paginate(5);
 //return with Api Resource
 return new ProductGalleryResource(true, 'List Data Product Galleries',
$galleries);
 }
 /**
 * Store a newly created resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
 public function store(Request $request)
 {
 $validator = Validator::make($request->all(), [
 'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
 'product_id' => 'required',
 ]);
 if ($validator->fails()) {
 return response()->json($validator->errors(), 422);
 }
 //upload image
 $image = $request->file('image');
 $image->storeAs('public/galleries', $image->hashName());
 //create gallery
 $gallery = ProductGallery::create([
 'image' => $image->hashName(),
 'product_id' => $request->product_id,
 'user_id' => auth()->guard('api_admin')->user()->id,
 ]);
 if($gallery) {
 //return success with Api Resource
 return new ProductGalleryResource(true, 'Data Product Galleries Berhasil
Disimpan!', $gallery);
 }
 //return failed with Api Resource
 return new ProductGalleryResource(false, 'Data Product Galleries Gagal
Disimpan!', null);
 }
 /**
 * Display the specified resource.
 *
 * @param int $id
 * @return \Illuminate\Http\Response
 */
public function show($id)
 {
 $gallery = ProductGallery::whereId($id)->first();
 if($gallery) {
 //return success with Api Resource
 return new ProductGalleryResource(true, 'Detail Data Product Galleries!',
$gallery);
 }
 //return failed with Api Resource
 return new ProductGalleryResource(false, 'Detail Data Product Galleries Tidak
Ditemukan!', null);
 }
 /**
 * Update the specified resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @param int $id
 * @return \Illuminate\Http\Response
 */
 public function update(Request $request, ProductGallery $gallery)
 {
 $validator = Validator::make($request->all(), [
 'product_id' => 'required',
 ]);
 if ($validator->fails()) {
 return response()->json($validator->errors(), 422);
 }
 //check image update
 if ($request->file('image')) {
 //remove old image
Storage::disk('local')->delete('public/galleries/'.basename($gallery->image));
 //upload new image
 $image = $request->file('image');
 $image->storeAs('public/galleries', $image->hashName());
 //update product with new image
 $gallery->update([
 'image' => $image->hashName(),
 'product_id' => $request->product_id,
 'user_id' => auth()->guard('api_admin')->user()->id,
 ]);
 //update product without image
 $gallery->update([
 'product_id' => $request->product_id,
 'user_id' => auth()->guard('api_admin')->user()->id,
 ]);
 if($gallery) {
 //return success with Api Resource
 return new ProductGalleryResource(true, 'Data Product Galleries Berhasil
Diupdate!', $gallery);
 }
 //return failed with Api Resource
 return new ProductGalleryResource(false, 'Data Product Galleries Gagal
Diupdate!', null);
 }
 }
 /**
 * Remove the specified resource from storage.
 *
* @param int $id
 * @return \Illuminate\Http\Response
 */
 public function destroy(ProductGallery $gallery)
 {
 //remove image
Storage::disk('local')->delete('public/galleries/'.basename($gallery->image));
 if($gallery->delete()) {
 //return success with Api Resource
 return new ProductGalleryResource(true, 'Data Product Galleries Berhasil
Dihapus!', null);
 }
 //return failed with Api Resource
 return new ProductGalleryResource(false, 'Data Product Galleries Gagal Dihapus!',
null);
 }
}
