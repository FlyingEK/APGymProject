
<div class=" navbar row" styyle="padding:0; margin:0;"> 
    <div class = "navtab col col-sm">
        <a href="{{route('equipment-index')}}"><span class="whiteIcon material-symbols-outlined">home</span><br>Home</a>        
    </div>
    <div class = " navtab col col-sm">
        <a href="{{route('analytic-report')}}"><span class="whiteIcon material-symbols-outlined">exercise</span><br>Workout</a>        
    </div>
    <div class = "navtab col col-sm">
        <a href="#"><span class="whiteIcon material-symbols-outlined">analytics</span><br>Analytics</a>        
    </div>
    <div class = "navtab col col-sm">
        <a href="#"><span class="whiteIcon material-symbols-outlined">person</span><br>Profile</a>        
    </div>
</div>
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