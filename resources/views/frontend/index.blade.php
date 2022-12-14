
@extends('frontend.main_master')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<style>
.progress-label-left
{
    float: left;
    margin-right: 0.5em;
    line-height: 1em;
}
.progress-label-right
{
    float: right;
    margin-left: 0.3em;
    line-height: 1em;
}
.star-light
{
	color:#e9ecef;
}
.star-warning
{
	color:#ffff00;
}
</style>
<div class="body-content outer-top-xs" id="top-banner-and-menu">
  <div class="container">
    <div class="row"> 
      <!-- ============================================== SIDEBAR ============================================== -->
      <div class="col-xs-12 col-sm-12 col-md-3 sidebar"> 
        
        <!-- ================================== TOP NAVIGATION ================================== -->
        @include('frontend.commun.vertical_menu')
        <!-- /.side-menu --> 
        <!-- ================================== TOP NAVIGATION : END ================================== --> 
        
        <!-- ============================================== HOT DEALS ============================================== -->
        @include('frontend.commun.hot_deals')
        <!-- ============================================== HOT DEALS: END ============================================== --> 
        
        <!-- ============================================== SPECIAL OFFER ============================================== -->
        
        <div class="sidebar-widget outer-bottom-small wow fadeInUp">
          <h3 class="section-title">Special Offer</h3>
          <div class="sidebar-widget-body outer-top-xs">
          <!--<div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">-->
            <div class="owl-carousel sidebar-carousel special-offer custom-carousel owl-theme outer-top-xs" >
            @php
                  if (session()->get('language') == 'english'){
                    $products = App\Models\Product::where('status', 1)->where('sprecial_offer', 1)->orderBy('id' , 'ASC')->get();
                  }
                  else{
                    $products = App\Models\Product::where('status', 1)->where('sprecial_offer', 1)->orderBy('id' , 'ASC')->get();
                  }   
                  
                  
                 $tabspairim = count($products) % 3;
                 $tabs = count($products) / 3;
                  
                @endphp
                   
               @for($i = 0 ; $i < $tabs ; $i++ )
              <div class="item">
                <div class="products special-product">
               
                    @php 
                    $counter = 1;
                    @endphp
                @foreach($products as $product)
                @if ($counter <= 3)
                @php  
                $amount = $product->selling_price - $product->discount_price;
                $discount = ($amount/$product->selling_price) * 100;
                $counter  = $counter + 1;
                @endphp
                  <div class="product specialoffer" name="{{$product->id}}">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="{{url('product/details/'. $product->id . '/' . $product->product_slug_en)}}"> <img src="{{asset($product->product_thumbnail)}}" alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="{{url('product/details/'. $product->id . '/' . $product->product_slug_en)}}">@if (session()->get('language') == 'english'){{ $product->product_name_en }} @else {{ $product->product_name_fr }} @endif</a></h3>
                            <div class="rating-reviews ">
								
                <div class="mb-3">
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star"></i>
                </div>
                
              
                
              </div>
            
                <p hidden id="productid">{{$product->id}}</p>

                            @if ($product->discount_price == 0)
                            <div class="product-price"> <span class="price">${{$product->selling_price}}</span> </div>
                           @else
                          <div class="product-price"> <span class="price">${{$product->discount_price}}</span> <span class="price-before-discount">${{$product->selling_price}}</span> </div>
										
                            @endif
                            
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                  @else
                  @php
                  $again = $product->id;
                  $products = App\Models\Product::where('status', 1)->where('sprecial_offer', 1)->where('id', '>=', $again)->orderBy('id' , 'ASC')->get();
                  
                  @endphp
                  

                  @break
                  @endif

                  @endforeach
              
                </div>
              </div>
              @endfor
            
             
            </div>
          </div>
          <!-- /.sidebar-widget-body --> 
        </div>
        <!-- /.sidebar-widget --> 
        <!-- ============================================== SPECIAL OFFER : END ============================================== --> 
        <!-- ============================================== PRODUCT TAGS ============================================== -->
        <div class="sidebar-widget product-tag wow fadeInUp">
          <h3 class="section-title">Product tags</h3>
          <div class="sidebar-widget-body outer-top-xs">
            <div class="tag-list"> 
            @php
                  if (session()->get('language') == 'english'){
                    $products = App\Models\Product::orderBy('product_name_en' , 'ASC')->get();
                  }
                  else{
                    $products = App\Models\Product::orderBy('product_name_fr' , 'ASC')->get();
                  }   

                   $l = 0;
                @endphp


                <!-- eliminate repitation -->  
          @if (session()->get('language') == 'english')
                @php  
                $size = 0;
                $tagsenglish =array();
                @endphp
            
                
            @foreach($products as $product)

                
              
              @php
              
                 $tags = $product->product_tags_en;
                 

                    
                 $pattern = '/,|\[[^]]+\](*SKIP)(*FAIL)/';
                
                $wordsenglish = preg_split($pattern, $tags); 
                $size = count($wordsenglish);
                $sizetab = count($tagsenglish);
                $check = 0;
                

                  for($i = 0; $i< $size ; $i++){
                    for($j = 0; $j< $sizetab ; $j++) {
                      if (strcmp($wordsenglish[$i] , $tagsenglish[$j]) == 0){
                        $check = $check +1;
                      }
                    }

                    if ($check == 0)
                    {
                      
                      array_push($tagsenglish,$wordsenglish[$i]);
                    }
                    
                  }

                
              @endphp
              
            @endforeach

              

               

          @else
              @php  
                $size = 0;
                $tagsfrensh=array();
               
                
              @endphp

            @foreach($products as $product)

                
              
              @php
              $tags = $product->product_tags_fr;

      
              $pattern = '/,|\[[^]]+\](*SKIP)(*FAIL)/';
  
              $wordsfrensh = preg_split($pattern, $tags);
              
              $size = count($wordsfrensh);
              
              $sizetabf = count($tagsfrensh);
              
              
              $check = 0;
             
                

              for($i = 0; $i< $size ; $i++){
                  for($j = 0; $j< $sizetabf ; $j++){
                    
                      if (strcmp($wordsfrensh[$i] , $tagsfrensh[$j]) == 0){
                        $check = $check +1;
                      }
                  }
                    if ($check == 0)
                    {
                      
                      array_push($tagsfrensh,$wordsfrensh[$i]);
                    }
              }
              @endphp



            @endforeach
             

                

          @endif


              
                
             
               
                
            
                <!-- end elimination -->

                @if (session()->get('language') == 'english')

               
              @foreach ( $tagsenglish as $tage)
          
                    <a class="item" title="{{$tage}}" href="{{url('/products/tag/'. $tage)}}">{{$tage}}</a>
             
                  @endforeach


                  @else
                  
              
              @foreach ($tagsfrensh as $tagf)
             
                    <a class="item" title="{{$tagf}}" href="{{url('/products/tag/'. $tagf)}}">{{$tagf}}</a>
                  
                  @endforeach
                  @endif
                  
                </div>
            <!-- /.tag-list --> 
          </div>
          <!-- /.sidebar-widget-body --> 
        </div>
        <!-- /.sidebar-widget --> 
        <!-- ============================================== PRODUCT TAGS : END ============================================== --> 
        <!-- ============================================== SPECIAL DEALS ============================================== -->
        
        <div class="sidebar-widget outer-bottom-small wow fadeInUp">
          <h3 class="section-title">Special Deals</h3>
          <div class="sidebar-widget-body outer-top-xs">
            <div class="owl-carousel sidebar-carousel special-offer custom-carousel owl-theme outer-top-xs">
            @php
                  if (session()->get('language') == 'english'){
                    $products = App\Models\Product::where('status', 1)->where('speacial_deal', 1)->orderBy('id' , 'ASC')->get();
                  }
                  else{
                    $products = App\Models\Product::where('status', 1)->where('speacial_deal', 1)->orderBy('id' , 'ASC')->get();
                  }   

                  $tabs = count($products) / 3;
                @endphp

                @for ($i = 0 ; $i<$tabs ; $i++)
              <div class="item">
                <div class="products special-product">
                @php 
                    $counter = 1;
                    @endphp

                @foreach($products as $product)
                @if ($counter <= 3)
                @php  
                $amount = $product->selling_price - $product->discount_price;
                $discount = ($amount/$product->selling_price) * 100;
                $counter  = $counter + 1;
                @endphp
                  <div class="product specialdeals" name="{{$product->id}}">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="{{url('product/details/'. $product->id . '/' . $product->product_slug_en)}}"> <img src="{{asset($product->product_thumbnail)}}"  alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="{{url('product/details/'. $product->id . '/' . $product->product_slug_en)}}">@if (session()->get('language') == 'english'){{ $product->product_name_en }} @else {{ $product->product_name_fr }} @endif</a></h3>
                            <div class="rating-reviews ">
								
                <div class="mb-3">
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star"></i>
                </div>
                
              
                
              </div>
            
                <p hidden id="productid">{{$product->id}}</p>
                            @if ($product->discount_price == 0)
                            <div class="product-price"> <span class="price">${{$product->selling_price}}</span> </div>
                           @else
                          <div class="product-price"> <span class="price">${{$product->discount_price}}</span> <span class="price-before-discount">${{$product->selling_price}}</span> </div>
										
                            @endif
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                  @else
                  @php  
                  $again = $product->id;
                  $products = App\Models\Product::where('status', 1)->where('speacial_deal', 1)->where('id','>=', $again)->orderBy('id' , 'ASC')->get();
                    @endphp

                    @break
                    @endif

                  @endforeach
                  
                </div>
              </div>
              @endfor
             
            </div>
          </div>
          <!-- /.sidebar-widget-body --> 
        </div>
        <!-- /.sidebar-widget --> 
        <!-- ============================================== SPECIAL DEALS : END ============================================== --> 
        <!-- ============================================== NEWSLETTER ============================================== -->
        <div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small">
          <h3 class="section-title">Newsletters</h3>
          <div class="sidebar-widget-body outer-top-xs">
            <p>Sign Up for Our Newsletter!</p>
            
              <div class="form-group">
                <label class="sr-only" for="email">Email address</label>
                <input type="email" name="email" id="email" class="form-control"  placeholder="Subscribe to our newsletter">
              </div>
              
     
                <div>
              <button class="btn btn-primary subs" id="subscribe">Subscribe</button><img class="loading"  src="{{ asset('frontend/assets/images/loader.svg') }}" style="width: 50px; height: 50px;display:none">
                </div>
          </div>
          <!-- /.sidebar-widget-body --> 
        </div>
        <!-- /.sidebar-widget --> 
        <!-- ============================================== NEWSLETTER: END ============================================== --> 
        
        <!-- ============================================== Testimonials============================================== -->
        <div class="sidebar-widget  wow fadeInUp outer-top-vs ">
          <div id="advertisement" class="advertisement">
            <div class="item">
              <div class="avatar"><img src="{{asset('frontend/assets/images/testimonials/member1.png')}}" alt="Image"></div>
              <div class="testimonials"><em>"</em> Vtae sodales aliq uam morbi non sem lacus port mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
              <div class="clients_author">John Doe <span>Abc Company</span> </div>
              <!-- /.container-fluid --> 
            </div>
            <!-- /.item -->
            
            <div class="item">
              <div class="avatar"><img src="{{asset('frontend/assets/images/testimonials/member3.png')}}" alt="Image"></div>
              <div class="testimonials"><em>"</em>Vtae sodales aliq uam morbi non sem lacus port mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
              <div class="clients_author">Stephen Doe <span>Xperia Designs</span> </div>
            </div>
            <!-- /.item -->
            
            <div class="item">
              <div class="avatar"><img src="{{asset('frontend/assets/images/testimonials/member2.png')}}" alt="Image"></div>
              <div class="testimonials"><em>"</em> Vtae sodales aliq uam morbi non sem lacus port mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
              <div class="clients_author">Saraha Smith <span>Datsun &amp; Co</span> </div>
              <!-- /.container-fluid --> 
            </div>
            <!-- /.item --> 
            
          </div>
          <!-- /.owl-carousel --> 
        </div>
        
        <!-- ============================================== Testimonials: END ============================================== -->
        
        <div class="home-banner"> <img src="{{asset('frontend/assets/images/banners/LHS-banner.jpg')}}" alt="Image"> </div>
      </div>
      <!-- /.sidemenu-holder --> 
      <!-- ============================================== SIDEBAR : END ============================================== --> 
      
      <!-- ============================================== CONTENT ============================================== -->
      <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder"> 
        <!-- ========================================== SECTION ??? HERO ========================================= -->
        
        <div id="hero">
          <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
          @php
                
                    $sliders = App\Models\Slider::where('status', 1)->get();
                
                     
                @endphp

                @foreach ($sliders as $slider)
            <div class="item" style="background-image: url({{asset($slider->slider_image)}});">
              <div class="container-fluid">
                <div class="caption bg-color vertical-center text-left">
                  
                  <div class="big-text fadeInDown-1"> {{$slider->title}}</div>
                  <div class="excerpt fadeInDown-2 hidden-xs"> <span>{{$slider->description}}</span> </div>
                  <div class="button-holder fadeInDown-3"> <a href="index.php?page=single-product" class="btn-lg btn btn-uppercase btn-primary shop-now-button">Shop Now</a> </div>
                </div>
                <!-- /.caption --> 
              </div>
              <!-- /.container-fluid --> 
            </div>
            @endforeach
            <!-- /.item -->
            
           
            <!-- /.item --> 
            
          </div>
          <!-- /.owl-carousel --> 
        </div>
        
        <!-- ========================================= SECTION ??? HERO : END ========================================= --> 
        
        <!-- ============================================== INFO BOXES ============================================== -->
        <div class="info-boxes wow fadeInUp">
          <div class="info-boxes-inner">
            <div class="row">
              <div class="col-md-6 col-sm-4 col-lg-4">
                <div class="info-box">
                  <div class="row">
                    <div class="col-xs-12">
                      <h4 class="info-box-heading green">money back</h4>
                    </div>
                  </div>
                  <h6 class="text">30 Days Money Back Guarantee</h6>
                </div>
              </div>
              <!-- .col -->
              
              <div class="hidden-md col-sm-4 col-lg-4">
                <div class="info-box">
                  <div class="row">
                    <div class="col-xs-12">
                      <h4 class="info-box-heading green">free shipping</h4>
                    </div>
                  </div>
                  <h6 class="text">Shipping on orders over $99</h6>
                </div>
              </div>
              <!-- .col -->
              
              <div class="col-md-6 col-sm-4 col-lg-4">
                <div class="info-box">
                  <div class="row">
                    <div class="col-xs-12">
                      <h4 class="info-box-heading green">Special Sale</h4>
                    </div>
                  </div>
                  <h6 class="text">Extra $5 off on all items </h6>
                </div>
              </div>
              <!-- .col --> 
            </div>
            <!-- /.row --> 
          </div>
          <!-- /.info-boxes-inner --> 
          
        </div>
        <!-- /.info-boxes --> 
        <!-- ============================================== INFO BOXES : END ============================================== --> 
        <!-- ============================================== SCROLL TABS ============================================== -->
        <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
          <div class="more-info-tab clearfix ">
            <h3 class="new-product-title pull-left">New Products</h3>
            <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
              <li class="active"><a data-transition-type="backSlide" href="#all" data-toggle="tab">All</a></li>
              @php
                if (session()->get('language') == 'english'){
                    $categories = App\Models\Category::orderBy('category_name_en' , 'ASC')->get();
                }
                  else{
                    $categories = App\Models\Category::orderBy('category_name_fr' , 'ASC')->get();
                  }
                     
                @endphp

                @foreach ($categories as $category)
              <li><a data-transition-type="backSlide" href="#category{{ $category->id }}" data-toggle="tab"> @if (session()->get('language') == 'english'){{$category->category_name_en}} @else {{$category->category_name_fr}} @endif</a></li>
              @endforeach
            </ul>
            <!-- /.nav-tabs --> 
          </div>
          <div class="tab-content outer-top-xs">
            <div class="tab-pane in active" id="all">
              <div class="product-slider">
                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                @php
                if (session()->get('language') == 'english'){
                    $products = App\Models\Product::where('status', 1)->orderBy('product_name_en' , 'ASC')->get();
                }
                  else{
                    $products = App\Models\Product::where('status', 1)->orderBy('product_name_fr' , 'ASC')->get();
                  }
                     
                @endphp

                @forelse ($products as $product)
                @php  
                $amount = $product->selling_price - $product->discount_price;
                $discount = ($amount/$product->selling_price) * 100;
                @endphp
                
                  <div class="item item-carousel new" name="{{$product->id}}">
                    <div class="products">
                      <div class="product">
                        <div class="product-image">
                        @if (session()->get('language') == 'english')
                          <div class="image"> <a href="{{url('product/details/'. $product->id . '/' . $product->product_slug_en)}}"><img  src="{{asset($product->product_thumbnail)}}" alt=""></a> </div>
                          @else
                          <div class="image"> <a href="{{url('product/details/'. $product->id . '/' . $product->product_slug_fr)}}"><img  src="{{asset($product->product_thumbnail)}}" alt=""></a> </div>
                          @endif
                          <!-- /.image -->
                          
                          @if ($product->discount_price == 0)
                          <div class="tag new"><span>new</span></div>
                          @else
                          <div class="tag hot"><span>{{round($discount)}}%</span></div>
                          @endif
                        </div>
                        <!-- /.product-image -->

                      

                        
                        <div class="product-info text-left">
                        @if (session()->get('language') == 'english')
                          <h3 class="name"><a href="{{url('product/details/'. $product->id) . '/' . $product->product_slug_en}}">@if (session()->get('language') == 'english'){{$product->product_name_en}} @else {{$product->product_name_fr}} @endif</a></h3>
                          @else
                          <h3 class="name"><a href="{{url('product/details/'. $product->id) . '/' . $product->product_slug_fr}}">@if (session()->get('language') == 'english'){{$product->product_name_en}} @else {{$product->product_name_fr}} @endif</a></h3>
                          @endif
                          <div class="rating-reviews ">
								
                <div class="mb-3">
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star" ></i>
                  <i class="fa fa-star star-light mr-1 main_star"></i>
                </div>
                
              
                
              </div>
            
                <p hidden id="productid">{{$product->id}}</p>
                          <div class="description"></div>
                          @if ($product->discount_price == 0)
                          <div class="product-price"> <span class="price"> ${{$product->selling_price}}</span>  </div>
                          @else
                          <div class="product-price"> <span class="price"> ${{$product->discount_price}} </span> <span class="price-before-discount">${{$product->selling_price}}</span> </div>
                          @endif
                         
                          <!-- /.product-price --> 
                          
                        </div>
                        <!-- /.product-info -->
                        <div class="cart clearfix animate-effect">
                          <div class="action">
                            <ul class="list-unstyled">
                              <li class="add-cart-button btn-group">
                                <button  class="btn btn-primary icon" data-toggle="modal" data-target="#exampleModal" type="button" title="Add Cart" id="{{ $product->id }}"> <i class="fa fa-shopping-cart"></i> </button>
                                <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                              </li>
                              <button class="btn btn-primary icon" type="button" title="Wishlist" id="{{ $product->id }}" > <i class="fa fa-heart"></i> </button>
                              <li class="lnk"> <a data-toggle="tooltip" class="add-to-cart" href="detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                          </div>
                          <!-- /.action --> 
                        </div>
                        <!-- /.cart --> 
                      </div>
                      <!-- /.product --> 
                      
                    </div>
                    <!-- /.products --> 
                  </div>
                  @empty
                  <h5 class="text-danger">No Product Found</h5>
                  @endforelse
                  <!-- /.item -->
                  
                  
                  <!-- /.item --> 
                </div>
                <!-- /.home-owl-carousel --> 
              </div>
              <!-- /.product-slider --> 
            </div>
            <!-- /.tab-pane -->

            @php
                if (session()->get('language') == 'english'){
                    $categories = App\Models\Category::orderBy('category_name_en' , 'ASC')->get();
                }
                  else{
                    $categories = App\Models\Category::orderBy('category_name_fr' , 'ASC')->get();
                  }
                     
                @endphp

                @foreach ($categories as $category)
            
            <div class="tab-pane" id="category{{ $category->id }}">
              <div class="product-slider">
                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme">

                @php
                if (session()->get('language') == 'english'){
                    $products = App\Models\Product::where('category_id',$category->id)->where('status', 1)->orderBy('id' , 'DESC')->get();
                }
                  else{
                    $products = App\Models\Product::where('category_id',$category->id)->where('status', 1)->orderBy('product_name_fr' , 'ASC')->get();
                  }
                     
                @endphp

                @forelse ($products as $product)

                @php  
                $amount = $product->selling_price - $product->discount_price;
                $discount = ($amount/$product->selling_price) * 100;
                @endphp

                  <div class="item item-carousel">
                    <div class="products">
                      <div class="product">
                        <div class="product-image">
                          <div class="image"> <a href="detail.html"><img  src="{{asset($product->product_thumbnail)}}" alt=""></a> </div>
                          <!-- /.image -->

                          @if ($product->discount_price == 0)
                          <div class="tag new"><span>new</span></div>
                          @else
                          <div class="tag hot"><span>{{round($discount)}}%</span></div>
                          @endif

                        </div>
                        <!-- /.product-image -->
                        
                        <div class="product-info text-left">
                          <h3 class="name"><a href="detail.html">@if (session()->get('language') == 'english'){{$product->product_name_en}} @else {{$product->product_name_fr}} @endif</a></h3>
                          <div class="rating rateit-small"></div>
                          <div class="description"></div>
                          @if  ($product->discount_price != 0)
                          <div class="product-price"> <span class="price"> ${{$product->discount_price}} </span> <span class="price-before-discount">${{$product->selling_price}}</span> </div>
                          @else
                          <div class="product-price"> <span class="price"> ${{$product->selling_price}} </span></div>
                          @endif
                          
                          <!-- /.product-price --> 
                          
                        </div>
                        <!-- /.product-info -->
                        <div class="cart clearfix animate-effect">
                          <div class="action">
                            <ul class="list-unstyled">
                              <li class="add-cart-button btn-group">
                                <button class="btn btn-primary icon" data-toggle="modal" data-target="#exampleModal" type="button" id="{{ $product->id }}" title="Add Cart"> <i class="fa fa-shopping-cart"></i> </button>
                                <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                              </li>
                              <li class="lnk wishlist"> <a data-toggle="tooltip" class="add-to-cart" href="detail.html" title="Wishlist" id="{{ $product->id }}"> <i class="icon fa fa-heart"></i> </a> </li>
                              <li class="lnk"> <a data-toggle="tooltip" class="add-to-cart" href="detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                            </ul>
                          </div>
                          <!-- /.action --> 
                        </div>
                        <!-- /.cart --> 
                      </div>
                      <!-- /.product --> 
                      
                    </div>
                    <!-- /.products --> 
                  </div>
                  @empty
                  <h5 class="text-danger">No Product Found</h5>
                  @endforelse
                  <!-- /.item -->
                  
                
                  <!-- /.item -->
                  
                  
                  <!-- /.item --> 
                </div>
                <!-- /.home-owl-carousel --> 
              </div>
              <!-- /.product-slider --> 
            </div>
            <!-- /.tab-pane -->
            
