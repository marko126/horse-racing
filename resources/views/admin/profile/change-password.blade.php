@extends('admin.layout')

@section('content')
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		Profile
	</li>
	<li class="breadcrumb-item active">
		Change password
	</li>
</ol>
<h1>Change password</h1>
<hr>			

@include('admin.global-partials.system-messages')

<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-table"></i> Change password
		
		<div class="btn-group btn-group-sm float-right">
			<a class="btn btn-secondary" href="{{route('admin.profile.edit')}}">
				<i class="fa fa-id-card"></i>
				Edit Profile
			</a>
		</div>
	</div>
	<div class="card-body">

		<form action="" method="post">
			{{csrf_field()}}
			<div class="form-group">
				<label>Old Password</label> 
				<input name="old_password" placeholder="Enter old password" required="required" class="form-control here" type="password"> 
				<div class="form-errors text-danger">
				@if($errors->has('old_password'))
					@foreach($errors->get('old_password') as $errorMessage)
					<label class="error">{{$errorMessage}}</label>
					@endforeach
				@endif
				</div>
			</div> 
			<div class="form-group">
				<label>New Password</label> 
				<input name="password" placeholder="Enter new password" required="required" class="form-control here" type="password"> 
				<div class="form-errors text-danger">
				@if($errors->has('password'))
					@foreach($errors->get('password') as $errorMessage)
					<label class="error">{{$errorMessage}}</label>
					@endforeach
				@endif
				</div>
			</div> 
			<div class="form-group">
				<label>Confirm Password</label> 
				<input name="password_confirmation" placeholder="Repeat password" required="required" class="form-control here" type="password"> 
				<div class="form-errors text-danger">
				@if($errors->has('password_confirmation'))
					@foreach($errors->get('password_confirmation') as $errorMessage)
					<label class="error">{{$errorMessage}}</label>
					@endforeach
				@endif
				</div>
			</div>
			<div class="form-group text-right">
				<button name="submit" type="submit" class="btn btn-primary">Change Password</button>
			</div>
		</form>
	</div>
</div>
@endsection