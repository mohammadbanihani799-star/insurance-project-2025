{{-- resources/views/layouts/homeHeader.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', 'Insurance | Home')</title>

  <link rel="shortcut icon" href="{{ asset('style_files/frontend/img/Logo.png') }}" type="image/x-icon">

  {{-- أيقونات --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>

  {{-- Bootstrap CSS (محلي) --}}
  <link rel="stylesheet" href="{{ asset('front_end_style/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('front_end_style/css/bootstrap-rtl.min.css') }}">

  {{-- ملفات CSS الخاصة بك --}}
  <link rel="stylesheet" href="{{ asset('style_files/frontend/css/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('front_end_style/css/fonts.css') }}">
  <link rel="stylesheet" href="{{ asset('style_files/frontend/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('style_files/frontend/css/responsive.css') }}">

  {{-- مساحة لأي CSS إضافي من الصفحات --}}
  @stack('styles')
</head>
<body class="@yield('body_class')">

  {{-- نافبار/هيدر الصفحة إن وجد --}}
  @includeWhen(View::exists('partials.nav'), 'partials.nav')

  {{-- محتوى الصفحة --}}
  <main>
    @yield('content')
  </main>

  <header class="main-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('style_files/frontend/img/logo.png') }}" alt="Insurance Logo" class="logo-img">
                <span class="brand-text">شركة التأمين</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">خدماتنا</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('insurance.car') }}">تأمين السيارات</a></li>
                            <li><a class="dropdown-item" href="{{ route('insurance.health') }}">التأمين الصحي</a></li>
                            <li><a class="dropdown-item" href="{{ route('insurance.life') }}">تأمين الحياة</a></li>
                            <li><a class="dropdown-item" href="{{ route('insurance.property') }}">تأمين الممتلكات</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">اتصل بنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('claims') }}">المطالبات</a>
                    </li>
                </ul>

                <div class="navbar-nav ms-auto">
                    @guest
                        <a class="nav-link btn btn-outline-primary me-2" href="{{ route('login') }}">دخول</a>
                        <a class="nav-link btn btn-primary" href="{{ route('register') }}">تسجيل جديد</a>
                    @else
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">الملف الشخصي</a></li>
                                <li><a class="dropdown-item" href="{{ route('policies') }}">وثائق التأمين</a></li>
                                <li><a class="dropdown-item" href="{{ route('payments') }}">المدفوعات</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        تسجيل خروج
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
.main-header {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: #fff;
}

.navbar-brand {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.logo-img {
    height: 40px;
    width: auto;
    margin-left: 10px;
}

.brand-text {
    font-weight: bold;
    font-size: 1.2rem;
    color: #2c3e50;
}

.nav-link {
    font-weight: 500;
    color: #2c3e50 !important;
    padding: 0.5rem 1rem;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #3498db !important;
}

.nav-link.active {
    color: #3498db !important;
    font-weight: 600;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.dropdown-item {
    padding: 0.75rem 1rem;
    transition: background-color 0.3s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #3498db;
}

.btn-outline-primary {
    border-radius: 20px;
    padding: 0.375rem 1rem;
}

.btn-primary {
    border-radius: 20px;
    padding: 0.375rem 1rem;
    background-color: #3498db;
    border-color: #3498db;
}

@media (max-width: 991px) {
    .navbar-collapse {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }
    
    .navbar-nav.ms-auto {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }
}
</style>
</body>
</html>
