@extends('layouts.admin')

@section('header')
    Edit - {{$article->title}}
@endsection

@section('content')
    <form id="editSettings" class="ajax-form" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div>
            <div class="my-4">
                <input type="text" value="{{$article->id}}" id="id" hidden>
                <label for="title" class="fs-3">Title</label><br>
                <input type="text" class="form-control w-50 rounded-lg" name="title" placeholder="Enter Name " value="{{$article->title}}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="my-4">
                <label for="category" class="fs-3">Title</label><br>
                <select name="category" id="category" class="form-control w-50 rounded-lg ">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" {{ ($article->category_id) == ($category->id) ? 'selected' : '' }}>{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="my-4">
                <label for="body" class="fs-3">Body</label><br>
                <textarea name="body" id="editor" rows="10" class=" w-50 rounded-lg" placeholder="Write your article here....." >{{$article->body}}</textarea>
                @error('body')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <img id="image-preview" src="{{ asset('images/' . $article->image) }}" alt="" class="mb-4">
            </div>
            <div class="mb-4">
                <label for="image" class="fs-3">Image</label><br>
                <input type="file" class="form-control w-50 rounded-lg mt-4" name="image" id="image" onchange="previewImage(event)">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="button" id="update" class="btn btn-dark">Update</button>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image-preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


<script>
    CKEDITOR.replace('editor');
</script>
<script>
    $('#update').click(function(e) {
            const editorData = CKEDITOR.instances.editor.getData();
            $('textarea[name="body"]').val(editorData);

            const formData = new FormData($('#editSettings')[0]);
            const id = $('#id').val();

            $.ajax({
                url: `{{ route('articles.update', ':id') }}`.replace(':id', id),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === "success") {
                        window.location.href = '{{ route('articles.index') }}';
                    }
                },
                error: function(response) {
                    console.log('Error:', response);
                }
            });
        });
</script>
@endsection