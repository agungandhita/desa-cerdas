{{-- Main Layout untuk Frontend Desa Cerdas --}}
@include('frontend.partials.start')

{{-- Navigation Bar --}}
@include('frontend.partials.navbar')

{{-- Main Content Area --}}
<main class="min-h-screen">
    {{-- Hero Section (Optional) --}}
    @hasSection('hero')
        <section class="hero-section">
            @yield('hero')
        </section>
    @endif

    {{-- Breadcrumb Section (Optional) --}}
    @hasSection('breadcrumb')
        <section class="breadcrumb-section bg-gray-50 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('breadcrumb')
            </div>
        </section>
    @endif

    {{-- Main Container --}}
    <div class="main-container">
        @yield('container')
    </div>

    {{-- Additional Content Sections --}}
    @hasSection('extra-content')
        <section class="extra-content">
            @yield('extra-content')
        </section>
    @endif
</main>

{{-- Footer --}}
@include('frontend.partials.footer')

{{-- SweetAlert Notifications --}}
@include('sweetalert::alert')

{{-- Scripts and Closing Tags --}}
@include('frontend.partials.end')
