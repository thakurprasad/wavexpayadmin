@extends('layouts.home')
@section('title', 'Signup | '.config('app.name'))
@section('meta')
  <meta name="description" content="Signup | {{ config('app.name') }}">
  <meta name="keywords" content="Signup | {{ config('app.name') }}"> 
@endsection
@section('header_class', 'headerCms')
@section('header_search') 
<div class="container clearfix">
    <h2>Sign <strong>Up</strong></h2>
</div>
@endsection
@section('content')
<section class="buses_top">
    <div class="container clearfix">
        <div class="top_part">
            <ul class="clearfix">
                <li><img src="/images/buses_top_1.png" alt=""> Super Savings</li>
                <li><img src="/images/buses_top_2.png" alt=""> 24x7 Support</li>
                <li><img src="/images/buses_top_3.png" alt=""> Safe &amp; Secure Payments</li>
            </ul>
        </div>
    </div>
</section>
<section class="signUpRap">
    <div class="container">
        <h2>Create An <span>Account</span></h2>
        <form method="POST" action="{{ route('register') }}">
        @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> 
                        <input id="name" placeholder="Name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> 
                        <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="new-email">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>  
                <div class="col-md-6">
                    <div class="form-group"> 
                        <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">                    
                        <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"> 
                         
                    </div>
                </div>      
                <div class="col-md-12 btnCol">
                    <button class="submitButton" type="submit">{{ __('Register') }}</button>
                    <br/><br/>
                    Exising User? <a href="/login">Login</a> 
                </div>
               
            </div>
        </form>
    </div>
</section> 
@endsection
