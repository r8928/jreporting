@php $page_title='SSR Report' @endphp
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $page_title])

    <div class="container-fluid ssr-report">
        <div class="card">
            <div class="card-header pb-0">
                <form id="myForm" class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-control-label">Item Code</label>
                            <input class="form-control" type="text" name="item_code">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Description</label>
                            <input class="form-control" type="text" name="description">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-label">Category</label>
                            <input class="form-control" type="text" name="category">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-group">
                            <label class="form-control-label d-block">&nbsp;</label>
                            <button type="submit" class="btn bg-gradient-dark">
                                <i class="fas fa-search" aria-hidden="true"></i> Search</button>
                        </div>
                    </div>
                </form>
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
                });
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
                });

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
