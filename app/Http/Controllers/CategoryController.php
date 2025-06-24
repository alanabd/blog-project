<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Bu kontrolcüdeki tüm metotları sadece admin rolüne sahip kullanıcılar çağırabilsin
        $this->middleware('can:isAdmin');
    }

    /**
     * Tüm kategorileri listeler.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::all(); // Tüm kategorileri veritabanından çek
        return view('categories.index', compact('categories')); // 'categories' değişkenini view'a gönder
    }

    /**
     * Kategori oluşturma formunu gösterir.
     * (CASE-016'da zaten düzenlenmişti)
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Yeni bir kategori oluşturur ve veritabanına kaydeder.
     * (CASE-016'da zaten düzenlenmişti)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori başarıyla eklendi!');
    }

    // --- Diğer metotlar (show, edit, update, destroy) daha sonra eklenecek ---
}