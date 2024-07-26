@extends('layouts.admin')

@section('header')
    Edit - {{$role->name}}
@endsection

@section('content')
<form action="{{ route('roles.update', $role->id) }}" method="post">
    @csrf
    @method('PUT')
    <div>
        <div class="my-4">
        <label for="name" class="fs-3">Name</label><br>
        <input type="text" class="form-control w-50 rounded-lg" value="{{$role->name}}" name="name" placeholder="{{$role->name}}">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
        @if($permissions->isNotEmpty())
            <label for="name" class="fs-3">Permissions</label><br>
            <div class="row">
                @foreach($permissions as $permission)
                <div class="col-3 py-2">
                    <input 
                    {{($hasPermissions->contains($permission->name))?'checked':''}}
                    type="checkbox" class="rounded" name="permissions[]" value="{{$permission->name}}" id="perm-{{$permission->id}}"> 
                    <label for="perm-{{$permission->id}}" class="">{{$permission->name}}</label><br>
                    
                </div>
                @endforeach
            </div>
            @endif
        <button class="btn btn-dark mt-4">Update</button>
    </div>
</form>
@endsection