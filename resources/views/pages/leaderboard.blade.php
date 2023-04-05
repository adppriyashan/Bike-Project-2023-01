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
                    @include('layouts.flash')
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Leaderboard (Top 10)</h4>
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
                                                    <th>Rank</th>
                                                    <th>User</th>
                                                    <th>Email</th>
                                                    <th>Distance</th>
                                                    <th>Available Discount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key=>$user)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->distance }} KM</td>
                                                        <td>{{ (10-$key) }}%</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
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
@endsection
