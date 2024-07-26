@extends('layouts.admin')

@section('header', 'Create Category')

@section('content')
    <form action="{{ route('categories.store') }}" method="post">
        @csrf
        <div>
            <div class="my-4">
                <label for="name" class="fs-3">Name</label><br>
                <input type="text" class="form-control w-50 rounded-lg" name="name" placeholder="Enter Name ">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-dark mt-4">Create</button>
        </div>
    </form>
@endsection
