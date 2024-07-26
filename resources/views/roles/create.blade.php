@extends('layouts.admin')

@section('header', 'Create Role')

@section('content')
    <form action="{{ route('roles.store') }}" method="post">
        @csrf
        <div>
            <div class="my-4">
                <label for="name" class="fs-3">Name</label><br>
                <input type="text" class="form-control w-50 rounded-lg" name="name" placeholder="Enter Name ">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            
            @if($permissions->isNotEmpty())
            <label for="name" class="fs-3">Permissions</label><br>
            <div class="row">
                @foreach($permissions as $permission)
                <div class="col-3 py-2">
                    <input type="checkbox" class="rounded" name="permissions[]" value="{{$permission->name}}" id="perm-{{$permission->id}}"> 
                    <label for="perm-{{$permission->id}}" >{{$permission->name}}</label><br>
                    
                </div>
                @endforeach
            </div>
            @endif

            <button class="btn btn-dark mt-4">Create</button>
        </div>
    </form>
@endsection
