@extends('admin.master_layout')

@section('pageTitle', 'View Profile')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('messages.bulletUserProfile') }}</h1>
    </div>

    <div class="row justify-content-center">

        <div class="col-xl-5 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div >
                        <div class="row align-avatar">
                            <img class="avatar-big" src={{ asset($path_to_ui . "img/sample_avt.png") }}>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#change_avatar">
                                {{ __('messages.Change avatar') }} 
                            </a>
                            <div class="modal fade" id="change_avatar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.Upload avatar') }}</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="edit-avatar" href={{ route('user.show', ['id' => $user->id ]) }}>
                                                <label for="img">{{ __('messages.Select image:') }}</label>
                                                <input type="file" id="img" name="img" accept="image/*">
                                                <input class="btn btn-primary" type="submit">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('messages.Cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('messages.User\'s informations:') }}</h1>
                                </div>
                                <table class="table table-bordered text-left" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <th>{{ __('messages.Username') }}</th>
                                            <th>{{ $user->name }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{ __('messages.Mail') }}</th>
                                            <th>{{ $user->email }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{ __('messages.role') }}</th>
                                            <th>{{ $user->role['name'] }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <form class="user">
                                    <a href={{ route('user.edit', ['id' => $user->id ]) }} class="btn btn-primary btn-user btn-block">
                                        {{ __('messages.EDIT') }}
                                    </a>
                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
