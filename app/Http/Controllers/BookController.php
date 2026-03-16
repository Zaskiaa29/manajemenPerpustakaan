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
        // 1. Validasi input dari form
        $request->validate([
            'category_id'  => 'required',
            'judul'        => 'required',
            'penulis'      => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok'         => 'required|numeric',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Opsional: validasi khusus gambar
        ]);

        // 2. Ambil semua data request
        $data = $request->all();

        // 3. Logika Upload Gambar (Disesuaikan dengan name="cover" di HTML)
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            
            // Bikin nama file unik pakai waktu (time) + ekstensi file asli
            $filename = time() . '_' . $file->getClientOriginalExtension();
            
            // Pindahkan file fisik ke folder public/images/books
            $file->move(public_path('images/books'), $filename);
            
            // Simpan path-nya ke dalam array data untuk dimasukkan ke database
            $data['cover'] = 'images/books/' . $filename; 
        }

        // 4. Simpan ke database
        Book::create($data);

        // 5. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('books.index')->with('success', 'Data buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        // 1. Validasi input
        $request->validate([
            'category_id'  => 'required',
            'judul'        => 'required',
            'penulis'      => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok'         => 'required|numeric',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 2. Ambil semua data request
        $data = $request->all();

        // 3. Logik untuk muat naik gambar baru
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalExtension();
            
            // Pindahkan file baru ke folder
            $file->move(public_path('images/books'), $filename);
            
            // Hapus gambar fizikal yang lama jika wujud (supaya folder tak penuh)
            if ($book->cover && file_exists(public_path($book->cover))) {
                unlink(public_path($book->cover));
            }

            // Simpan path gambar baru ke dalam array data
            $data['cover'] = 'images/books/' . $filename; 
        } else {
            unset($data['cover']);
        }

        // 4. Kemaskini pangkalan data (database)
        $book->update($data);

        // 5. Kembali ke halaman utama dengan mesej sukses
        return redirect()->route('books.index')->with('success', 'Data buku berjaya dikemaskini!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success','Data berhasil dihapus');
    }
}