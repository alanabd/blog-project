{{-- resources/views/categories/create.blade.php --}}

@extends('layouts.app') {{-- layouts/app.blade.php dosyasını genişlet --}}

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Yeni Kategori Ekle') }}</div>

                <div class="card-body">
                    {{-- Hata mesajlarını göster --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf {{-- CSRF koruması için gerekli --}}

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Kategori Adı') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Kategori Oluştur') }}</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">{{ __('İptal') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection