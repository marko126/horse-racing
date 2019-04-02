@extends('admin.layout')

@section('content')
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		Profile
	</li>
	<li class="breadcrumb-item active">
		Edit
	</li>
</ol>
<h1>Edit Profile</h1>
<hr>			

@include('admin.global-partials.system-messages')

<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-table"></i> Edit Profile
		
		
		<div class="btn-group btn-group-sm float-right">
			<a class="btn btn-secondary" href="{{route('admin.profile.change-password')}}">
				<i class="fa fa-key"></i>
				Change Pssword
			</a>
		</div>
	</div>
	<div class="card-body">

		<form action="" method="post">
			{{csrf_field()}}
			<div class="form-group">
				<label>Name</label> 
				<input value="{{old('name', $user->name)}}" name="name" placeholder="Enter name" required="required" class="form-control here" type="text"> 
				@if($errors->has('name'))
				<div class="form-errors text-danger">
					@foreach($errors->get('name') as $errorMessage)
					<label class="error">{{$errorMessage}}</label>
					@endforeach
				</div>
				@endif
			</div> 
			<div class="form-group">
				<label>Email</label> 
				<input value="{{old('email', $user->email)}}" name="email" placeholder="Enter email" required="required" class="form-control here" type="text"> 
				@if($errors->has('email'))
				<div class="form-errors text-danger">
					@foreach($errors->get('email') as $errorMessage)
					<label class="error">{{$errorMessage}}</label>
					@endforeach
				</div>
				@endif
			</div> 
			<div class="form-group text-right">
				<button name="submit" type="submit" class="btn btn-primary">Save</button>
			</div>
		</form>
	</div>
</div>
@endsection