@extends('layouts.storefront')

@section('title', 'NEXORA — Home')

@section('content')
    <section class="container hero">
        <div class="hero-section">
                <img src="{{ asset('images/hero.jpg') }}" alt="">

                <div class="transparant-color">
                </div>
                
                <div class="speech">
                    <h1>Welcome to our store!</h1>
                    <p>Grab what you need here!</p>
                    <a href="">Buy Now</a>
                </div>
        </div>

        <div class="category-section">
            <div class="title-section">
                <h2 class="title">Browse Categories</h2>

                <a class="view-btn" href="{{ route('category.index') }}">VIEW ALL 
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

        <div class="products-section">
            <div class="title-section">
                <h2 class="title">Product Lists</h2>

                <a class="view-btn" href="{{ route('product.index') }}">VIEW ALL 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>

            <div class="card-wrapper">
                <?php foreach ($products as $product): ?>
                <article class="card">
                    <div class="card-img">
                        <img src="{{ $product->image ? asset('images/'.$product->image) : asset('images/placeholder.jpg') }}" alt="<?= $product['name'] ?>">
                    </div>

                    <div class="infor">
                        <h1><?= $product['name'] ?></h1>

                        <p><?= $product['des'] ?></p>

                        <div class="price-wrapper">
                            <?=  $product['price'] ?>$
                            <span><?= $product['discount_price'] ?>% off</span>
                        </div>

                        <div class="btn-wrapper">
                            <small>Quantity: <strong><?= $product['quantity'] ?></strong> </small>

                            <a class="buy-btn" href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="btn size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endforeach ?>
            </div>
        </div>
    </section>
@endsection