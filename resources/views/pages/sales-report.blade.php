@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Filters</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a onclick="resetFilters()" data-action="reload"><i
                                                    class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="from"><small class="text-dark">From
                                                            Date</small></label>
                                                    <input type="date" name="from" id="from" class="form-control"
                                                        placeholder="From Date">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="to"><small class="text-dark">To
                                                            Date</small></label>
                                                    <input type="date" name="to" id="to" class="form-control"
                                                        placeholder="To Date">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <button id="filterbtn" class="btn btn-info float-right ml-1"
                                                        onclick="reloadTable()">Filter Data</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @include('layouts.flash')
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sales Report</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a onclick="refreshTable()" data-action="reload"><i
                                                    class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table w-100" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th>Sale ID</th>
                                                    <th>Bike</th>
                                                    <th>User</th>
                                                    <th>Distance</th>
                                                    <th>Ride At</th>
                                                    <th>Drop At</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    <!-- END: Content-->



    @include('layouts.footer')
    @include('layouts.scripts')
    <script>
         var invoicetable = $('#datatable').DataTable({
            serverSide: true,
            lengthMenu: [
                [11, 26, 51, -1],
                [10, 25, 50, "All"]
            ],
            language: {
                searchPlaceholder: "Reference"
            },
            responsive: true,
            ordering: false,
            ajax: {
                url: '{{ route('admin.sale.report.list') }}',
                data: function(d) {
                    return $.extend(d, {
                        'from': $('#from').val(),
                        'to': $('#to').val()
                    });
                }
            },
            createdRow: function(row, data, dataIndex, cells) {
                $(cells).addClass(' align-middle datatables-sm text-avoid-break');
            }
        });
        function reloadTable() {
            invoicetable.ajax.reload();
        }
    </script>
@endsection
