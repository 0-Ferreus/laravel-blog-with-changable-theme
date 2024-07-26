@extends('layouts.admin')

@section('header')
    Edit - {{$user->name}}
@endsection

@section('content')

<form action="{{ route('users.update', $user->id) }}" method="post">
    @csrf
    @method('PUT')
    <div>
        <div class="my-4">
        <label for="name" class="fs-3">Name</label><br>
        <input type="text" class="form-control w-50 rounded-lg" value="{{$user->name}}" name="name" placeholder="{{$user->name}}">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div>
        <div class="my-4">
        <label for="email" class="fs-3">Email</label><br>
        <input type="email" class="form-control w-50 rounded-lg" value="{{$user->email}}" name="email" placeholder="{{$user->email}}">
        @error('email')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
        @if($roles->isNotEmpty())
            <label for="name" class="fs-3">Role</label><br>
            <div class="row">
                @foreach($roles as $role)
                <div class="col-3 py-2">
                    <input 
                    {{($hasRole->contains($role->name))?'checked':''}}
                    type="checkbox" class="rounded" name="roles[]" value="{{$role->name}}" id="perm-{{$role->id}}"> 
                    <label for="perm-{{$role->id}}" class="">{{$role->name}}</label><br>
                    
                </div>
                @endforeach
            </div>
            @endif
        <button class="btn btn-dark mt-4">Update</button>
    </div>
</form>
@endsection