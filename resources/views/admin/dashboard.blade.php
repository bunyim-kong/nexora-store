@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="admin-stats">
        <div class="admin-stat-card">
            <p class="admin-stat-card__label">Categories</p>
            <p class="admin-stat-card__value">{{ $categoryCount }}</p>
        </div>

        <div class="admin-stat-card">
            <p class="admin-stat-card__label">Products</p>
            <p class="admin-stat-card__value">{{ $productsCount }}</p>
        </div>
    </div>

@endsection