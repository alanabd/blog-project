<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Slug oluşturmak için
use Illuminate\Support\Facades\Gate; // Gate kullanımı için

class CategoryController extends Controller
{
    public function __construct()
    {
        // Bu kontrolcüdeki tüm metotları sadece admin rolüne sahip kullanıcılar çağırabilsin
        // CASE-012'de tanımladığımız 'isAdmin' Gate'ini kullanıyoruz.
        // Alternatif olarak Route::middleware(['can:isAdmin']) de kullanılabilir.
        $this->middleware('can:isAdmin');
    }

    /**
     * Kategori oluşturma formunu gösterir.
     * Admin yetkilendirmesi constructor'da kontrol ediliyor.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Yeni bir kategori oluşturur ve veritabanına kaydeder.
     * Admin yetkilendirmesi constructor'da kontrol ediliyor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Gelen veriyi doğrula
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            // unique:categories,name kuralı, kategori adının benzersiz olmasını sağlar.
        ]);

        // Yeni kategori oluştur
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // SEO dostu slug oluştur
        ]);

        // Başarı mesajıyla birlikte kategori listeleme veya başka bir sayfaya yönlendir
        return redirect()->route('categories.index')->with('success', 'Kategori başarıyla eklendi!');
    }

    // --- Diğer metotlar (index, show, edit, update, destroy) daha sonra eklenecek veya düzenlenecek ---
    // Şimdilik sadece create ve store odaklandık.

    /**
     * Tüm kategorileri listeler.
     * (CASE-017 için eklenecek)
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
}