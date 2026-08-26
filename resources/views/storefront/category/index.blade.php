@extends('layouts.storefront')

@section('title', 'NEXORA — Category')

@section('content')
    <section class="container category">
        <div class="category-section">
            <div class="title-section">
                <h2 class="title">Browse Categories</h2>

                <a class="view-btn" href="">VIEW ALL 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>

            <div class="category-wrapper">
                <?php foreach ($categories as $category): ?>
                <div class="categ-card">
                    <div class="categ-infor">
                        <div class="infor">
                            <h2><?= $category['name'] ?></h2>
                            <p><?= $category['des'] ?></p>
                        </div>

                        <div class="categ-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="categ-icon size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="categ-img">
                        <img src="{{ $category->image_path ? asset('images/'.$category->image_path) : asset('images/placeholder.jpg') }}" alt="{{ $category->name }}">
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
@endsection