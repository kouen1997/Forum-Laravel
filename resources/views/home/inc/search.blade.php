<section id="hero-area" class="parallax-search overlay main-search-inner search-2" data-stellar-background-ratio="0.5">
    <div class="hero-main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-inner">
                        <div class="welcome-text">
                            <h1>Gateway To Your Dream Home</h1>
                        </div>
                        <div class="trip-search">
                            <form class="form" action="{{ url('/properties') }}" method="GET">
                                <div class="form-group looking">
                                    <div class="first-select wide">
                                        <div class="main-search-input-item">
                                            <input type="text" name="q" placeholder="What are you looking for?" value="" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group looking">
                                    <div class="first-select wide">
                                        <div class="main-search-input-item">
                                            <input type="text" name="location" placeholder="Where?" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group button">
                                    <button type="submit" class="btn">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>