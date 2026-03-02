<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. Menampilkan Semua Kategori
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // 2. Menyimpan Kategori Baru
    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required']);
        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambah');
    }

    // 3. Menampilkan Halaman Edit
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // 4. Memperbarui Data (HANYA BOLEH ADA SATU FUNGSI UPDATE)
    public function update(Request $request, Category $category)
    {
        $request->validate(['nama_kategori' => 'required']);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate');
    }

    // 5. Menghapus Kategori
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}