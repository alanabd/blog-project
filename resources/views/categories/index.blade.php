{{-- resources/views/categories/index.blade.php --}}

@extends('layouts.app') {{-- layouts/app.blade.php dosyasını genişlet --}}

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Kategoriler') }}
                    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">{{ __('Yeni Kategori Ekle') }}</a>
                </div>

                <div class="card-body">
                    {{-- Başarı/Hata mesajlarını göster --}}
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Kategori Adı') }}</th>
                                <th scope="col">{{ __('Slug') }}</th>
                                <th scope="col">{{ __('İşlemler') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                            <tr>
                                <th scope="row">{{ $category->id }}</th>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    {{-- Düzenleme ve Silme butonları (CASE-018 ve CASE-019 için yer tutucu) --}}
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">{{ __('Düzenle') }}</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')">{{ __('Sil') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">{{ __('Henüz hiç kategori bulunmamaktadır.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection