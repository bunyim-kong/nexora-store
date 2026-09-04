<header class="admin-header">

    <button type="button"
            data-drawer-target="admin-sidebar"
            data-drawer-toggle="admin-sidebar"
            data-drawer-body-scrolling="false"
            aria-controls="admin-sidebar"
            class="admin-header-toggle">
        <span class="sr-only">Toggle sidebar</span>
        <svg class="admin-header-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M4 6h16"/>
            <path d="M4 12h16"/>
            <path d="M4 18h16"/>
        </svg>
    </button>

    <div class="admin-header-title-wrap">
        <h1 class="admin-header-title">@yield('page-title', 'Dashboard')</h1>
        @hasSection('breadcrumb')
            <p class="admin-header-breadcrumb">@yield('breadcrumb')</p>
        @endif
    </div>


    {{-- Account --}}
    
</header>