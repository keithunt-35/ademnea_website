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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <style>
        /* Existing styles remain unchanged */
        #collapseExample.collapse:not(.show) {
            display: block;
            height: 3rem;
            overflow: hidden;
        }
        #collapseExample.collapsing {
            height: 3rem;
        }
        /* Team Section styles remain unchanged */
        .team .team-member .member-img {
            border-radius: 8px;
            overflow: hidden;
        }
        /* ... (rest of the team styles unchanged) */

        /* New styles for publications */
        .publication-list {
            margin-top: 20px;
        }
        .publication-item {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .publication-item h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .publication-item h3 a {
            color: #0ea2bd;
            text-decoration: none;
        }
        .publication-item h3 a:hover {
            color: #1ec3e0;
            text-decoration: underline;
        }
        .publication-item p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }
        .publication-item .authors {
            color: #555;
        }
        .publication-item .description {
            color: #666;
        }
        .publication-item .cited-by {
            font-weight: bold;
        }
    </style>

    @include('website.links')
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
                    <p>Our latest research publications</p>
                </div>

                @if($publication->count())
                    <div class="publication-list">
                        @foreach($publication->sortByDesc('year') as $item)
                            <div class="publication-item">
                                <h3>
                                    @if($item->google_scholar_link)
                                        <a href="{{ $item->google_scholar_link }}" target="_blank">[HTML] {{ $item->title }}</a>
                                    @elseif($item->attachment)
                                        <a href="{{ asset($item->attachment) }}" target="_blank">[HTML] {{ $item->title }}</a>
                                    @else
                                        {{ $item->title }}
                                    @endif
                                </h3>
                                <p class="authors">{{ $item->name }}</p>
                                @if(isset($item->description))
                                    <p class="description">{{ $item->description }}</p>
                                @else
                                    <p class="description">No description available.</p>
                                @endif
                                <p>{{ $item->publisher }}, {{ $item->year }}</p>
                                @if(isset($item->cited_by))
                                    <p class="cited-by">Cited by: {{ $item->cited_by }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">Publications are to be uploaded shortly.</div>
                @endif
            </div>
        </section>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('website.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    @include('website.scripts')
</body>
</html>