@endforeach
            <!-- /.tab-pane --> 
            
          </div>
          <!-- /.tab-content --> 
        </div>
        <!-- /.scroll-tabs --> 
        <!-- ============================================== SCROLL TABS : END ============================================== --> 
        <!-- ============================================== WIDE PRODUCTS ============================================== -->
        <div class="wide-banners wow fadeInUp outer-bottom-xs">
          <div class="row">
            <div class="col-md-7 col-sm-7">
              <div class="wide-banner cnt-strip">
                <div class="image"> <img class="img-responsive" src="{{asset('frontend/assets/images/banners/home-banner1.jpg')}}" alt=""> </div>
              </div>
              <!-- /.wide-banner --> 
            </div>
            <!-- /.col -->
            <div class="col-md-5 col-sm-5">
              <div class="wide-banner cnt-strip">
                <div class="image"> <img class="img-responsive" src="{{asset('frontend/assets/images/banners/home-banner2.jpg')}}" alt=""> </div>
              </div>
              <!-- /.wide-banner --> 
            </div>
            <!-- /.col --> 
          </div>
          <!-- /.row --> 
        </div>
        <!-- /.wide-banners --> 
        
        <!-- ============================================== WIDE PRODUCTS : END ============================================== --> 
        <!-- ============================================== FEATURED PRODUCTS ============================================== -->
        <section class="section featured-product wow fadeInUp">
          <h3 class="section-title">Featured products</h3>
          <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
          @php
                if (session()->get('language') == 'english'){
                    $products = App\Models\Product::where('status', 1)->where('featured', 1)->orderBy('product_name_en','ASC')->get();
                }
                  else{
                    $products = App\Models\Product::where('status', 1)->where('featured', 1)->orderBy('product_name_fr','ASC')->get();
                  }
                     
                @endphp

              
                @foreach ($products as $product)
                @php  
                $amount = $product->selling_price - $product->discount_price;
                $discount = ($amount/$product->selling_price) * 100;
                @endphp
            <div class="item item-carousel featured" name="{{$product->id}}">
              <div class="products">
                <div class="product">
                  <div class="product-image">
                  @if (session()->get('language') == 'english')
                          <div class="image"> <a href="{{url('product/details/'. $product->id . '/' . $product->product_slug_en)}}"><img  src="{{asset($product->product_thumbnail)}}" alt=""></a> </div>
                          @else
                          <div class="image"> <a href="{{url('product/details/'. $product->id . '/' . $product->product_slug_fr)}}"><img  src="{{asset($product->product_thumbnail)}}" alt=""></a> </div>
                          @endif
                    
                    <!-- /.image -->
                    
                    @if ($product->discount_price == 0)
                          <div class="tag new"><span>new</span></div>
                          @else
                          <div class="tag hot"><span>{{round($discount)}}%</span></div>
                          @endif

                  </div>
                  <!-- /.product-image -->
                  
                  <div class="product-info text-left">
                    
                    <h3 class="name"><a href="detail.html">@if (session()->get('language') == 'english'){{$product->product_name_en}} @else {{$product->product_name_fr}} @endif</a></h3>
                    <div class="rating-reviews ">
								
									<div class="mb-3">
										<i class="fa fa-star star-light mr-1 main_star" ></i>
										<i class="fa fa-star star-light mr-1 main_star" ></i>
										<i class="fa fa-star star-light mr-1 main_star" ></i>
										<i class="fa fa-star star-light mr-1 main_star" ></i>
										<i class="fa fa-star star-light mr-1 main_star"></i>
									</div>
									
								
									
								</div>
							
                  <p hidden id="productid">{{$product->id}}</p>
                    <div class="description"></div>
                    @if  ($product->discount_price != 0)
                          <div class="product-price"> <span class="price"> ${{$product->discount_price}} </span> <span class="price-before-discount">${{$product->selling_price}}</span> </div>
                          @else
                          <div class="product-price"> <span class="price"> ${{$product->selling_price}} </span></div>
                          @endif
                    
                    <!-- /.product-price --> 
                    
                  </div>
                  <!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
                    <div class="action">
                      <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                        
                          <button class="btn btn-primary icon"  type="button" title="Add to cart"  data-toggle="modal" data-target="#exampleModal" id="{{ $product->id }}"  onclick="productView(this.id)"> <i class="fa fa-shopping-cart"></i> </button>
                          <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                        </li>
                        
                        <button class="btn btn-primary icon" type="button" title="Wishlist" id="{{ $product->id }}" > <i class="fa fa-heart"></i> </button>
                        <li class="lnk"> <a data-toggle="tooltip"  class="add-to-cart" href="detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                      </ul>
                    </div>
                    <!-- /.action --> 
                  </div>
                  <!-- /.cart --> 
                </div>
                <!-- /.product --> 
                
              </div>
              <!-- /.products --> 
            </div>
            @endforeach
            <!-- /.item -->
            
         
            <!-- /.item --> 
          </div>
          <!-- /.home-owl-carousel --> 
        </section>
        <!-- /.section --> 
        <!-- ============================================== FEATURED PRODUCTS : END ============================================== --> 
        <!-- ============================================== WIDE PRODUCTS ============================================== -->
        <div class="wide-banners wow fadeInUp outer-bottom-xs">
          <div class="row">
            <div class="col-md-12">
              <div class="wide-banner cnt-strip">
                <div class="image"> <img class="img-responsive" src="{{asset('frontend/assets/images/banners/home-banner.jpg')}}" alt=""> </div>
                <div class="strip strip-text">
                  <div class="strip-inner">
                    <h2 class="text-right">New Mens Fashion<br>
                      <span class="shopping-needs">Save up to 40% off</span></h2>
                  </div>
                </div>
                <div class="new-label">
                  <div class="text">NEW</div>
                </div>
                <!-- /.new-label --> 
              </div>
              <!-- /.wide-banner --> 
            </div>
            <!-- /.col --> 
            
          </div>
          <!-- /.row --> 
        </div>
        <!-- /.wide-banners --> 
        <!-- ============================================== WIDE PRODUCTS : END ============================================== --> 
        <!-- ============================================== BEST SELLER ============================================== -->
        
        <div class="best-deal wow fadeInUp outer-bottom-xs">
          <h3 class="section-title">Best seller</h3>
          <div class="sidebar-widget-body outer-top-xs">
            <div class="owl-carousel best-seller custom-carousel owl-theme outer-top-xs">
              <div class="item">
                <div class="products best-product">
                  <div class="product">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="#"> <img src="{{asset('frontend/assets/images/products/p20.jpg')}}" alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col2 col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="#">Floral Print Buttoned</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="product-price"> <span class="price"> $450.99 </span> </div>
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                  <div class="product">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="#"> <img src="{{asset('frontend/assets/images/products/p21.jpg')}}" alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col2 col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="#">Floral Print Buttoned</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="product-price"> <span class="price"> $450.99 </span> </div>
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="products best-product">
                  <div class="product">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="#"> <img src="{{asset('frontend/assets/images/products/p22.jpg')}}" alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col2 col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="#">Floral Print Buttoned</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="product-price"> <span class="price"> $450.99 </span> </div>
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                  <div class="product">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="#"> <img src="{{asset('frontend/assets/images/products/p23.jpg')}}" alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col2 col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="#">Floral Print Buttoned</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="product-price"> <span class="price"> $450.99 </span> </div>
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="products best-product">
                  <div class="product">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="#"> <img src="{{asset('frontend/assets/images/products/p24.jpg')}}" alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col2 col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="#">Floral Print Buttoned</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="product-price"> <span class="price"> $450.99 </span> </div>
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                  <div class="product">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="#"> <img src="{{asset('frontend/assets/images/products/p25.jpg')}}" alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col2 col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="#">Floral Print Buttoned</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="product-price"> <span class="price"> $450.99 </span> </div>
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="products best-product">
                  <div class="product">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="#"> <img src="{{asset('frontend/assets/images/products/p26.jpg')}}" alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col2 col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="#">Floral Print Buttoned</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="product-price"> <span class="price"> $450.99 </span> </div>
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                  <div class="product">
                    <div class="product-micro">
                      <div class="row product-micro-row">
                        <div class="col col-xs-5">
                          <div class="product-image">
                            <div class="image"> <a href="#"> <img src="{{asset('frontend/assets/images/products/p27.jpg')}}" alt=""> </a> </div>
                            <!-- /.image --> 
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        <!-- /.col -->
                        <div class="col2 col-xs-7">
                          <div class="product-info">
                            <h3 class="name"><a href="#">Floral Print Buttoned</a></h3>
                            <div class="rating rateit-small"></div>
                            <div class="product-price"> <span class="price"> $450.99 </span> </div>
                            <!-- /.product-price --> 
                            
                          </div>
                        </div>
                        <!-- /.col --> 
                      </div>
                      <!-- /.product-micro-row --> 
                    </div>
                    <!-- /.product-micro --> 
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.sidebar-widget-body --> 
        </div>
        <!-- /.sidebar-widget --> 
        <!-- ============================================== BEST SELLER : END ============================================== --> 
        
        <!-- ============================================== BLOG SLIDER ============================================== -->
        <section class="section latest-blog outer-bottom-vs wow fadeInUp">
          <h3 class="section-title">latest form blog</h3>
          <div class="blog-slider-container outer-top-xs">
            <div class="owl-carousel blog-slider custom-carousel">
              @php  
                $posts = App\Models\BlogPost::where('status' , 1)->orderBy('id','ASC')->get();
              @endphp  
                  @foreach ($posts as $post)
              <div class="item">
                <div class="blog-post">
                  <div class="blog-post-image">
                    <div class="image"> <a href="{{route('blog.posts')}}"><img src="{{asset($post->post_image)}}" alt=""></a> </div>
                  </div>
                  <!-- /.blog-post-image -->
                  
                  <div class="blog-post-info text-left">
                    <h3 class="name"><a href="{{route('post.details', $post->id)}}">{{$post->post_title}}</a></h3>
                    <span class="info">{{$post->post_author}}&nbsp;|&nbsp; {{ Carbon\Carbon::parse($post->created_at)->format('d F Y H:i:s')  }} </span>
                    <p class="text">{!! Str::limit($post->post_details_en, 50 ) !!}</p>
                    <a href="{{route('post.details', $post->id)}}" class="lnk btn btn-primary">Read more</a> </div>
                  <!-- /.blog-post-info --> 
                  
                </div>
                <!-- /.blog-post --> 
              </div>
              @endforeach
              <!-- /.item -->
              
              
            
              
            </div>
            <!-- /.owl-carousel --> 
          </div>
          <!-- /.blog-slider-container --> 
        </section>
        <!-- /.section --> 
        <!-- ============================================== BLOG SLIDER : END ============================================== --> 
        
        <!-- ============================================== FEATURED PRODUCTS ============================================== -->
        <section class="section wow fadeInUp new-arriavls">
          <h3 class="section-title">New Arrivals</h3>
          <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
            <div class="item item-carousel">
              <div class="products">
                <div class="product">
                  <div class="product-image">
                    <div class="image"> <a href="detail.html"><img  src="{{asset('frontend/assets/images/products/p19.jpg')}}" alt=""></a> </div>
                    <!-- /.image -->
                    
                    <div class="tag new"><span>new</span></div>
                  </div>
                  <!-- /.product-image -->
                  
                  <div class="product-info text-left">
                    <h3 class="name"><a href="detail.html">Floral Print Buttoned</a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>
                    <div class="product-price"> <span class="price"> $450.99 </span> <span class="price-before-discount">$ 800</span> </div>
                    <!-- /.product-price --> 
                    
                  </div>
                  <!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
                    <div class="action">
                      <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                          <button class="btn btn-primary icon" data-toggle="modal" data-target="#exampleModal" type="button" title="Add Cart" id="{{ $product->id }}"> <i class="fa fa-shopping-cart"></i> </button>
                          <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                        </li>
                        <li class="lnk wishlist"> <a class="add-to-cart" href="detail.html" title="Wishlist" id="{{ $product->id }}"> <i class="icon fa fa-heart"></i> </a> </li>
                        <li class="lnk"> <a class="add-to-cart" href="detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                      </ul>
                    </div>
                    <!-- /.action --> 
                  </div>
                  <!-- /.cart --> 
                </div>
                <!-- /.product --> 
                
              </div>
              <!-- /.products --> 
            </div>
            <!-- /.item -->
            
            <div class="item item-carousel">
              <div class="products">
                <div class="product">
                  <div class="product-image">
                    <div class="image"> <a href="detail.html"><img  src="{{asset('frontend/assets/images/products/p28.jpg')}}" alt=""></a> </div>
                    <!-- /.image -->
                    
                    <div class="tag new"><span>new</span></div>
                  </div>
                  <!-- /.product-image -->
                  
                  <div class="product-info text-left">
                    <h3 class="name"><a href="detail.html">Floral Print Buttoned</a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>
                    <div class="product-price"> <span class="price"> $450.99 </span> <span class="price-before-discount">$ 800</span> </div>
                    <!-- /.product-price --> 
                    
                  </div>
                  <!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
                    <div class="action">
                      <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                          <button class="btn btn-primary icon" data-toggle="modal" data-target="#exampleModal" type="button" id="{{ $product->id }}" title="Add Cart"> <i class="fa fa-shopping-cart"></i> </button>
                          <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                        </li>
                        <li class="lnk wishlist"> <a class="add-to-cart" href="detail.html" title="Wishlist" id="{{ $product->id }}"> <i class="icon fa fa-heart"></i> </a> </li>
                        <li class="lnk"> <a class="add-to-cart" href="detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                      </ul>
                    </div>
                    <!-- /.action --> 
                  </div>
                  <!-- /.cart --> 
                </div>
                <!-- /.product --> 
                
              </div>
              <!-- /.products --> 
            </div>
            <!-- /.item -->
            
            <div class="item item-carousel">
              <div class="products">
                <div class="product">
                  <div class="product-image">
                    <div class="image"> <a href="detail.html"><img  src="{{asset('frontend/assets/images/products/p30.jpg')}}" alt=""></a> </div>
                    <!-- /.image -->
                    
                    <div class="tag hot"><span>hot</span></div>
                  </div>
                  <!-- /.product-image -->
                  
                  <div class="product-info text-left">
                    <h3 class="name"><a href="detail.html">Floral Print Buttoned</a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>
                    <div class="product-price"> <span class="price"> $450.99 </span> <span class="price-before-discount">$ 800</span> </div>
                    <!-- /.product-price --> 
                    
                  </div>
                  <!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
                    <div class="action">
                      <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                          <button class="btn btn-primary icon" data-toggle="modal" data-target="#exampleModal" type="button" id="{{ $product->id }}" title="Add Cart"> <i class="fa fa-shopping-cart"></i> </button>
                          <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                        </li>
                        <li class="lnk wishlist"> <a class="add-to-cart" href="detail.html" title="Wishlist" id="{{ $product->id }}"> <i class="icon fa fa-heart"></i> </a> </li>
                        <li class="lnk"> <a class="add-to-cart" href="detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                      </ul>
                    </div>
                    <!-- /.action --> 
                  </div>
                  <!-- /.cart --> 
                </div>
                <!-- /.product --> 
                
              </div>
              <!-- /.products --> 
            </div>
            <!-- /.item -->
            
            <div class="item item-carousel">
              <div class="products">
                <div class="product">
                  <div class="product-image">
                    <div class="image"> <a href="detail.html"><img  src="{{asset('frontend/assets/images/products/p1.jpg')}}" alt=""></a> </div>
                    <!-- /.image -->
                    
                    <div class="tag hot"><span>hot</span></div>
                  </div>
                  <!-- /.product-image -->
                  
                  <div class="product-info text-left">
                    <h3 class="name"><a href="detail.html">Floral Print Buttoned</a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>
                    <div class="product-price"> <span class="price"> $450.99 </span> <span class="price-before-discount">$ 800</span> </div>
                    <!-- /.product-price --> 
                    
                  </div>
                  <!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
                    <div class="action">
                      <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                          <button class="btn btn-primary icon" data-toggle="modal" data-target="#exampleModal" type="button" title="Add Cart" id="{{ $product->id }}"> <i class="fa fa-shopping-cart"></i> </button>
                          <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                        </li>
                        <li class="lnk wishlist"> <a class="add-to-cart" href="detail.html" title="Wishlist" id="{{ $product->id }}"> <i class="icon fa fa-heart"></i> </a> </li>
                        <li class="lnk"> <a class="add-to-cart" href="detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                      </ul>
                    </div>
                    <!-- /.action --> 
                  </div>
                  <!-- /.cart --> 
                </div>
                <!-- /.product --> 
                
              </div>
              <!-- /.products --> 
            </div>
            <!-- /.item -->
            
            <div class="item item-carousel">
              <div class="products">
                <div class="product">
                  <div class="product-image">
                    <div class="image"> <a href="detail.html"><img  src="{{asset('frontend/assets/images/products/p2.jpg')}}" alt=""></a> </div>
                    <!-- /.image -->
                    
                    <div class="tag sale"><span>sale</span></div>
                  </div>
                  <!-- /.product-image -->
                  
                  <div class="product-info text-left">
                    <h3 class="name"><a href="detail.html">Floral Print Buttoned</a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>
                    <div class="product-price"> <span class="price"> $450.99 </span> <span class="price-before-discount">$ 800</span> </div>
                    <!-- /.product-price --> 
                    
                  </div>
                  <!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
                    <div class="action">
                      <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                          <button class="btn btn-primary icon" data-toggle="modal" data-target="#exampleModal" type="button" id="{{ $product->id }}" title="Add Cart"> <i class="fa fa-shopping-cart"></i> </button>
                          <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                        </li>
                        <li class="lnk wishlist"> <a class="add-to-cart" href="detail.html" title="Wishlist" id="{{ $product->id }}"> <i class="icon fa fa-heart"></i> </a> </li>
                        <li class="lnk"> <a class="add-to-cart" href="detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                      </ul>
                    </div>
                    <!-- /.action --> 
                  </div>
                  <!-- /.cart --> 
                </div>
                <!-- /.product --> 
                
              </div>
              <!-- /.products --> 
            </div>
            <!-- /.item -->
            
            <div class="item item-carousel">
              <div class="products">
                <div class="product">
                  <div class="product-image">
                    <div class="image"> <a href="detail.html"><img  src="{{asset('frontend/assets/images/products/p3.jpg')}}" alt=""></a> </div>
                    <!-- /.image -->
                    
                    <div class="tag sale"><span>sale</span></div>
                  </div>
                  <!-- /.product-image -->
                  
                  <div class="product-info text-left">
                    <h3 class="name"><a href="detail.html">Floral Print Buttoned</a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>
                    <div class="product-price"> <span class="price"> $450.99 </span> <span class="price-before-discount">$ 800</span> </div>
                    <!-- /.product-price --> 
                    
                  </div>
                  <!-- /.product-info -->
                  <div class="cart clearfix animate-effect">
                    <div class="action">
                      <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                          <button class="btn btn-primary icon" data-toggle="modal" data-target="#exampleModal" type="button" id="{{ $product->id }}" title="Add Cart"> <i class="fa fa-shopping-cart"></i> </button>
                          <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                        </li>
                        <li class="lnk wishlist"> <a class="add-to-cart" href="detail.html" title="Wishlist" id="{{ $product->id }}"> <i class="icon fa fa-heart"></i> </a> </li>
                        <li class="lnk"> <a class="add-to-cart" href="detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                      </ul>
                    </div>
                    <!-- /.action --> 
                  </div>
                  <!-- /.cart --> 
                </div>
                <!-- /.product --> 
                
              </div>
              <!-- /.products --> 
            </div>
            <!-- /.item --> 
          </div>
          <!-- /.home-owl-carousel --> 
        </section>
        <!-- /.section --> 
        <!-- ============================================== FEATURED PRODUCTS : END ============================================== --> 
        
      </div>
      <!-- /.homebanner-holder --> 
      <!-- ============================================== CONTENT : END ============================================== --> 
    </div>
    <!-- /.row --> 
    <!-- ============================================== BRANDS CAROUSEL ============================================== -->
   @include('frontend.body.brands')
    <!-- /.logo-slider --> 
    <!-- ============================================== BRANDS CAROUSEL : END ============================================== --> 
  </div>
  <!-- /.container --> 
