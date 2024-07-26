@extends('layouts.admin')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('header')
    <div class="d-flex justify-between">
        <div>
            Theme
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ route('theme.update') }}" method="post">
        @csrf
        <div>
            <div class="my-4">
                <label class="fs-3">Theme Settings</label<br>
            </div>

            <div class="mb-4">
                @if (isset($app))
                    <label for="app_theme" class="fs-3">App Theme</label><br>

                    <select name="app_theme" id="app_theme" class="form-control w-25">
                        @foreach ($app_theme as $app)
                            <option value="{{ $app->id }}" {{ $app->id == $theme->app ? 'selected' : '' }}>
                                {{ $app->name }}</option>
                        @endforeach

                    </select>
                @endif
            </div>

            <div class="mb-4">
                @if (isset($app))
                    <label for="post_theme" class="fs-3">Post Theme</label><br>

                    <select name="post_theme" id="post_theme" class="form-control w-25">
                        @foreach ($post_theme as $post)
                            <option value="{{ $post->id }}" {{ $post->id == $theme->post_theme ? 'selected' : '' }}>
                                {{ $post->name }}</option>
                        @endforeach

                    </select>
                @endif
            </div>

            <div>
                <button class="btn btn-dark mt-4">Update</button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')

@endsection
