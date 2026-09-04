@extends('layouts.admin')

@section('title', 'Edit Category')

@section('page-title', 'Edit Category')

@section('content')

    <div class="admin-edit-wrapper">

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

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="admin-form admin-form--wide">
            @csrf
            @method('PUT')

            <div class="admin-form__columns">
                <div class="admin-form__col">
                    <div class="admin-form__field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                    </div>

                    <div class="admin-form__field">
                        <label for="des">Description</label>
                        <textarea id="des" name="des" rows="8">{{ old('des', $category->des) }}</textarea>
                    </div>
                </div>

                <div class="admin-form__col admin-form__col--aside">
                    <div class="admin-form__field">
                        <label for="image_path">Image</label>

                        <div class="admin-form__image-preview ">
                            @if ($category->image_path)
                                <img src="{{ asset('images/' . $category->image_path) }}"
                                     alt="{{ $category->name }}"
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

                        <label for="image_path" class="admin-btn admin-btn--ghost admin-form__file-label">
                            Choose new image
                        </label>
                        <input type="file" id="image_path" name="image_path" accept="image/*" class="admin-form__file-input">
                        <p class="admin-form__hint">Leave empty to keep the current image. PNG or JPG, up to 2MB.</p>
                    </div>
                </div>
            </div>

            <div class="admin-form__actions">
                <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn--ghost">Cancel</a>
                <button type="submit" class="admin-btn admin-btn--primary">Update category</button>
            </div>
        </form>

    </div>

@endsection

@push('scripts')
<script defer>
    document.getElementById('image_path')?.addEventListener('change', function (e) {
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