</div>

<script>






function load_rating_data_featured()
{
  $('.featured').each(function(){
	var idProduct = $(this).find('#productid').text();
  //console.log($(this).find('.main_star').length)
  //console.log(idProduct)
	
	$.ajax({
		type: 'GET',
		
		url:'/totalreviews/'+idProduct,
		
		//data:{action:'load_data'},
		dataType:"JSON",
		success:function(data)
		{
			//$('#average_rating').text(data.average_rating);
			//$('#total_review').text(data.total_review);

			var count_star = 0;

     // console.log($(`.featured[name="${idProduct}"]`).find('.main_star').length)

			$(`.featured[name="${idProduct}"]`).find('.main_star').each(function(){

        
				count_star++;

				
			
				if(Math.ceil(data.average_rating) >= count_star)
				{
					$(this).removeClass('star-light');
					$(this).addClass('star-warning');
				}
			});

		}
	});
})
}


function load_rating_data_hot()
{
  $('.hot').each(function(){
	var idProduct = $(this).find('#productid').text();
  //console.log($(this).find('.main_star').length)
 // console.log(idProduct)
	
	$.ajax({
		type: 'GET',
		
		url:'/totalreviews/'+idProduct,
		
		//data:{action:'load_data'},
		dataType:"JSON",
		success:function(data)
		{
			//$('#average_rating').text(data.average_rating);
			//$('#total_review').text(data.total_review);

			var count_star = 0;

     // console.log($(`.featured[name="${idProduct}"]`).find('.main_star').length)

			$(`.hot[name="${idProduct}"]`).find('.main_star').each(function(){

        
				count_star++;

				
			
				if(Math.ceil(data.average_rating) >= count_star)
				{
					$(this).removeClass('star-light');
					$(this).addClass('star-warning');
				}
			});

		}
	});
})
}

