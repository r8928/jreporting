@php $page_title='SSR Config' @endphp
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $page_title])

    <div class="container-fluid ssr-report">
        <div class="card">
            <div class="card-header pb-0">
                <h4 class="mb-0">{{ $page_title }}</h4>
            </div>
            <form method="POST" class="card-body">
                @csrf
                <label class="d-block">Show these categories in summary</label>
                <textarea name="ssr_categories" rows="10" class="form-control">{!! old('ssr_categories', $categories) !!}</textarea>

                <x-errors></x-errors>

                <button type="submit" class="d-inline-block btn bg-gradient-dark mt-3">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    Save</button>
            </form>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
