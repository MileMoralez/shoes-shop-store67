<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // បង្ហាញ Form សម្រាប់បញ្ចូល Category ថ្មី
    public function create()
    {
        return view('admin.categories.create');
    }

    // ទទួលទិន្នន័យពី Form យកមក Save និង Upload រូបភាព
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:categories',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // ឆែកមើលបើមានការ Upload រូបភាព
        if ($request->hasFile('image')) {
            // Save រូបភាពចូលទៅ Folder storage/app/public/categories
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }

        Category::create($data);

        return back()->with('success', 'Category created successfully!');
    }
    // ១. បង្ហាញតារាង Category
    public function index()
    {
        $categories = \App\Models\Category::orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // ២. បង្ហាញទំព័រសម្រាប់កែប្រែ (Edit)
    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // ៣. ទទួលទិន្នន័យដើម្បី Update ចូល Database វិញ
    public function update(Request $request, $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string',
            // អនុញ្ញាតឲ្យប្រើ slug ដដែលបាន សម្រាប់ category នេះ
            'slug' => 'required|string|unique:categories,slug,' . $category->id, 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('image');

        // បើមានការ Upload រូបភាពថ្មី
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }

        $category->update($data);
        return redirect('/admin/categories')->with('success', 'Category updated successfully!');
    }

    // ៤. មុខងារសម្រាប់លុប (Delete)
    public function destroy($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
}