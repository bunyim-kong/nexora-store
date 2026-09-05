@extends('layouts.storefront')

@section('title', 'NEXORA — Contact Us')

@section('content')
<section class="container contact-page">
    <div class="top-section-contact">
        <h1 class="page-title">Contact Us</h1>
    </div>

    <div class="contact-grid">
        <!-- Contact Info Cards -->
        <div class="contact-info-cards">
            <!-- Card 1: Address -->
            <div class="contact-card">
                <div class="contact-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <div class="contact-card-content">
                    <h3 class="contact-card-title">Our Address</h3>
                    <p class="contact-card-text">#123, Street 456,<br>Phnom Penh, Cambodia</p>
                    <a href="https://maps.app.goo.gl/hux9Dh7R86kbCCgv6?g_st=atm" target="_blank" class="contact-card-link">
                        View on Google Maps →
                    </a>
                </div>
            </div>

            <!-- Card 2: Phone -->
            <div class="contact-card">
                <div class="contact-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                </div>
                <div class="contact-card-content">
                    <h3 class="contact-card-title">Phone</h3>
                    <p class="contact-card-text">+855 12 345 678</p>
                    <a href="tel:+85512345678" class="contact-card-link">
                        Call Now →
                    </a>
                </div>
            </div>

            <!-- Card 3: Email -->
            <div class="contact-card">
                <div class="contact-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </div>
                <div class="contact-card-content">
                    <h3 class="contact-card-title">Email</h3>
                    <p class="contact-card-text">info@nexora.com</p>
                    <a href="mailto:info@nexora.com" class="contact-card-link">
                        Send Email →
                    </a>
                </div>
            </div>

            <!-- Card 4: Hours -->
            <div class="contact-card">
                <div class="contact-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div class="contact-card-content">
                    <h3 class="contact-card-title">Working Hours</h3>
                    <p class="contact-card-text">
                        Mon - Fri: 8:00 AM - 6:00 PM<br>
                        Saturday: 9:00 AM - 4:00 PM<br>
                        Sunday: Closed
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form-wrapper">
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.123456789!2d104.9281!3d11.5567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTDCsDMzJzI0LjAiTiAxMDTCsDU1JzQxLjIiRQ!5e0!3m2!1sen!2skh!4v1234567890"
                    width="100%" 
                    height="400" 
                    style="border:0; border-radius: 12px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>
@endsection