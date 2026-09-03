@extends('layouts.storefront')

@section('title', 'NEXORA — Product List')

@section('content')
    <section class="container product">
        <div class="product-section">
            <div class="title-section">
                <h2 class="title">Product Lists</h2>
            </div>

            <div class="product-wraapper">
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
        </div>

        
    </section>
@endsection