<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/navbar.css') }}">

    <!-- flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<nav class="navbar fixed w-full z-20 top-0 start-0">
  <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="flex items-center space-x-1 rtl:space-x-reverse">
        <span class="self-center text-[22px] text-heading font-bold whitespace-nowrap">NEXORA</span>
        <span class="nav-home self-center text-[22px] text-heading font-bold whitespace-nowrap">STORE</span>
    </a>

    {{-- Desktop nav links --}}
    <div class="hidden md:block md:w-auto">
        <ul class="flex items-center md:space-x-8 rtl:space-x-reverse font-medium">

            <li>
                <a href="{{ route('product.index') }}" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                    Products
                </a>
            </li>

            <li>
                <button id="dropdownNvbarCategory" data-dropdown-toggle="dropdownNavbarCategory" data-dropdown-placement="bottom-start" class="flex items-center justify-between w-full py-2 px-3 rounded font-medium text-heading md:w-auto hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                    Category
                    <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownNavbarCategory" class="drop-content hidden border border-default-medium rounded-base shadow-lg w-48">
                    <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownNvbarButtonCategory">
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">IEM</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Keyboard</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Mouse</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Mousepad</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Controller</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Microphone</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Monitor Stand</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Laptop Stand</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Wireless Buds</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Cooling Pad</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Speaker</a></li>
                    </ul>
                </div>
            </li>

            <li>
                <button id="dropdownNvbarButton" data-dropdown-toggle="dropdownNavbar" data-dropdown-placement="bottom-start" class="flex items-center justify-between w-full py-2 px-3 rounded font-medium text-heading md:w-auto hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                    Brand
                    <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownNavbar" class="drop-content z-10 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-48">
                    <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownNvbarButton">
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Attack Shark</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Aula</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Brateck</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">CVJ</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Dunu</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Fantech</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">GK</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Gravastar</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">KZ</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Keyz</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Kiwi Ears</a></li>
                        <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Leobog</a></li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                    Contact
                </a>
            </li>

        </ul>
    </div>

    <div class="flex items-center gap-4">
        <div class="toggle flex gap-6">
            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </a>

            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </a>
        </div>

        <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-11 h-11 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary" aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
        </button>
    </div>

  </div>

  <div id="navbar-dropdown" class="md:hidden hidden border-t border-default">
    <ul class="flex flex-col font-medium p-4 space-y-1">

        <li>
            <a href="{{ route('product.index') }}" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary">
                Products
            </a>
        </li>

        <li>
            <a href="{{ route('category.index') }}" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary">
                Category
            </a>
        </li>

        <li>
            <a href="" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary">
                Brand
            </a>
        </li>

        <li>
            <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary">
                Contact
            </a>
        </li>

    </ul>
  </div>

</nav>


</body>
</html>