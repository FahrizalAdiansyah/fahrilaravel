<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|min:3'
        ]);

        Category::create([
            'name'=>$request->get('name')
        ]);
        return redirect()->route('category.index')->with('message', 'Kategori berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        return view ('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'=>'required|min:3'
        ]);
        
        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->save();
        return redirect()->route('category.index')->with('message','Kategori berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

    // Cek apakah kategori ditemukan
    if ($category) {
        $category->delete();
        return redirect()->route('category.index')->with('message', 'Kategori berhasil dihapus');
    } else {
        return redirect()->route('category.index')->with('error', 'Kategori tidak ditemukan');
    }
    }
}
