{{-- resources/views/admin/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sign in — NEXORA Admin')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/form-login.css') }}">
</head>
<body>
    <section class="login-page">
        <div class="login-card">
            <h1 class="login-card__title">Sign in to NEXORA <span>STORE</span></h1>
            <p class="login-card__subtitle">Admin dashboard access</p>

            @if ($errors->any())
                <div class="login-card__error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('auth.login.store') }}">
                @csrf

                <div class="login-form__field">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@nexora.com"
                        autocomplete="email"
                        autofocus
                        required
                    >
                </div>

                <div class="login-form__field">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <label class="login-form__remember">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                <button type="submit" class="login-form__submit">Sign in</button>
            </form>
        </div>
    </section>
</body>
</html>