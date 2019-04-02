@extends('auth.layout')

@section('content')
<div class="card card-login mx-auto mt-5">
	<div class="card-header">Login</div>
	<div class="card-body">

		<form method="POST" action="{{ route('login') }}">
			{{ csrf_field() }}

			<div class="form-group">
				<label>Email</label>
				<input class="form-control" type="email" placeholder="Enter email" name="email" value="{{ old('email') }}" required>
				@if($errors->has('email'))
				@foreach($errors->get('email') as $errorMessage)
				<div class="text-danger">{{$errorMessage}}</div>
				@endforeach
				@endif
			</div>
			<div class="form-group">
				<label>Password</label>
				<input class="form-control" type="password" placeholder="Password" name="password" required>
			</div>
			<div class="form-group">
				<div class="form-check">
					<label class="form-check-label">
						<input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</label>
				</div>
			</div>
			<button type="submit" class="btn btn-primary btn-block">Login</button>
			<a class="btn btn-link btn-block" href="{{ route('password.request') }}">Forgot Your Password?</a>
		</form>

	</div>
</div>

@endsection
