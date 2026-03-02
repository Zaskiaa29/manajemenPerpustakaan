<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all(); 
        $query = Book::with('category');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%'); 
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->get();
        $totalBooks = $books->count();
        $categoryCounts = Category::withCount('books')->get(); 

        return view('books.index', compact('books', 'categories', 'totalBooks', 'categoryCounts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|numeric',
            'judul' => 'required',
            'penulis' => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success','Data berhasil ditambahkan');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'category_id' => 'required|numeric',
            'judul' => 'required',
            'penulis' => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success','Data berhasil diupdate');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success','Data berhasil dihapus');
    }
}