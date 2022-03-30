@extends('layouts.login')

@section('content')
<div class="card row">
    <div class="card-body login-card-body">
        <div class="login-logo">

                <img src="{{ asset("/images/logo/logo.png") }}" title="{{ config('app.name', 'Laravel') }}" style="border:0;align:center;margin-left: auto; margin-right: auto; width: 15%; ">

        </div>
      <p class="login-box-msg">{{ __('Login') }} to start your session</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
            <input id="email" type="email" placeholder="Email"s class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="input-group mb-3">
          <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
            <input  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
                {{ __('Remember Me') }}
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      @if (Route::has('password.request'))
      <p class="mb-1">
        <a href="{{ route('password.request') }}"></a>
      </p>
      @endif
      @if (Route::has('register'))

      @endif
    </div>
    <!-- /.login-card-body -->
  </div>
@endsection
