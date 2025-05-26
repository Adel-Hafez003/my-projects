@extends('Frontend.layouts.app')

@section('style')
@endsection

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Checkout <span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="checkout">
            <div class="container">
                <form action="{{ url('checkout/place_order') }}" id="SubmitForm" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-9">
                            <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <label>First Name *</label>
                                    <input type="text" name="first_name" class="form-control" required>
                                </div><!-- End .col-sm-6 -->
                                <div class="col-sm-6">
                                    <label>Last Name *</label>
                                    <input type="text" name="last_name" class="form-control" required>
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <label>Company Name (Optional)</label>
                            <input type="text" name="company_name" class="form-control">

                            <label>Country *</label>
                            <input type="text" name="county" class="form-control" required>

                            <label>Street address *</label>
                            <input type="text" name="address_one" class="form-control" placeholder="House number and Street name" required>
                            <input type="text" name="address_two" class="form-control" placeholder="Appartments, suite, unit etc ..." required>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Town / City *</label>
                                    <input type="text" name="city" class="form-control" required>
                                </div><!-- End .col-sm-6 -->
                                <div class="col-sm-6">
                                    <label>State *</label>
                                    <input type="text" name="state" class="form-control" required>
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Postcode / ZIP *</label>
                                    <input type="text" name="postcode" class="form-control" required>
                                </div><!-- End .col-sm-6 -->
                                <div class="col-sm-6">
                                    <label>Phone *</label>
                                    <input type="tel" name="phone" class="form-control" required>
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <label>Email address *</label>
                            <input type="email" name="email" class="form-control" required>

                          
                            @if(!Auth::check())
                                <label>Password *</label>
                                <input type="password" name="password" class="form-control" required>
                            @endif
                            
                            

                            <label>Order notes (optional)</label>
                            <textarea class="form-control" name="note" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                        </div><!-- End .col-lg-9 -->

                        <aside class="col-lg-3">
                            <div class="summary">
                                <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->
                                <table class="table table-summary">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Cart::content() as $key => $cart)
                                            @php
                                                $getCartProduct = App\Models\ProductModel::getSingle($cart->id);
                                            @endphp
                                            <tr>
                                                <td><a href="{{ url($getCartProduct->slug) }}">{{ $getCartProduct->title }}</a></td>
                                                <td>${{ number_format($cart->price * $cart->qty, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="summary-subtotal">
                                               <td>Subtotal:</td>
                                              <td>${{ number_format(floatval(Cart::subtotal()), 2) }}</td>
                                          </tr>
                                          
                                          <tr>
                                              <td>Shipping:</td>
                                              <td>Free shipping</td>
                                          </tr>
                                          <tr class="summary-total">
                                              <td>Total:</td>
                                              <td>${{ number_format(floatval(Cart::subtotal()), 2) }}</td> <!-- استخدم subtotal هنا بدلاً من total -->
                                          </tr>
                                    </tbody>
                                </table><!-- End table table-summary -->
                                <input type="hidden" id="getShippingChargeTotal" value="0">

                                <div class="accordion-summary" id="accordion-payment">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" value="cash" id="Cashondelivery" name="payment_method" required class="custom-control-input">
                                        <label class="custom-control-label" for="Cashondelivery">Cash on delivery</label>
                                    </div>
                                    <div class="custom-control custom-radio" style="margin-top: 0px;">
                                        <input type="radio" value="paypal" id="PayPal" name="payment_method" required class="custom-control-input">
                                        <label class="custom-control-label" for="PayPal">PayPal</label>
                                    </div>
                                    <div class="custom-control custom-radio" style="margin-top: 0px;">
                                        <input type="radio" value="stripe" id="CreditCard" name="payment_method" required class="custom-control-input">
                                        <label class="custom-control-label" for="CreditCard">Credit Card (Stripe)</label>
                                    </div>
                                </div><!-- End .accordion -->

                                <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                    <span class="btn-text">Place Order</span>
                                    <span class="btn-hover-text">Proceed to Checkout</span>
                                </button>
                            </div>
                        </aside>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
    <script type="text/javascript">
            
                $('body').delegate('.createAccount', 'change', function() {
                    if (this.checked) {
                        $('#showPassword').show();
                        $("#inputPassword").prop('required', true);
                    } else {
                        $('#showPassword').hide();
                        $("#inputPassword").prop('required', false);
                    }
                });
            
               
            
                $('body').delegate('#SubmitForm', 'submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('checkout/place_order') }}",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(data) {
                            if (data.status == false) {
                                alert(data.message);
                            }
                        },
                        error: function(data) {
                            // Handle error
                        }
                    });
                });
           
     </script>
@endsection