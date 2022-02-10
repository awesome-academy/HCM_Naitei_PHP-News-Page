@extends('admin.master_layout')

@section('pageTitle', 'Add Post')

<head>
    <meta charset="UTF-8">
    <script src={{ asset("/resouce/summernote-main/summernote-main/jquery-3.5.1.min.js") }}></script>
    <script src={{ asset("/resouce/summernote-main/summernote-main/popper.min.js") }}></script>

    <link rel="stylesheet" href={{ asset("/resouce/summernote-main/summernote-main/bootstrap.min.css" ) }}>
    <script src={{ asset("/resouce/summernote-main/summernote-main/bootstrap.min.js" ) }}></script>

    <link href={{ asset("/resouce/summernote-main/summernote-main/summernote-bs4.min.css") }} rel="stylesheet">
    <script src={{ asset("/resouce/summernote-main/summernote-main/summernote-bs4.min.js") }}></script>
</head>
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> {{ __('messages.addPost') }} </h1>
    </div>

    <!-- Content -->
    <div class="row justify-content-center">

        <div class="col-xl-5 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div>
                        <div>
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('messages.fillPostInfomation') }}</h1>
                                </div>
                                <form class="user" method="POST" enctype="multipart/form-data"
                                    action="{{ route('post.store') }}">
                                    <div class="form-group">
                                        {{ method_field('POST') }}
                                        @csrf
                                        <div class="mb-3 form-group">
                                            <label class="control-label"
                                                for="title"><b>{{ __('messages.title') }}</b></label>
                                            <input cols="30" type="text" name="title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"
                                                for="content"><b>{{ __('messages.content') }}</b></label>
                                            <textarea class="form-control" name="body" id="summernote"></textarea>
                                        </div>
                                        <label for=""><b>{{ __('messages.selectCategory') }}</b></label>
                                        <select name="category_id" class="form-control" id="sel1">
                                            @foreach ($categories_sub as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="mb-3 form-group mt-3">
                                            <div class="form-group">
                                                <strong>{{ __('messages.image') }}</strong>
                                                <input type="file" name="images" class="form-control"
                                                    placeholder="image" multiple>
                                            </div>
                                        </div>
                                        <input type="submit" value="{{ __('messages.insert') }}"
                                            class="btn btn-primary mt-5">
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @if ($errors->any())
    <div class="alert alert-danger w-25 alert_center">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<!-- partial:index.partial.html -->
<!-- partial -->
<script type="text/javascript" src={{ asset("/resouce/summernote-main/summernote-main/script.js") }}></script>

@endsection