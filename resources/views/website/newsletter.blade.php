<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Adaptive Environmental Monitoring Networks for East Africa</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <style>
        #collapseExample.collapse:not(.show) {
            display: block;
            height: 3rem;
            overflow: hidden;
        }

        #collapseExample.collapsing {
            height: 3rem;
        }

        .custom-card {
  background-color: white;
  border-radius: 30px;
  height: auto;
}

.custom-card .card-body {
  background-color: white;
}

.custom-card .card-title {
  font-size: 20px;
  font-weight: bold;
}

.custom-card .card-text {
  font-size: 16px;
}

.custom-card .btn {
  background-color: #5cb874;
  border-color: #5cb874;
}

    </style>
    @include('website.links')

    <!-- =======================================================
  * Template Name: Green - v4.3.0
  * Template URL: https://bootstrapmade.com/green-free-one-page-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body >

    <!-- ======= Top Bar ======= -->
    @include('website.top_bar')

    <!-- ======= Header ======= -->
    @include('website.header')
    <!-- End Header -->

            <main id="main">
                    <!-- ======= Scholarship Section ======= -->
                    <section id="scholarship" class="about pt-0">
                        <div class="container pt-5">

                            {{-- Uncomment and adjust if you need the header section --}}
                            {{-- <div class="h5 text-center container">
                                <h1>News about the project</h1>
                            </div> --}}
                            
                            @php
                    use Illuminate\Support\Str;
                @endphp

                @if ($newsletter->count())
                    <div class="container pt-5">
                        <div class="h5 text-center">
                            <h1 style="color:white">News about the project</h1>
                        </div>
                        <div class="row">
                            @foreach ($newsletter as $workpackage)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card mb-4 custom-card" style="background-color: white; border-radius: 30px; height: auto;">
                                        <div class="card-body" style="background-color:white;">
                                            <h4 class="card-title">
                                                <a href="#">{{ $workpackage->title }}</a>
                                            </h4>
                                            <p class="card-text">
                                                {!! Str::words(strip_tags($workpackage->description), 100, '...') !!}
                                            </p>
                                            <!-- Button to trigger modal -->
                                            <button type="button" class="btn btn-primary" style="background-color: #5cb874" data-bs-toggle="modal" data-bs-target="#newsletterModal{{ $workpackage->id }}">
                                                Read More
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="newsletterModal{{ $workpackage->id }}" tabindex="-1" aria-labelledby="newsletterModalLabel{{ $workpackage->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newsletterModalLabel{{ $workpackage->id }}">{{ $workpackage->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <div class="modal-body">
                                                    {!! $workpackage->article !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p>No Articles now</p>
                @endif


                        </div>
                    </section>
                    <!-- End Scholarship Section -->
            </main>
<!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('website.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @include('website.scripts')

</body>

</html>
