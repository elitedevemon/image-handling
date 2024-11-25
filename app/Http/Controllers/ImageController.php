<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ImageController extends Controller
{
  /**
   * Method index
   *
   * @return Factory|View
   */
  public function index(): Factory|View
  {
    $images = Image::get();
    return view('show_image', compact('images'));
  }
  /**
   * Method store
   *
   * @param Request $request [explicite description]
   *
   * @return void
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'photo' => 'image|mimes:jpg,png,'
    ]);
    $image = $request->file('photo');
    $ext = $image->getClientOriginalExtension();
    $name = $image->getClientOriginalName();
    $newImage = time() . '_' . Str::slug($name) . uniqid() . '.' . $ext;
    $path = $image->storeAs('images', $newImage, 'public');
    Image::create([
      'image' => $path
    ]);
    return redirect()->route('image.show');
  }

  /**
   * Method edit
   *
   * @param string $id $id [explicite description]
   *
   * @return Factory
   */
  public function edit(string $id): Factory|View
  {
    $image = Image::findOrFail($id);
    return view('edit_image', compact('image'));
  }

  /**
   * Method update
   *
   * @param Request $request [explicite description]
   * @param string $id [explicite description]
   *
   * @return RedirectResponse
   */
  public function update(Request $request, string $id): RedirectResponse
  {
    // previous file
    $imageData = Image::findOrFail($id);
    $previous_image_file = public_path('storage/') . $imageData->image;
    if (file_exists($previous_image_file)) {
      unlink($previous_image_file);
    } else {
      abort(404, 'file not found');
    }

    $image_file = $request->file('image');
    $imageName = $image_file->getClientOriginalName();
    $imageNewName = time() . '_' . Str::slug($imageName) . uniqid() . '.' . $image_file->extension();

    $imagePath = $image_file->storeAs('images', $imageNewName, 'public');

    $imageData->update([
      'image' => $imagePath
    ]);

    return redirect()->route('image.show');
  }

  /**
   * Method destroy
   *
   * @param string $id [explicite description]
   *
   * @return RedirectResponse
   */
  public function destroy(string $id): RedirectResponse
  {
    $image = Image::findOrFail($id);
    $image_file = public_path('storage/') . $image->image;
    // return $image_file;
    if (file_exists($image_file)) {
      unlink($image_file);
    }
    $image->delete();
    return back();
  }
}