function load_rating_data_new()
{
  $('.new').each(function(){
	var idProduct = $(this).find('#productid').text();
  //console.log($(this).find('.main_star').length)
  //console.log(idProduct)
	
	$.ajax({
		type: 'GET',
		
		url:'/totalreviews/'+idProduct,
		
		//data:{action:'load_data'},
		dataType:"JSON",
		success:function(data)
		{
			//$('#average_rating').text(data.average_rating);
			//$('#total_review').text(data.total_review);

			var count_star = 0;

     // console.log($(`.featured[name="${idProduct}"]`).find('.main_star').length)

			$(`.new[name="${idProduct}"]`).find('.main_star').each(function(){

        
				count_star++;

				
			
				if(Math.ceil(data.average_rating) >= count_star)
				{
					$(this).removeClass('star-light');
					$(this).addClass('star-warning');
				}
			});

		}
	});
})
}


function load_rating_data_special_offer()
{
  $('.specialoffer').each(function(){
	var idProduct = $(this).find('#productid').text();
  //console.log($(this).find('.main_star').length)
  //console.log(idProduct)
	
	$.ajax({
		type: 'GET',
		
		url:'/totalreviews/'+idProduct,
		
		//data:{action:'load_data'},
		dataType:"JSON",
		success:function(data)
		{
			//$('#average_rating').text(data.average_rating);
			//$('#total_review').text(data.total_review);

			var count_star = 0;

     // console.log($(`.featured[name="${idProduct}"]`).find('.main_star').length)

			$(`.specialoffer[name="${idProduct}"]`).find('.main_star').each(function(){

        
				count_star++;

				
			
				if(Math.ceil(data.average_rating) >= count_star)
				{
					$(this).removeClass('star-light');
					$(this).addClass('star-warning');
				}
			});

		}
	});
})
}

