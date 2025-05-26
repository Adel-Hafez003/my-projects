@extends('Frontend.layouts.app')
@section('style')
         <link rel="stylesheet" href="{{url('assets/css/plugins/nouislider/nouislider.css')}}">
@endsection

@section('content')

<main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url($getproduct->getCategory->slug)}}">{{$getproduct->getCategory->name}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url($getproduct->getCategory->slug.'/'.$getproduct->getsubCategory->slug)}}">{{$getproduct->getsubCategory->name}}</a></li>

                        <li class="breadcrumb-item active" aria-current="page">{{$getproduct->title}}</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <div class="product-details-top mb-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery">
                                    <figure class="product-main-image">
                                     @php                                         
								    	$getproductImage =$getproduct->getImageSingle($getproduct->id); 
									 @endphp

                                     @if(!empty($getproductImage)&&!empty($getproductImage->getLogo()))
	   
                                        <img id="product-zoom" src="{{$getproductImage->getLogo()}}" data-zoom-image="{{$getproductImage->getLogo()}}" alt="product image">

                                        <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                            <i class="icon-arrows"></i>
                                        </a>
                                     @endif
                                    </figure><!-- End .product-main-image -->

                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        @foreach($getproduct->getImage as $image)
                                        <a class="product-gallery-item" href="#" data-image="{{$image->getLogo()}}" data-zoom-image="{{$image->getLogo()}}">
                                            <img src="{{$image->getLogo()}}" alt="product side">
                                        </a>
                                        @endforeach

                                    </div><!-- End .product-image-gallery -->
                                </div><!-- End .product-gallery -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="product-details">
                                    <h1 class="product-title">{{$getproduct->title}}</h1><!-- End .product-title -->

                                    

                                    <div class="product-price">
                                    $<span id="getTotalPrice">{{number_format($getproduct->price,2)}}</span>
                                    </div><!-- End .product-price -->

                                    <div class="product-content">
                                    {{$getproduct->short_description}}
                                    </div><!-- End .product-content -->

                               <form action="{{url('product/add-to-cart')}}" method="post"><!-- يحتوي النموذج على حقول إدخال مثال اللون والقياس والكمية-->
                                     {{ csrf_field() }}
                                     <input type="hidden" name="product_id" value="{{$getproduct->id}}">
                                     @if(!empty($getproduct->getColor->count()))
                                        <div class="details-filter-row details-row-size">
                                            <label for="size">Color:</label>
                                            <div class="select-custom">
                                                <select name="color_id" id="color_id" required class="form-control">
                                                    <option value="" >Select a color</option>
                                                    @foreach($getproduct->getColor as $color) 
                                                         <option value="{{$color->getColor->id}}">{{$color->getColor->name}}</option>
                                                    @endforeach
                                               </select>
                                            </div><!-- End .select-custom -->
                                        </div>
                                     @endif

                                       @if(!empty($getproduct->getSize->count()))
                                           <div class="details-filter-row details-row-size">
                                             <label for="size">Size:</label>
                                             <div class="select-custom">
                                                 <select name="size_id" id="size_id" required class="form-control getSizePrice">
                                                     <option data-price="0" value="" >Select a size</option>
                                                        @foreach($getproduct->getSize as $size) 
                                                          <option data-price="{{!empty($size->price) ? $size->price : 0}}"value="{{$size->id}}">{{$size->name}} @if(!empty($size->price)) 
                                                             (${{number_format($size->price,2)}}) @endif
                                                          </option>
                                                        @endforeach
                                              
                                                    </select>
                                                </div>
                                            </div><!-- End .details-filter-row -->
                                        @endif

                                     <div class="details-filter-row details-row-size">
                                           <label for="qty">Qty:</label>
                                           <div class="product-details-quantity">
                                            <input type="number" id="qty" class="form-control"
                                             value="1" min="1" max="100" name ="qty" required step="1" 
                                             data-decimals="0" required>
                                           </div><!-- End .product-details-quantity -->
                                     </div><!-- End .details-filter-row -->

                                    <div class="product-details-action">
                                        <button style="background: #fff;
                                            color: rgb(204, 153, 102);"type="submit" class="btn-product btn-cart">add to cart
                                        </button>

                                        
                                    </div><!-- End .product-details-action -->
                              </form>

                                    <div class="product-details-footer">
                                        <div class="product-cat">
                                            <span>Category:</span>
                                            <a href="{{url($getproduct->getCategory->slug)}}">{{$getproduct->getCategory->name}}</a>,
                                            <a href="{{url($getproduct->getCategory->slug.'/'.$getproduct->getsubCategory->slug)}}">{{$getproduct->getsubCategory->name}}</a>
                                           
                                        </div><!-- End .product-cat -->

                                       <!--<div class="social-icons social-icons-sm">
                                            <span class="social-label">Share:</span>
                                            <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                            <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                            <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                            <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                        </div>-->
                                    </div><!-- End .product-details-footer -->
                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-details-top -->
                </div><!-- End .container -->

                <div class="product-details-tab product-details-extended">
                    <div class="container">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                            </li>
                            
                        </ul>
                    </div><!-- End .container -->

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                          <div class="product-desc-content">
                                <div class="container" style="margin: top 20px;">
                                    {!! $getproduct->description !!}
                                </div>
                            </div>
                        </div><!-- .End .tab-pane -->
                        <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                            <div class="product-desc-content">
                                <div class="container" style="margin: top 20px;">
                                {!! $getproduct->additional_information !!}

                                </div><!-- End .container -->
                            </div><!-- End .product-desc-content -->
                        </div><!-- .End .tab-pane -->
                        <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                            <div class="product-desc-content">
                                <div class="container" style="margin: top 20px;">
                                {!! $getproduct->shipping_returns !!}

                                </div><!-- End .container -->
                            </div><!-- End .product-desc-content -->
                        </div><!-- .End .tab-pane -->
                        <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                            <div class="reviews">
                               
                            </div><!-- End .reviews -->
                        </div><!-- .End .tab-pane -->
                    </div><!-- End .tab-content -->
                </div><!-- End .product-details-tab -->

                <div class="container">
                    <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
                        @foreach($getRelatedProduct as $value)
                             @php                        
							 	$getproductImage = $value->getImageSingle($value->id); 
						@endphp
                        <div class="product product-7">
                            <figure class="product-media">
                                <a href="{{url($value->slug)}}">
                                  @if(!empty($getproductImage)&&!empty($getproductImage->getLogo()))
                                      <img style="height:280px;width:100%;object-fit:cover;" src="{{$getproductImage->getLogo()}}" alt="{{$value->title}}" class="product-image">
								 @endif
                                </a>

                                
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="{{url($value->category_slug.'/'. $value->sub_category_slug)}}">{{$value->sub_category_name}}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="{{url($value->slug)}}">{{$value->title}}</a></h3><!-- للمنتج تحت الصورة titleمن أجل ظهور ال -->
                                <div class="product-price">
                                   ${{number_format($value->price,2)}}
                                </div><!-- End .product-price -->
                                
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                        @endforeach

                    </div><!-- End .owl-carousel -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

        
@endsection
@section('script')
    <script src="{{url('assets/js/bootstrap-input-spinner.js')}}"></script>
    <script src="{{url('assets/js/jquery.elevateZoom.min.js')}}"></script>
    <script src="{{url('assets/js/bootstrap-input-spinner.js')}}"></script>

    <script type="text/javascript">
    $('.getSizePrice').change(function (){
        var product_price='{{$getproduct->price}}';
        var price= $('option:selected', this).attr('data-price');// في الأعلى وهذا التابع يقوم بتحديد سعر المنتج عند اختيار القياس المناسب وإلا يقوم بإرجاع 0 getSizePrice لقد قمنا بتعريف كلاس 
        var total=parseFloat(product_price)+parseFloat(price);
        $('#getTotalPrice').html(total.toFixed(2));//بعد تقليصها إلى رقمين بعد الفاصلة total بقيمة HTML هذا السطر يقوم بتحديث محتوى 
    })
</script>
@endsection

  
        
    