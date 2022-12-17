@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Users</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="px-4">
                        <x-errors></x-errors>
                    </div>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Title</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Create Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\User::all() as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    <i class="fas fa-user me-3"></i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->firstname }} {{ $user->lastname }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->role }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $user->created_at->format('F d, Y') }}</p>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a href="{{ route('user-management.edit', $user->id) }}"
                                                    class="btn btn-link font-weight-bold mb-0">
                                                    <i class="fas fa-pencil"></i>
                                                    Edit</a>

                                                @if ($user->address === 'inactive')
                                                    <form method="POST"
                                                        action="{{ route('user-management.active', $user->id) }}">
                                                        @csrf
                                                        <button class="btn btn-link text-sm font-weight-bold mb-0 ps-2">
                                                            <i class="fas fa-refresh"></i>
                                                            Active</button>
                                                    </form>
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('user-management.inactive', $user->id) }}">
                                                        @csrf
                                                        <button class="btn btn-link text-sm font-weight-bold mb-0 ps-2">
                                                            <i class="fas fa-refresh"></i>
                                                            Inactive</button>
                                                    </form>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
