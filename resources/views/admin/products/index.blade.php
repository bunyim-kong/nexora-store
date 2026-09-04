@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header__text">
        <h2 class="admin-page-header__title">Total Products: </h2>
    </div>

    <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn--primary">
        + Add Product
    </a>
</div>

@if (session('success'))
    <div class="admin-alert admin-alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.products.index') }}" method="GET" class="admin-filter-bar">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search products..."
        class="admin-input"
    >

    <select name="category_id" class="admin-select" onchange="this.form.submit()">
        <option value="">All Categories</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="btn-admin-secondary">Filter</button>

    @if (request('search') || request('category_id'))
        <a href="{{ route('admin.products.index') }}" class="btn-admin-ghost">Clear</a>
    @endif
</form>

{{-- Products table --}}
<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Featured</th>
                <th>Best Seller</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td>
                        ${{ number_format($product->price, 2) }}
                        @if ($product->is_on_sale)
                            <span class="admin-badge admin-badge-sale">
                                ${{ number_format($product->discount_price, 2) }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $product->stock ?? 0 }}</td>
                    <td>
                        @if ($product->is_featured)
                            <span class="admin-badge admin-badge-yes">Yes</span>
                        @else
                            <span class="admin-badge admin-badge-no">No</span>
                        @endif
                    </td>
                    <td>
                        @if ($product->is_best_seller)
                            <span class="admin-badge admin-badge-yes">Yes</span>
                        @else
                            <span class="admin-badge admin-badge-no">No</span>
                        @endif
                    </td>

                    <td class="admin-table__actions">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="admin-btn admin-btn--ghost admin-btn--icon"
                           title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                            </svg>
                        </a>
                        
                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}"
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
                    <td colspan="9" class="admin-table-empty">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-pagination">
    {{ $products->links() }}
</div>
@endsection 