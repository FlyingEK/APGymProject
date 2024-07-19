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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="/css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- @if (!Route::is(['password.reset', 'confirm-mail','password.request','login','lock-screen','register','error-404','error-500','verification.notice']) && !Route::is(['browse-index','reward-recognition-redemption','home','profile','edit-profile','volunteer-dashboard','chat')) --}}
    @if (!Route::is(['login','register']) )
        @include('partials.shared.header')
    @endif

</head>
<body>
    <div class="content-wrapper mx-2">
        @yield('content')
    </div>
</body>

@if (!Route::is(['password.reset', 'confirm-mail','password.request','login','lock-screen','register','error-404','error-500','verification.notice']) )
@include('partials.shared.bottomnav-user')
@endif


@yield('javascript')
<script src="https://kit.fontawesome.com/c8bccee41a.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="{{asset('/js/initialize.js')}}"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $(document).ready(function() {

    });
    $(function(){
        var current = location.pathname;
        $('.navbar a').each(function(){
            var $this = $(this);        
            // if the current path is like this link, make it active
            if($this.attr('href').indexOf(current) !== -1){
                $('.navtab').removeClass('activeTab'); 
                    $this.closest('.navtab').addClass('activeTab');          
             }
        });
    });
</script>
</html>