<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/admin.css') }}">

    <!-- flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <aside id="admin-sidebar"
        class="admin-sidebar"
        aria-label="Admin sidebar">

        <div class="admin-sidebar-brand">
            <a href="{{ route('admin.home') }}" class="admin-sidebar-logo">
                NEXORA<span class="admin-sidebar-logo-accent"> Admin</span>
            </a>
        </div>

        <nav class="admin-sidebar-nav">
            <ul class="admin-sidebar-list">

                <li>
                    <a href="{{ route('admin.home') }}"
                    class="admin-sidebar-link {{ request()->routeIs('admin.home') ? 'is-active' : '' }}">
                        <svg class="admin-sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.5Z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.categories.index') }}"
                    class="admin-sidebar-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
                        <svg class="admin-sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                        <span>Categories</span>
                    </a>
                </li>

                <li>
                    @if (Route::has('admin.products.index'))
                        <a href="{{ route('admin.products.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">
                    @else
                        <span class="admin-sidebar-link admin-sidebar-link--soon">
                    @endif
                        <svg class="admin-sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M21 8 12 3 3 8l9 5 9-5Z"/>
                            <path d="M3 8v8l9 5 9-5V8"/>
                            <path d="M12 13v8"/>
                        </svg>
                        <span>Products</span>
                    @if (Route::has('admin.products.index'))
                        </a>
                    @else
                        </span>
                    @endif
                </li>

                <li>
                    @if (Route::has('admin.orders.index'))
                        <a href="{{ route('admin.orders.index') }}"
                    class="admin-sidebar-link {{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}">
                    @else
                        <span class="admin-sidebar-link admin-sidebar-link--soon">
                    @endif
                            <svg class="admin-sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M6 2 4 5v15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5l-2-3H6Z"/>
                                <path d="M4 6h16"/>
                                <path d="M9 10a3 3 0 0 0 6 0"/>
                            </svg>
                        
                            <span>Orders</span>
                        @if (Route::has('admin.orders.index'))
                        </a>
                        @else
                        </span>
                    @endif
                </li>

                <li>
                    @if (Route::has('admin.customers.index'))
                    <a href="{{ route('admin.customers.index') }}"
                    class="admin-sidebar-link {{ request()->routeIs('admin.customers.*') ? 'is-active' : '' }}">
                    @else
                    <span class="admin-sidebar-link admin-sidebar-link--soon">
                    @endif
                        <svg class="admin-sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/>
                        </svg>
                        @if (Route::has('admin.customers.index'))
                        <span>Customers</span>
                    @else
                    </span>
                    @endif
                    </a>
                </li>

            </ul>
        </nav>

        <div class="admin-sidebar-footer">
            <span class="admin-sidebar-footer-text">NEXORA-Tech &copy; {{ date('Y') }}</span>
        </div>
    </aside>

    {{-- Backdrop for off-canvas mode on small screens, toggled by Flowbite via data-drawer-toggle --}}
    <div id="admin-sidebar-backdrop" class="admin-sidebar-backdrop hidden" data-drawer-toggle="admin-sidebar"></div>
</body>
</html>