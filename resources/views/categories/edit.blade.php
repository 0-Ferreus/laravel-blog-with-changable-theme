@extends('layouts.admin')

@section('header')
    Edit - {{$category->name}}
@endsection

@section('content')
<form action="{{ route('categories.update', $category->id) }}" method="post">
    @csrf
    @method('PUT')
    <div>
        <div class="my-4">
        <label for="name" class="fs-3">Name</label><br>
        <input type="text" class="form-control w-50 rounded-lg" value="{{$category->name}}" name="name" placeholder="{{$category->name}}">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
        
        <button class="btn btn-dark mt-4">Update</button>
    </div>
</form>
@endsection