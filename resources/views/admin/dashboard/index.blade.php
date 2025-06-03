@extends('layouts.app')
@section('content')

<!-- the four cards above on the dashboard -->
<div class="relative p-3 mt-2 overflow-x-auto shadow-md sm:rounded-lg">
    <div class="container-fluid py-4">
        <div class="row min-vh-80 h-100">
            <div class="col-12">
                <div class="row">

                    <!-- Total Farmers -->
                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center align-self-start">
                                            <h3 class="mb-0 text-success">{{$totalFarmers}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <i class="mdi mdi-account-group mdi-36px text-success"></i>
                                    </div>
                                </div>
                                <h5 class="text-muted font-weight-normal">Total Farmers</h5>
                                <p>This is the total number of farmers currently enrolled in the platform, 
                                   each managing one or more farms through the system.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Farms -->
                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center align-self-start">
                                            <h3 class="mb-0 text-primary">{{$totalFarms}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <i class="mdi mdi-home-group mdi-36px text-primary"></i>
                                    </div>
                                </div>
                                <h5 class="text-muted font-weight-normal">Total Farms</h5>
                                <p>Total number of farms registered and monitored in the system, 
                                   providing hive and team management per farmer.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Hives -->
                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center align-self-start">
                                            <h3 class="mb-0 text-warning">{{$totalHives}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <i class="mdi mdi-cube-outline mdi-36px text-warning"></i>
                                    </div>
                                </div>
                                <h5 class="text-muted font-weight-normal">Total Hives</h5>
                                <p>This represents all beehives managed across farms, 
                                   each tracked individually for productivity and health.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Team -->
                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center align-self-start">
                                            <h3 class="mb-0 text-info">{{$totalTeams}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <i class="mdi mdi-account-tie mdi-36px text-info"></i>
                                    </div>
                                </div>
                                <h5 class="text-muted font-weight-normal">Total Team</h5>
                                <p>Shows the total number of teams or workers actively 
                                   supporting farm operations and hive inspections.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
