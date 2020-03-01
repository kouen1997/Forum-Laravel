<div class="col-md-8">
    <h3 class="pb-3 mb-4 border-bottom">
        Dashboard
    </h3>
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 mb-4">
            <div class="bg-white rounded shadow-sm services-border shadow-hover">
                <h5 class="pt-4 pb-2 text-center">
                    <a href="#" class="text-dark services-title">Services</a>
                </h5>
                <a href="#">
                    <img src="{{ URL::asset('assets/dashboard/img/services.png') }}" alt="" class="img-fluid">
                </a>
                <div class="p-4">
                    <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                        <div class="badge badge-danger px-3 rounded-pill font-weight-normal">SERVICES</div>
                        <p class="small mb-0"><span class="font-weight-bold"><a href="#" class="h-link">Click here</a></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 mb-4">
            <div class="bg-white rounded shadow-sm services-border shadow-hover">
                <h5 class="pt-4 pb-2 text-center">
                    <a href="#" class="text-dark services-title">Tools</a>
                </h5>
                <a href="#">
                    <img src="{{ URL::asset('assets/dashboard/img/tools.png') }}" alt="" class="img-fluid">
                </a>
                <div class="p-4">
                    <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                        <div class="badge badge-primary px-3 rounded-pill font-weight-normal">TOOLS</div>
                        <p class="small mb-0"><span class="font-weight-bold"><a href="#" class="h-link">Click here</a></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 mb-4">
            <div class="bg-white rounded shadow-sm services-border shadow-hover">
                <h5 class="pt-4 pb-2 text-center">
                    <a href="#" class="text-dark services-title">Trivia</a>
                </h5>
                <a href="#">
                    <img src="{{ URL::asset('assets/dashboard/img/trivia.png') }}" alt="" class="img-fluid">
                </a>
                <div class="p-4">
                    <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                        <div class="badge badge-warning px-3 rounded-pill font-weight-normal text-white">TRIVIA</div>
                        <p class="small mb-0"><span class="font-weight-bold"><a href="{{ url('/trivia') }}" class="h-link">Click here</a></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 mb-4">
            <div class="bg-white rounded shadow-sm services-border shadow-hover">
                <h5 class="pt-4 pb-2 text-center">
                    <a href="#" class="text-dark services-title">Video Tutorial</a>
                </h5>
                <a href="#">
                    <img src="{{ URL::asset('assets/dashboard/img/video.png') }}" alt="" class="img-fluid">
                </a>
                <div class="p-4">
                    <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                        <div class="badge badge-success px-3 rounded-pill font-weight-normal">VIDEO TUTORIAL</div>
                        <p class="small mb-0"><span class="font-weight-bold"><a href="{{ url('/video/tutorial') }}" class="h-link">Click here</a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>