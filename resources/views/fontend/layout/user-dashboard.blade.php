@include('fontend.layout.header')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('fontend.layout.sidebar')
            </div>
            <div class="col-lg-9">
                @yield('dashboard')
            </div>
        </div>

    </div>
    </div>
    </div>
</section>

@include('fontend.layout.footer')