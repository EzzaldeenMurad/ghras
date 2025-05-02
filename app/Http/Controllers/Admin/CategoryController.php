<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        $parentCategories = Category::where('parent_id', null)->latest()->get();
        return view('admin.categories.index', compact('categories', 'parentCategories'));
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'user_id' =>  Auth::id(),
        ];
        if ($request->hasFile('image_url')) {
            $image =  $request->file('image_url');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);
            $data['image_url'] = 'images/categories/' . $imageName;
        }
        // if ($request->hasFile('image_url')) {
        //     $image = $request->file('image_url');
        //     $imageName = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
        //     $data['image_url'] = $image->storeAs('categories', $imageName, 'public');
        // }

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'تم إضافة الفئة بنجاح');
    }

    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json([
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        // dd($category);
        return response()->json([
            'category' => $category
        ]);
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        if ($request->hasFile('image_url')) {
            // Delete old image if exists
            if ($category->image_url && file_exists(public_path($category->image_url))) {
                unlink(public_path($category->image_url));
            }

            $image = $request->file('image_url');
            $imageName =  time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/categories/' . $imageName;

            // Make sure the directory exists
            if (!file_exists(public_path('images/categories'))) {
                mkdir(public_path('images/categories'), 0755, true);
            }

            $image->move(public_path('images/categories'), $imageName);
            $category->image_url = $imagePath;
        }


        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'تم تحديث الفئة بنجاح');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Delete category image
        if ($category->image_url && Storage::disk('public')->exists($category->image_url)) {
            Storage::disk('public')->delete($category->image_url);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'تم حذف الفئة بنجاح');
    }
}
