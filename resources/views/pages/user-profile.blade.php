@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])

    <x-errors></x-errors>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <form method="POST">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="align-items-center d-flex gap-3">

                                <div class="col-auto text-secondary">
                                    <i class="fas fa-user fa-3x"></i>
                                </div>
                                <div class="col-auto my-auto">
                                    <h5 class="mb-1">
                                        {{ $user->firstname ?? 'Firstname' }} {{ $user->lastname ?? 'Lastname' }}
                                    </h5>
                                    <p class="mb-0 font-weight-bold text-sm">
                                        {{ $user->title }}
                                    </p>
                                </div>


                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control" type="text" name="email"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">First name</label>
                                        <input class="form-control" type="text" name="firstname"
                                            value="{{ old('firstname', $user->firstname) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Last name</label>
                                        <input class="form-control" type="text" name="lastname"
                                            value="{{ old('lastname', $user->lastname) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Title</label>
                                        <input class="form-control" type="text" name="title"
                                            value="{{ old('title', $user->title) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
