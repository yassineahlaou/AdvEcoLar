@extends('frontend.main_master')
@section('content')


<link rel="stylesheet" href="{{asset('css/over.css')}}">
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="/">Home</a></li>
				<li class='active'>Login</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
	<div class="container">
		<div class="sign-in-page">
			<div class="row">
				<!-- Sign-in -->			
<div class="col-md-6 col-sm-6 sign-in">
	<h4 class="">Sign in</h4>
	<p class="">Hello, Welcome to your account.</p>
	<div class="social-sign-in outer-top-xs buttons">
		<a href="{{route('redirect.facebook')}}" class="facebook-sign-in"><i class="fa fa-facebook"></i> Sign In with Facebook</a>
		<a href="{{route('redirect.twitter')}}" class="twitter-sign-in"><i class="fa fa-twitter"></i> Sign In with Twitter</a>
		<a href="{{route('redirect.google')}}" class="google-sign-in"><i class="fa fa-google"></i> Sign In with Google</a>
	</div>
</div>

<div class="col-md-6 col-sm-6 sign-in">
    
    <form method="POST" action="{{isset($guard) ? url($guard.'/login') : route('login')}}">
                        @csrf
		<div class="form-group">
		    <label class="info-title" for="email">Email Address <span>*</span></label>
		    <input type="email" class="form-control unicase-form-control text-input" id="email" name="email" >
			@error('email')
            <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
            @enderror
		</div>
	  	<div class="form-group">
		    <label class="info-title" for="password">Password <span>*</span></label>
		    <input type="password" class="form-control unicase-form-control text-input" id="password" name="password" >
			@error('password')
            <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
            @enderror
		</div>
		<div class="radio outer-xs">
		  	<label>
		    	<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Remember me!
		  	</label>
		  	<a href="{{ route('password.request') }}" class="forgot-password pull-right">Forgot your Password?</a>
		</div>
	  	<button type="submit" class="btn-upper btn btn-primary checkout-page-button">Login</button>
	</form>	
    
</div>
</div>
<!-- Sign-in -->


<!-- create a new account -->			</div><!-- /.row -->
		</div><!-- /.sigin-in-->
		<!-- ============================================== BRANDS CAROUSEL ============================================== -->
@include('frontend.body.brands')
<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	</div><!-- /.container -->
</div><!-- /.body-content -->



@endsection