function load_rating_data_special_deals()
{
  $('.specialdeals').each(function(){
	var idProduct = $(this).find('#productid').text();
  //console.log($(this).find('.main_star').length)
  //console.log(idProduct)
	
	$.ajax({
		type: 'GET',
		
		url:'/totalreviews/'+idProduct,
		
		//data:{action:'load_data'},
		dataType:"JSON",
		success:function(data)
		{
			//$('#average_rating').text(data.average_rating);
			//$('#total_review').text(data.total_review);

			var count_star = 0;

     // console.log($(`.featured[name="${idProduct}"]`).find('.main_star').length)

			$(`.specialdeals[name="${idProduct}"]`).find('.main_star').each(function(){

        
				count_star++;

				
			
				if(Math.ceil(data.average_rating) >= count_star)
				{
					$(this).removeClass('star-light');
					$(this).addClass('star-warning');
				}
			});

		}
	});
})
}
$(document).ready(function(){
  //console.log($('.featured').length)
load_rating_data_featured()
load_rating_data_new()
load_rating_data_hot()
load_rating_data_special_offer()
load_rating_data_special_deals()
})


$('#subscribe').click(function(){

  var email = $('#email').val()
  $.ajax({
		
                
    type: "POST",
    data:{email:email},
    dataType: 'json',
    url:'/subscribe/'+email,
    beforeSend: function(response){
          $('.loading').show();
          $('#subscribe').attr('disabled', true);
         
        }
      })

      .done(function(data)
    {
      $('.loading').hide();
      $('#subscribe').attr('disabled', false);
       const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  icon: 'success',
                  //title: 'Product Added To Cart',
                  showConfirmButton: false,
                  timer: 3000
                })
      if ($.isEmptyObject(data.info)) {
          //if there is no error
          $('#email').val('');

            Toast.fire({
                icon: 'success',
                title: data.success
            })
          }else{



          //if there is an error
            Toast.fire({
                icon: 'info',
                title: data.info
            })
        }
    // End Message 

       
    })

    .fail(function(){
      $('.loading').hide();
      $('#subscribe').attr('disabled', false);

  
//console.log(data.responseJSON)

const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          icon: 'success',
          //title: 'Product Added To Cart',
          showConfirmButton: false,
          timer: 3000
        })

      //if there is an error

        if (email == ""){
                Toast.fire({
                    icon: 'error',
                    title: "Please Enter a valid email!"
                })
        }


});
    


})



</script>


@endsection