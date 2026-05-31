<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        // Only fetch categories belonging to the logged-in user
        $categories = Category::where('user_id', Auth::id())->latest()->get();
        return view('categories', compact('categories'));
    }

    public function create()
    {
        return view('create_category');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'type'   => 'required',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required'   => 'Category name is required.',
            'type.required'   => 'Category type is required.',
            'status.required' => 'Category status is required.',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'type'    => $request->type,
            'status'  => $request->status,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(string $id)
    {
        // Scope the lookup to the current user — throws 404 if not theirs
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        return view('show_category', compact('category'));
    }

    public function edit(string $id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        return view('update_category', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'   => 'required',
            'type'   => 'required',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required'   => 'Category name is required.',
            'type.required'   => 'Category type is required.',
            'status.required' => 'Category status is required.',
        ]);

        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        $category->update([
            'name'   => $request->name,
            'type'   => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}