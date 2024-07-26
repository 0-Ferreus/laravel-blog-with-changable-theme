@extends('layouts.admin')

@section('header', 'Create Articles')

@section('content')
    <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <div class="my-4">
                <label for="title" class="fs-3">Title</label><br>
                <input type="text" class="form-control w-50 rounded-lg" name="title" placeholder="Enter Name ">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="my-4">
                <label for="category" class="fs-3">Title</label><br>
                <select name="category" id="category" class="form-control w-50 rounded-lg ">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>


                @error('category')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="my-4">
                <label for="body" class="fs-3">Body</label><br>
                <textarea name="body" id="editor" rows="10" class=" w-50 rounded-lg" placeholder="Write your article here....."></textarea>
                @error('body')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="fs-3">Image</label><br>
                <input type="file" class="form-control w-50 rounded-lg mt-4" name="image">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button class="btn btn-dark">Create</button>
        </div>
    </form>
@endsection


@section('scripts')
<script>
    CKEDITOR.replace('editor');
</script>
@endsection
