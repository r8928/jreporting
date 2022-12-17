@php $page_title='SSR Summary' @endphp
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $page_title])

    <div class="container-fluid ssr-report">
        <div class="card">
            <div class="card-header pb-0">
                <label class="row gap-3 justify-content-center">Select Summary Groupping</label>
                <div class="row gap-3 justify-content-center">
                    <a href="{{ route('ssr-summary.groupping', 'category') }}"
                        class="col-md-3 btn {{ request()->is('ssr-summary/category') ? 'btn-secondary' : 'btn-primary' }} btn-lg">Category</a>
                    <a href="{{ route('ssr-summary.groupping', 'department') }}"
                        class="col-md-3 btn {{ request()->is('ssr-summary/department') ? 'btn-secondary' : 'btn-primary' }} btn-lg">Department</a>
                    <a href="{{ route('ssr-summary.groupping', 'condition') }}"
                        class="col-md-3 btn {{ request()->is('ssr-summary/condition') ? 'btn-secondary' : 'btn-primary' }} btn-lg">Condition</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            @if (!empty($top_headers) && is_array($top_headers))
                                <tr>
                                    @foreach ($top_headers as $header)
                                        <th colspan="{{ $header['colspan'] }}"
                                            class="border text-uppercase text-secondary text-center font-weight-bolder opacity-7 ps-2 pe-0">
                                            {{ $header['title'] }}</th>
                                    @endforeach
                                </tr>
                            @endif
                            <tr>
                                {{-- @php $headers = ['category', 'center', 'north', 'south', 'total']; @endphp --}}
                                @foreach ($headers as $header)
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2 pe-0">
                                        {{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach ($ssr as $row)
                                <tr>
                                    @foreach ($headers as $header)
                                        <td>{{ $row[$header] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script>
        var isFiltered = false;
        var data = @json($ssr);
        const headers = @json($headers);

        function loadData(data) {
            tbody.innerHTML =
                '<td colspan="10" class="text-center"><i class="fas fa-circle-notch fa-spin fa-3x"></i><td>';

            setTimeout(() => {
                let html = '';
                data.forEach(r => {
                    html += "<tr>";
                    headers.forEach(h => {
                        html += `<td>${r[h]}</td>`;
                    })
                    html += "</tr>";
                });

                tbody.innerHTML = html;
            }, 1000);
        }

        document.querySelector('#myForm').addEventListener('submit', function() {
            event.preventDefault();
            const item_code = this.elements.item_code.value.trim() || '';
            const description = this.elements.description.value.trim() || '';
            const category = this.elements.category.value.trim() || '';

            if (item_code || description || category) {
                const filteredData = data.filter(r => {

                    return (item_code ? r.item_code.toLowerCase().includes(item_code.toLowerCase()) :
                            true) &&
                        (description ? r.description.toLowerCase().includes(description.toLowerCase()) :
                            true) &&
                        (category ? r.category.toLowerCase().includes(category.toLowerCase()) : true)

                    if (item_code) {
                        if (r.item_code.toLowerCase().includes(item_code.toLowerCase())) {
                            return true;
                        }
                    }
                    if (description) {
                        if (r.description.toLowerCase().includes(description.toLowerCase())) {
                            return true;
                        }
                    }
                    if (category) {
                        if (r.category.toLowerCase().includes(category.toLowerCase())) {
                            return true;
                        }
                    }

                    return false;

                })

                isFiltered = true;
                loadData(filteredData);
                return;
            }

            if (isFiltered) {
                loadData(data)
            }
        });
    </script>
@endsection
