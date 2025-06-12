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

    </style>
    @include('website.links')

    <!-- =======================================================
  * Template Name: Green - v4.3.0
  * Template URL: https://bootstrapmade.com/green-free-one-page-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Top Bar ======= -->
    @include('website.top_bar')

    <!-- ======= Header ======= -->
    @include('website.header')
    <!-- End Header -->



    <main id="main">
        <!-- ======= Scholarship Section ======= -->
        <section id="scholarship" class="about pt-o">
            <div class="container">
                @if ($scholarships->count())
                    <div class="section-title">
                        <h2>call for scholarships</h2>
                    </div>
                   
                    @foreach($scholarships as $scholarship)
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card mb-4 custom-card" style="background-color: white; border-radius: 30px; height: auto;">
            <div class="card-body" style="background-color:white;">
                <h4 class="card-title">
                    <a href="#">{{ $scholarship->title }}</a>
                </h4>
                <p class="card-text">
                    {{ Str::limit(strip_tags($scholarship->description), 300) }}
                </p>

                <!-- Button to trigger modal -->
                <button type="button" class="btn btn-primary" style="background-color: #5cb874" 
                        data-bs-toggle="modal" 
                        data-bs-target="#scholarshipModal{{ $scholarship->id }}">
                    Read More
                </button>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="scholarshipModal{{ $scholarship->id }}" tabindex="-1" aria-labelledby="scholarshipModalLabel{{ $scholarship->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Optional: Add a title here -->
                <h5 class="modal-title fw-bold" id="scholarshipModalLabel{{ $scholarship->id }}">Instructions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add margin bottom for spacing -->
                <div class="mb-3">
                    {!! $scholarship->instructions !!}
                </div>
            </div>

               <!-- Modal footer with Download button -->
            <div class="modal-footer">
                <a href="{{ route('scholarship.downloadInstructions', $scholarship->id) }}" class="btn btn-success" target="_blank">
                    Download Instructions
                </a>

            </div>

        </div>
    </div>
</div>

@endforeach


                @else
                    <p>There are currently no scholarships</p>
                @endif
            </div>
        </section>

        <!-- End Scholarship Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('website.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @include('website.scripts')

</body>

</html>
