@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')

    <div class="admin-edit-wrapper">

        @if ($errors->any())
            <div class="admin-alert admin-alert--error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="admin-form">
            @csrf

            <div class="admin-form__field">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Keyboards" required>
            </div>

            <div class="admin-form__field">
                <label for="des">Description</label>
                <textarea id="des" name="des" rows="4" placeholder="Short description shown on the storefront">{{ old('des') }}</textarea>
            </div>

            <div class="admin-form__field">
                <label for="image_path">Image</label>
                <input type="file" id="image_path" name="image_path" accept="image/*">
            </div>

            <div class="admin-form__actions">
                <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn--ghost">Cancel</a>
                <button type="submit" class="admin-btn admin-btn--primary">Save category</button>
            </div>
        </form>

    </div>

@endsection