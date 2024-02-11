@extends('layouts.app')
@section('title', "Dashboard || Add New Admin")
@section('content')
<section class="index">
    <div class="card border-0">
    <div class="card-header bg-transparent">
        <div class="">
            <h3 class="card-title">{{ translate('Add New User') }}</h3>
            <p><a href="{{url('dashboard')}}">Dashboard</a> / User Create</p>
        </div>
        <a class="btn btn-primary" href="{{ route('users.index') }}"><i class="fa fa-arrow-left"></i> Back to list</a>
    </div>
    <div class="card-body">
        <form action="{{route('admin.store')}}" method="post" class="row">
            @csrf
            <input type="hidden" value="{{\auth()->user()->shop_id}}" name="shop_id" />
            <div class="form-group col-lg-4">
                <label class="req">Role</label>
                <select class="form-select" name="role_id" value="{{@old('role_id')}}">
                    <option selected value="" >Select Role</option>
                    @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
                @error('role_id')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-lg-4">
                <label class="req">Name</label>
                <input type="text" name="name" value="{{@old('name')}}" class="form-control" placeholder="Enter your name" />
                @error('name')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-lg-4">
                <label class="req">Email</label>
                <input type="text" name="email" value="{{@old('email')}}" class="form-control" placeholder="Enter your email" />
                @error('email')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mt-1 col-lg-4">
                <label class="req">Paassword</label>
                <input type="password" name="password" class="form-control" />
                @error('password')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mt-2 col-lg-12">
               <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</section>
@endsection
