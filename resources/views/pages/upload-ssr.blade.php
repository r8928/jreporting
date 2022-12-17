@php $page_title='Upload SSR File' @endphp
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $page_title])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">{{ $page_title }}</p>
                        </div>
                    </div>
                    {{-- @if (request()->isMethod('POST')) --}}
                    {{-- @endif --}}
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="align-items-center d-flex gap-3">
                                <div
                                    class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                    <i class="far fa-file-excel opacity-10" aria-hidden="true"></i>
                                </div>

                                <div>
                                    <label class="d-block">Select a CSV file to upload</label>
                                    <input type="file" name="file" required>
                                    <x-errors></x-errors>
                                </div>
                            </div>

                            <button type="submit" class="d-inline-block btn bg-gradient-dark ms-6 mt-3 mb-0"">
                                <i class="ni ni-cloud-upload-96" aria-hidden="true"></i> Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
