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
    

            /*--------------------------------------------------------------
            # Team Section
            --------------------------------------------------------------*/
            .team .team-member .member-img {
              border-radius: 8px;
              overflow: hidden;
            }
            .team .team-member .social {
              position: absolute;
              left: 0;
              top: -18px;
              right: 0;
              opacity: 0;
              transition: ease-in-out 0.3s;
              display: flex;
              align-items: center;
              justify-content: center;
            }
            .team .team-member .social a {
              transition: color 0.3s;
              color: blue;
              background: #0ea2bd;
              margin: 0 5px;
              display: inline-flex;
              align-items: center;
              justify-content: center;
              width: 36px;
              height: 36px;
              border-radius: 50%;
              transition: 0.3s;
            }
            .team .team-member .social a i {
              line-height: 0;
              font-size: 16px;
            }
            .team .team-member .social a:hover {
              background: #1ec3e0;
            }
            .team .team-member .social i {
              font-size: 18px;
              margin: 0 2px;
            }
            .team .team-member .member-info {
              padding: 30px 15px;
              text-align: center;
              box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
              background: #ffffff;
              margin: -50px 20px 0 20px;
              position: relative;
              border-radius: 8px;
            }
            .team .team-member .member-info h4 {
              font-weight: 400;
              margin-bottom: 5px;
              font-size: 24px;
              color: #485664;
            }
            .team .team-member .member-info span {
              display: block;
              font-size: 16px;
              font-weight: 400;
              color: var(--color-gray);
            }
            .team .team-member .member-info p {
              font-style: italic;
              font-size: 14px;
              line-height: 26px;
              color: #6c757d;
            }
            .team .team-member:hover .social {
              opacity: 1;
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
    <section id="publications" class="publications">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>AdEMNEA Publications</h2>
                <p>Our latest research publications and findings</p>
            </div>

            @if($publication->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Year</th>
                            <th style="width: 25%;">Title</th>
                            <th style="width: 25%;">Authors</th>
                            <th style="width: 25%;">Publisher</th>
                            <th style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($publication->sortByDesc('year') as $item)
                        <tr>
                            <td>{{ $item->year }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->publisher }}</td>
                            <td>
                                @if($item->google_scholar_link)
                                    <a href="{{ $item->google_scholar_link }}" target="_blank" class="btn btn-sm btn-primary" title="View on Google Scholar">
                                        <i class="bi bi-google"></i>
                                    </a>
                                @endif
                                @if($item->attachment)
                                    <a href="{{ asset($item->attachment) }}" class="btn btn-sm btn-success" title="Download" download>
                                        <i class="bi bi-download"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="alert alert-info">No publications available at the moment.</div>
            @endif
        </div>
        
    </section>
  </main><!-- End #main -->


    <!-- ======= Footer ======= -->
    @include('website.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @include('website.scripts')

</body>

</html>
























