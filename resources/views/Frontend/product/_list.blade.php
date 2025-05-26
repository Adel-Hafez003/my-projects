<div class="products mb-3">
                                <div class="row justify-content-center">
                                    @foreach($getproduct as $value)
								     	@php                                         
								        	$getproductImage = $value->getImageSingle($value->id); 
										@endphp	                                <!--productModelسيتم تمرير القيمة من نفس التابع في صفحة -->

									
                                    <div class="col-6 col-md-4 col-lg-4">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
												 <a href="{{url($value->slug)}}">
													@if(!empty($getproductImage)&&!empty($getproductImage->getLogo()))
                                                      <img style="height:280px;width:100%;object-fit:cover;" src="{{$getproductImage->getLogo()}}" alt="{{$value->title}}" class="product-image">
													@endif
													
                                         

                                                
                                            </figure><!-- End .product-media -->

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a href="{{url($value->category_slug.'/'. $value->sub_category_slug)}}">{{$value->sub_category_name}}</a><<!--من اجل عرض الفئة الفرعية التي ينضم اليها المنتج-->
                                                </div><!-- End .product-cat -->
                                                <h3 class="product-title"><a href="{{url($value->slug)}}">{{$value->title}}</a></h3><!-- للمنتج تحت الصورة titleمن أجل ظهور ال -->
                                                <div class="product-price">
                                                    ${{number_format($value->price,2)}}<!--يقوم بعرض السعر بشكل رقمين عشريين-->
                                                </div><!-- End .product-price -->
                                                
                                            </div><!-- End .product-body -->
                                        </div><!-- End .product -->
                                    </div><!-- End .col-sm-6 col-lg-4 -->
                                    @endforeach
									
                                </div><!-- End .row -->
                            </div><!-- End .products -->