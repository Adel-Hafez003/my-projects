@extends('Frontend.layouts.app')

@section('content')


        <main class="main">
            <div class="intro-section bg-lighter pt-5 pb-6">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="intro-slider-container slider-container-ratio slider-container-1 mb-2 mb-lg-0">
                                <div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{
                                    "nav": false,
                                    "responsive": {
                                        "768": {
                                            "nav": true
                                        }
                                    }
                                }'>
                                    @foreach($getSlider as $slider)
                                        @if(!empty($slider->getImage()))
                                            <div class="intro-slide">
                                                <figure class="slide-image">
                                                    <picture>
                                                        <source media="(max-width: 480px)" srcset="{{ $slider->getImage() }}">
                                                        <img src="{{ $slider->getImage() }}" alt="Image Description">
                                                    </picture>
                                                </figure>
                                                <div class="intro-content">
                                                    <h1 class="intro-title">
                                                        {!! $slider->title !!}
                                                    </h1><!-- End .intro-title -->
                                                    @if(!empty($slider->button_link) && !empty($slider->button_name))
                                                        <a href="{{ $slider->button_link }}" class="btn btn-outline-white">
                                                            <span>{{ $slider->button_name }}</span>
                                                            <i class="icon-long-arrow-right"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div><!-- End intro-slider owl-carousel owl-simple -->
                                <span class="slider-loader"></span><!-- End .slider-loader -->
                            </div><!-- End .intro-slider-container -->
                        </div><!-- End .col-lg-12 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .intro-section -->

            <div class="mb-6"></div><!-- End .mb-6 -->

            


            <div class="mb-5"></div><!-- End .mb-6 -->

            
            

            
           
            
        </main><!-- End .main -->
        
@endsection
        
    