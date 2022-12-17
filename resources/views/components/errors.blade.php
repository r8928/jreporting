@if ($errors->any())
    @foreach ($errors->all() as $error)
        <small class="text-danger d-block">{{ $error }}</small>
    @endforeach
@endif

@if (session()->has('success'))
    <small class="text-success d-block">{{ session('success') }}</small>
@endif

@if (session()->has('error'))
    <small class="text-danger d-block">{{ session('error') }}</small>
@endif
