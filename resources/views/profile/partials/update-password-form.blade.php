<section>
    <header>
        <h4 class="font-weight-bold text-dark">
            {{ __('Update Password') }}
        </h4>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-3">
            <input type="password" class="form-control" placeholder="Current Password" name="current_password" autocomplete="current-password">
            @error('current_password"')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" placeholder="New Password" name="password" autocomplete="new-password">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" placeholder="Comfirm Password" name="password_confirmation" autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="d-flex justify-content-end">
            <button type="submit" class="btn redBtn">{{ __('Save') }}</button>
        </div>
        <script>
            @if (session('status') === 'password-updated')
                swal.fire({
                    title: 'Password Updated',
                    text: 'Your password has been updated.',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn redBtn'
                    }
                });
            @elseif ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: '{!! implode('<br>', $errors->all()) !!}',
                    customClass : {
                        confirmButton: 'btn redBtn'
                    }
                });
            @endif
        </script>
    </form>

</section>
