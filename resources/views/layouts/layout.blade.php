<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="shortcut icon" type="image/x-icon" href=img src="{{ asset('/img/treadmill.jpg') }}"> --}}
    <title>APGym</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="/css/styles.css" rel="stylesheet">
    @include('partials.shared.header')


</head>
<body>
    @yield('content')



</body>
@include('partials.shared.bottomnav-user')
@yield('javascript')
<script>
    $(function(){
        var current = location.pathname;
        $('.navbar a').each(function(){
            var $this = $(this);        
            // if the current path is like this link, make it active
            if($this.attr('href').indexOf(current) !== -1){
                $('.navtab').removeClass('active'); 
                    $this.closest('.navtab').addClass('active');          
             }
        });
    });
</script>
</html>