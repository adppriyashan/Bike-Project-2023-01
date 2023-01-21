@extends('layouts.app')

@section('content')
    <div class="app-content h-100">
        <div class="content-wrapper mt-5">
            <div class="content-body">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <img class="w-100" src="{{ asset('assets/app-assets/images/login/bg.jpg') }}"
                                            alt="branding logo">
                                    </div>
                                    <div class="col-md-4 border-left text-center">
                                        <img class="w-75 mb-2 mt-2" src="{{ asset('assets/app-assets/images/logo/logo_text.png') }}"
                                                alt="branding logo">
                                        <form method="POST" action="{{ route('login') }}" class="text-left">
                                            @csrf
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label for=""><small>Username</small></label>
                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email') }}" required
                                                        autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label for=""><small>Password</small></label>
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" required autocomplete="current-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-check ml-0">
                                                        <input class="form-check-input" type="checkbox" name="remember"
                                                            id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                        <label class="form-check-label" for="remember">
                                                            <small>{{ __('Remember Me') }}</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        {{ __('Login') }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="col-md-12 mt-2" style="text-align: center;">

                                                    @if (Route::has('password.request'))
                                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                                            <small class="text-dark">{{ __('Forgot Your Password?') }}</small>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.scripts')

    <script>
        $('#body-tag').addClass('bg-primary');
    </script>
@endsection
