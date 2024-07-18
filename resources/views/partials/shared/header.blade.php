

<div class="container">
    <div class="header row"> 
        <div class = "col-8 col-sm-8 ">
            <div class="logo m-1">
                <span  style = "color:#C12323;">AP</span><span   style = "color:#192126;">GYM</span>
            </div>
        </div>
         <!-- Display different partials based on user role -->
         {{-- @if (Auth::check() && (Auth::user()->role == 'user' || Auth::user()->role == 'trainer')) --}}
         <div class="col-2 col-sm-2 d-flex justify-content-center a-no-underline">
             <span class="material-symbols-outlined blackIcon icons m-1 align-middle">notifications</span>
         </div>
        {{-- @endif --}}
        {{-- @if (Auth::check() && Auth::user()->role == 'user') --}}
            <div class="col-2 col-sm-2 d-flex justify-content-center a-no-underline">
                <a href="{{ route('issue-user-index') }}" class="material-symbols-outlined blackIcon icons m-1 align-middle">construction</a>
            </div>
        {{-- @endif --}}
     
    </div>
</div>
 