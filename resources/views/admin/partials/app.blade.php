@include('admin.partials.header')

@include('admin.partials.navbar')

@include('admin.partials.sidebar')

<main role="main" class="main-content">
    @yield('content')
</main>

@include('admin.partials.footer')