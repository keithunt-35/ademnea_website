@extends('layouts.app')
@section('content')

<!-- the four cards above on the dashboard -->
<div class="relative p-3 mt-2 overflow-x-auto shadow-md sm:rounded-lg">
    <div class="container-fluid py-4">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
        <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-9">
                    <div class="d-flex align-items-center align-self-start">
                        <h3 class="mb-0" style="color: #28a745;">{{$totalFarmers}}</h3>                 
                    </div>
                    </div>
                    <div class="col-3">
                    <div class="icon icon-box-success ">
                        <span class="mdi mdi-arrow-top-right icon-item"></span>
                    </div>
                    </div>
                </div>
                <h5 class="text-muted font-weight-normal"  style="color: #28a745;">Total Farmers</h5>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. </p>
                </div>
            </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-9">
                    <div class="d-flex align-items-center align-self-start">
                        <h3 class="mb-0" style="color: #28a745;">{{$totalFarms}}</h3>
                    </div>
                    </div>
                    <div class="col-3">
                    <div class="icon icon-box-success">
                        <span class="mdi mdi-arrow-top-right icon-item"></span>
                    </div>
                    </div>
                </div>
                <h5 class="text-muted font-weight-normal">Total Farms</h5>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. </p>
                </div>
            </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-9">
                    <div class="d-flex align-items-center align-self-start">
                        <h3 class="mb-0" style="color: #28a745;">{{$totalHives}}</h3>             
                    </div>
                    </div>
                    <div class="col-3">
                    <div class="icon icon-box-danger">
                        <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                    </div>
                    </div>
                </div>
                <h5 class="text-muted font-weight-normal">Total Hives</h5>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. </p>
                </div>
            </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-9">
                    <div class="d-flex align-items-center align-self-start">
                        <h3 class="mb-0" style="color: #28a745;">{{$totalTeams}}</h3>
                        
                    </div>
                    </div>
                    <div class="col-3">
                    <div class="icon icon-box-success ">
                        <span class="mdi mdi-arrow-top-right icon-item"></span>
                    </div>
                    </div>
                </div>
                <h5 class="text-muted font-weight-normal">Total Team</h5>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Add other things for the dasnboard here -->
       
@endsection
