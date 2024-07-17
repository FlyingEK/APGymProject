<section>
    <header>
        <h4 class="font-weight-bold text-dark">
            {{ __('Profile Information') }}
        </h4>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')
        <div class="row mb-1">
            <div class="col-lg-12 d-flex justify-content-center">
                <div class="avatar-upload add-img-upload">
                    <div class="avatar-edit">
                        <input type='file' name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="avatar-preview rounded-circle" style="width:140px;height:140px;">
                        <div id="imagePreview" style="background-image: url();">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username', $user->username) }}">
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email', $user->email) }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-secondary">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="mb-3">
            <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name', $user->first_name) }}">
            @error('first_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name', $user->last_name) }}">
            @error('last_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <select name="gender" class="form-control form-select">
                <option value="" disabled selected>Choose...</option>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn redBtn">{{ __('Save') }}</button>
        </div>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-secondary"
            >{{ __('Saved.') }}</p>
        @endif
    </form>
</section>

@section('javascript')
<script src={{asset('/js/img-preview')}}></script>  
@endsection