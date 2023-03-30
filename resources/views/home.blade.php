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
                    <div class="col-md-4">
                        <div class="card fill">
                            <div class="card-header">
                                <h6>Rides Availability</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="rides_availability"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card fill">
                            <div class="card-header">
                                <h6>Reservations (Daily Basis)</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="rides_reservations"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 my-4">
                        <div class="card fill">
                            <div class="card-header">
                                <h6>Sales By Line</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="sales_reservations"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 my-4">
                        <div class="card fill">
                            <div class="card-header">
                                <h6>Sales By Redar View</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="sales_reservations_scatter"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <script>
        let ridesAvailability=@json($ridesAvailability);
        let ridesReservations=@json($ridesReservations);
        let ridesReservationsDates=@json($ridesReservationsDates);
    </script>

    @include('layouts.footer')
    @include('layouts.scripts')
@endsection
