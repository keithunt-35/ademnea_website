<style>
  .image1{
    width: 30vw;
    height: 30vh;
  }
  .image2{
    margin:20px;
  }

  /*.box{*/
  /*  border: none;*/
  /*}*/

  .container1{
    text-align: center;
  }

  .space{
    width: 10px;
  }
  
  .card {
  background-color: white;
  border-radius: 30px;
  height: auto;
}

.card .card-body {
  background-color: white;
}

.card .card-title {
  font-size: 20px;
  font-weight: bold;
}

.card .card-text {
  font-size: 16px;
}

.card .btn {
  background-color: #5cb874;
  border-color: #5cb874;
}

</style>

<!-- resources/views/website/gallery.blade.php -->
<section id="events" class="events">
  <div class="container">
    <div class="section-title">
      <h2>Events</h2>
    </div>

<div class="row">
  @if($events->count())
    @foreach ($events as $event)
      <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
        <div class="team-item border rounded p-3" style="border-color: #5cb874;">
          <div class="overflow-hidden">

            <a href="/gallery_view?id={{ $event->id }}" style="text-decoration: none !important; color: black;">

              @if ($event->photos->count() > 0)

                <div id="carouselExampleAutoplaying{{ $event->id }}" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner">
                    @foreach ($event->photos as $key => $photo)
                      <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset('images/events/' . $photo->photo_url) }}" class="card-img-top" alt="Event photo">
                      </div>
                    @endforeach
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying{{ $event->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying{{ $event->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>

              @else
                <p>No photos available for this event.</p>
              @endif

            </a>
          </div>

          <div class="position-relative d-flex justify-content-center" style="margin-top: -19px;">
          </div>

          <div class="text-center p-4">
            <h5 class="mb-0">
              <svg style="width: 1.5rem; height: 1.5rem; color:green;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
              </svg>
              {{ $event->venue }}
            </h5>
            <hr>
            <h5 class="mb-0">{{ $event->title }}</h5>

            <span class="collapsed-text">
              {{ \Illuminate\Support\Str::words($event->description, 10, '....') }}
            </span>

            <a data-bs-toggle="modal" data-bs-target="#modal{{ $event->id }}" style="cursor:pointer; color: #5cb874; font-weight: 600;">
              More <i class="fas fa-chevron-down"></i>
            </a>

            <!-- Modal -->
            <div class="modal fade" id="modal{{ $event->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel{{ $event->id }}" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel{{ $event->id }}">{{ $event->title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <small>{!! nl2br(e($event->description)) !!}</small>
                  </div>
                  <div class="modal-footer">
                    @if($event->article_link)
                      <a href="{{ $event->article_link }}" target="_blank" class="text-primary" style="cursor:pointer;">
                        Click Here to read the article
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <!-- end modal -->

          </div>
        </div>
      </div>
    @endforeach
  @else
    <p>No events yet</p>
  @endif
</div>


  </div>
</section>


