@extends('layouts.admin')

@section('title', 'Edit Product')

@section('page-title', 'Edit Product')

@section('content')

<div class="admin-edit-wrapper">
    <div class="admin-page-header">
        <div class="admin-page-header__text">
            <h2 class="admin-page-header__title">Edit Product</h2>
            <p class="admin-page-header__subtitle">{{ $product->name }}</p>
        </div>
        
    </div>

    @if ($errors->any())
        <div class="admin-alert admin-alert--error">
            <svg class="admin-alert__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 8v4"/>
                <path d="M12 16h.01"/>
            </svg>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="admin-form admin-form--wide">
        @csrf
        @method('PUT')

        <div class="admin-form__columns">

            <div class="admin-form__col">

                <div class="admin-form__grid-2">
                    <div class="admin-form__field">
                        <label for="name">Product name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="admin-form__field">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id">
                            <option value="">— No category —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="admin-form__grid-2">
                    <div class="admin-form__field">
                        <label for="brand">Brand</label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
                    </div>

                    <div class="admin-form__field">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                    </div>
                </div>

                <div class="admin-form__grid-2">
                    <div class="admin-form__field">
                        <label for="discount_price">Discount price</label>
                        <input type="number" step="0.01" id="discount_price" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}">
                    </div>

                    <div class="admin-form__field">
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}">
                    </div>
                </div>

                <div class="admin-form__grid-2">
                    <div class="admin-form__field">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}">
                    </div>
                </div>

                <div class="admin-form__field">
                    <label for="des">Description</label>
                    <textarea id="des" name="des" rows="6" required>{{ old('des', $product->des) }}</textarea>
                </div>
            </div>

            <div class="admin-form__col admin-form__col--aside">

                <div class="admin-form__field">
                    <label for="image">Product image</label>

                    <div class="admin-form__image-preview admin-form__image-preview--large">
                        @if ($product->image)
                            <img src="{{ asset('images/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 id="admin-image-preview-img">
                        @else
                            <div class="admin-form__image-placeholder" id="admin-image-preview-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <path d="m21 15-5-5L5 21"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <label for="image" class="admin-btn admin-btn--ghost admin-form__file-label">
                        Choose new image
                    </label>
                    <input type="file" id="image" name="image" accept="image/*" class="admin-form__file-input">
                    <p class="admin-form__hint">Leave empty to keep the current image.</p>
                </div>

                <div class="admin-form__field">
                    <label>Visibility</label>
                    <div class="admin-checkbox-group">
                        <label class="admin-checkbox">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <span>Featured</span>
                        </label>
                        <label class="admin-checkbox">
                            <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }}>
                            <span>Best seller</span>
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <div class="admin-form__actions">
            <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn--ghost">Cancel</a>
            <button type="submit" class="admin-btn admin-btn--primary">Update product</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script defer>
    document.getElementById('image')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const preview = document.getElementById('admin-image-preview-img');
        const reader = new FileReader();

        reader.onload = function (ev) {
            const img = document.createElement('img');
            img.src = ev.target.result;
            preview.replaceWith(img);
            img.id = 'admin-image-preview-img';
        };

        reader.readAsDataURL(file);
    });
</script>
@endpush