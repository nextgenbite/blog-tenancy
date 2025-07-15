<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('tenant.admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('tenant.admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create(['name'=> $request->name, 'tenant_id' => tenant()->id]);

        return redirect()->route('category.index')->with('success', __('Category created successfully.'));
    }

    public function edit(Category $category)
    {
        return view('tenant.admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->only('name'));

        return redirect()->route('category.index')->with('success', __('Category updated successfully.'));
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', __('Category deleted successfully.'));
    }
}
