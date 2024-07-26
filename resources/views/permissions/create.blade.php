@extends('layouts.admin')

@section('header','Create Permissions')

@section('content')
    <form action="{{ route('permissions.store') }}" method="post">
        @csrf
        <div>
            <label for="name" class="fs-3">Name</label><br>
            <input type="text" class="form-control w-50 rounded-lg mt-4" name="name" placeholder="Enter Name ">
            @error('name')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <button class="btn btn-dark mt-4">Create</button>
        </div>
    </form>
@endsection