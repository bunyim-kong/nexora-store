@extends('layouts.admin')

@section('title', 'Categories')

@section('page-title', 'Categories')

@section('content')

    <div class="admin-page-header">
        <div class="admin-page-header__text">
            <h2 class="admin-page-header__title">Total Categories: {{ $categories->count() }} </h2>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="admin-btn admin-btn--primary">
            <svg class="admin-btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add category
        </a>
    </div>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th class="admin-table__actions-head"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>
                            @if ($category->image_path)
                                <img src="{{ asset('images/' . $category->image_path) }}"
                                     alt="{{ $category->name }}"
                                     class="admin-table__thumb">
                            @else
                                <div class="admin-table__thumb admin-table__thumb--empty">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <path d="m21 15-5-5L5 21"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="admin-table__name">{{ $category->name }}</td>
                        <td class="admin-table__muted"><code class="admin-table__slug">{{ $category->slug }}</code></td>
                        <td class="admin-table__muted">{{ Str::limit($category->des, 60) }}</td>
                        <td class="admin-table__actions">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="admin-btn admin-btn--ghost admin-btn--icon"
                               title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                  onsubmit="return confirm('Delete this category? This cannot be undone.');"
                                  class="admin-table__inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn--danger admin-btn--icon" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M3 6h18"/>
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="admin-table__empty">
                            <div class="admin-table__empty-content">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                                </svg>
                                <p>No categories yet — add your first one.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection