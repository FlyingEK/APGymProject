<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="shortcut icon" type="image/x-icon" href=img src="{{ asset('/img/treadmill.jpg') }}"> --}}
    <title>APGym</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Faustina:ital,wght@0,300..800;1,300..800&family=Inter:wght@100..900&family=Wallpoet&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="/css/styles.css" rel="stylesheet">
    <link href="/css/site.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/sl-2.0.3/datatables.min.js"></script>
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.8/sl-2.0.3/datatables.min.css" rel="stylesheet" />
    <!-- Include flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Include flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="d-flex align-items-center">
            <div class="logo m-1">
                <span style="color:#C12323;">AP</span><span style="color:#192126;">GYM</span>
            </div>
            <i class="toggle-sidebar-btn" style="color:#192126;">
                <span class="material-symbols-outlined">menu</span>
            </i>
        </div><!-- Authentication -->
        <div class="ml-auto"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a style="font-size: 19px; font-weight:600;" class="redIcon"  onclick="event.preventDefault();
                                this.closest('form').submit();">
            <i class="fas fa-sign-out-alt"></i>   Logout
        </a>
        </form>

    </div>
</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                <span class="material-symbols-outlined">
                    person
                </span>  &nbsp&nbsp<span>Users</span><i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('user-all') }}">
                        <i class="bi bi-circle"></i><span>All Users</span>
                    </a>
                    <a href="{{ route('user-add') }}">
                        <i class="bi bi-circle"></i><span>Add Gym Trainer</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#equipment-nav" data-bs-toggle="collapse" href="#">
                <span class="material-symbols-outlined">
                    exercise
                </span>  &nbsp&nbsp<span>Gym Equipments</span><i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <ul id="equipment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('equipment-all') }}">
                        <i class="bi bi-circle"></i><span>All Equipments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('equipment-add') }}">
                        <i class="bi bi-circle"></i><span>Add Equipment</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#constraint-nav" data-bs-toggle="collapse" href="#">
                <span class="material-symbols-outlined">
                    browse_gallery
                </span>  &nbsp&nbsp<span>Gym Constraints</span><i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <ul id="constraint-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('constraint-all') }}">
                        <i class="bi bi-circle"></i><span>All Constraints</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('constraint-create') }}">
                        <i class="bi bi-circle"></i><span>Add Constraints</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#badge-nav" data-bs-toggle="collapse" href="#">
                <span class="material-symbols-outlined">
                    emoji_events
                    </span>  &nbsp&nbsp<span>Achievement Badges</span><i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <ul id="badge-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('achievement-create') }}">
                        <i class="bi bi-circle"></i><span>All Achievement Badges</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('achievement-create') }}">
                        <i class="bi bi-circle"></i><span>Add Achievement Badges</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<!-- End Sidebar-->

<main role="main" id="main" class="main">
    @yield('content') 
</main>

@yield('javascript')
@stack('script')
<script src="{{ asset('/js/custom-select-box.js') }}"></script>
<script src="https://kit.fontawesome.com/c8bccee41a.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            customClass : {
                confirmButton: 'btn redBtn'
            }
        });
    @endif
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            customClass : {
                confirmButton: 'btn redBtn'
            }
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: '{!! implode('<br>', $errors->all()) !!}',
            customClass : {
                confirmButton: 'btn redBtn'
            }
        });
    @endif
    document.addEventListener("DOMContentLoaded", function() {
        const select = (selector, all = false) => {
            return all ? [...document.querySelectorAll(selector)] : document.querySelector(selector);
        };

        const on = (type, selector, listener, all = false) => {
            let selectElement = select(selector, all);
            if (selectElement) {
                if (all) {
                    selectElement.forEach(e => e.addEventListener(type, listener));
                } else {
                    selectElement.addEventListener(type, listener);
                }
            }
        };

        if (select('.toggle-sidebar-btn')) {
            on('click', '.toggle-sidebar-btn', function(e) {
                select('body').classList.toggle('toggle-sidebar');
            });
        }

        if (select('.search-bar-toggle')) {
            on('click', '.search-bar-toggle', function(e) {
                select('.search-bar').classList.toggle('search-bar-show');
            });
        }

        let navbarlinks = select('#navbar .scrollto', true);
        const navbarlinksActive = () => {
            let position = window.scrollY + 200;
            navbarlinks.forEach(navbarlink => {
                if (!navbarlink.hash) return;
                let section = select(navbarlink.hash);
                if (!section) return;
                if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                    navbarlink.classList.add('activeTab');
                } else {
                    navbarlink.classList.remove('activeTab');
                }
            });
        };
        window.addEventListener('load', navbarlinksActive);
        document.addEventListener('scroll', navbarlinksActive);

        let selectHeader = select('#header');
        if (selectHeader) {
            const headerScrolled = () => {
                if (window.scrollY > 100) {
                    selectHeader.classList.add('header-scrolled');
                } else {
                    selectHeader.classList.remove('header-scrolled');
                }
            };
            window.addEventListener('load', headerScrolled);
            document.addEventListener('scroll', headerScrolled);
        }
    });
</script>
<script src="{{ asset('/js/table.js') }}"></script>
