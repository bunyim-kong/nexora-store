@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header__text">
        <h2 class="admin-page-header__title">Total Products: {{ $products->count() }}</h2>
    </div>

    <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn--primary">
        + Add Product
    </a>
</div>

<form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center justify-end gap-3 py-4 ">
    <div class="relative min-w-[180px]">
        <select 
            name="category_id" 
            onchange="this.form.submit()"
            class="w-full appearance-none px-4 py-2.5 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 bg-gray-50 hover:bg-white cursor-pointer text-sm"
        >
            <option" value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-black hover:bg-white hover:text-black text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-xs hover:shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Filter
        </button>

        @if (request('category_id'))
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-5 py-2.5 border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Clear
            </a>
        @endif
    </div>
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