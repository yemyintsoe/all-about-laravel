### ========== Trait ==========

<?php
namespace App\Traits;
use Illuminate\Support\Facades\Storage;

trait ImageTrait {

    public function uploadImage($fieldname = 'image', $directory = 'images')
    {
        $imageName =  uniqid() .'_'. request()->file($fieldname)->getClientOriginalName();
        request()->file($fieldname)->storeAs("public/$directory", $imageName);
        return $imageName;
    }

    public function updateImage($fieldname = 'image', $directory = 'images', $oldImage)
    {
        request()->validate([
            $fieldname => 'image|mimes:jpg,png,jpeg'
        ]);
        Storage::delete("public/$directory/$oldImage");
        $imageName = uniqid().'_'.request()->file($fieldname)->getClientOriginalName();
        request()->file($fieldname)->storeAs("public/$directory", $imageName);
        return $imageName;
    }

    public function deleteImage($model, $id, $directory)
    {
        $model = $model::findOrFail($id);
        Storage::delete("public/$directory/$model->image");
        $model->delete();
    }
}


### ========== Controller ==========

<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ImageTrait;

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'required|image|mimes:jpg,png,jpeg',
        ]);
        $imageName = $this->uploadImage('image', 'category-images');
        $category =  Category::create([
            'name' => $request->name,
            'image' => $imageName
        ]);
        return redirect('/admin/categories');
    }

   public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|unique:categories,name,'.$id
        ]);
        if($request->image) {
            $data['image'] = $this->updateImage('image', 'category-images', $category->image);
        }
        $category->update($data);
        return redirect('/admin/categories');
    }

    public function destroy($id)
    {
        $this->deleteImage(Category::class, $id, 'category-images');
        return back();
    }
}
