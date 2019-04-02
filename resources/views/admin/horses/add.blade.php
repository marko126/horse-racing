@extends('admin.layout')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{route('admin.horses.index')}}">Horses</a>
    </li>
    <li class="breadcrumb-item active">
        Add
    </li>
</ol>
<h1>Add new Horse</h1>
<hr>			

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> Add Horse
    </div>
    <div class="card-body">

        <form id="row-form" action="" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <fieldset class="col-lg-6">
                    <div class="form-group">
                        <label>Name</label> 
                        <input value="{{ old('name') }}" name="name" placeholder="Enter Name" required="required" class="form-control" type="text"> 
                        @if($errors->has('name'))
                        <div class="form-errors text-danger">
                            @foreach($errors->get('name') as $errorMessage)
                            <label class="error">{{$errorMessage}}</label>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Speed</label> 
                        <input value="{{ old('speed') }}" name="speed" placeholder="Enter Speed" required="required" class="form-control" type="text"> 
                        @if($errors->has('speed'))
                        <div class="form-errors text-danger">
                            @foreach($errors->get('speed') as $errorMessage)
                            <label class="error">{{$errorMessage}}</label>
                            @endforeach
                        </div>
                        @endif
                    </div> 
                    <div class="form-group">
                        <label>Strength</label> 
                        <input value="{{ old('strength') }}" name="strength" placeholder="Enter Strength" required="required" class="form-control" type="text"> 
                        @if($errors->has('strength'))
                        <div class="form-errors text-danger">
                            @foreach($errors->get('strength') as $errorMessage)
                            <label class="error">{{$errorMessage}}</label>
                            @endforeach
                        </div>
                        @endif
                    </div> 
                    <div class="form-group">
                        <label>Endurance</label> 
                        <input value="{{ old('endurance') }}" name="endurance" placeholder="Enter Endurance" required="required" class="form-control" type="text"> 
                        @if($errors->has('endurance'))
                        <div class="form-errors text-danger">
                            @foreach($errors->get('endurance') as $errorMessage)
                            <label class="error">{{$errorMessage}}</label>
                            @endforeach
                        </div>
                        @endif
                    </div> 
                </fieldset>

            </div>

            <div class="row">
                <div class="form-group text-right col-lg-12">
                    <hr>
                    <a class="btn btn-secondary" href="{{route('admin.horses.index')}}">Cancel</a>
                    <button name="submit" type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
