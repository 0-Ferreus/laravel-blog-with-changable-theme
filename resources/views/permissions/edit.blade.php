@extends('layouts.admin')

@section('header')
    Edit - {{$permission->name}}
@endsection

@section('content')
<form action="{{ route('permissions.update', $permission->id) }}" method="post">
    @csrf
    @method('PUT')
    <div>
        <label for="name" class="fs-3">Name</label><br>
        <input type="text" class="form-control w-50 rounded-lg mt-4" value="{{$permission->name}}" name="name" placeholder="{{$permission->name}}">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
        <button class="btn btn-dark mt-4">Update</button>
    </div>
</form>
@endsection