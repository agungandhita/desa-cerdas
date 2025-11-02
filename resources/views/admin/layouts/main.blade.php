<!DOCTYPE html>
<html>
<head>
    @include('admin.partials.start')
</head>
<body class="bg-slate-50">
    @include('admin.partials.header')
    @include('admin.partials.sidebar')

    <div class="ml-0 lg:ml-60 transition-all duration-300">
        <main class="pt-16">
            @yield('container')
        </main>
    </div>

    @include('admin.partials.end')
    @include('sweetalert::alert')
    @stack('scripts')
</body>
</html>

