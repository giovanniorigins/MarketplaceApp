<!DOCTYPE HTML>
<html>

<head>
    <title>Marketplace</title>
    <!-- meta info -->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Marketplace, deals" />
    <meta name="description" content="Marketplace">
    <meta name="author" content="iGiovanni">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="none">
    @include('shared.head')
</head>

<body ng-app="app" class="">


    <div class="global-wrap" ng-controller="AppCtrl">


        <!-- //////////////////////////////////
	//////////////MAIN HEADER///////////// 
	////////////////////////////////////-->
	@include('business.shared.header')
        <!-- //////////////////////////////////
	//////////////END MAIN HEADER////////// 
	////////////////////////////////////-->


        <!-- //////////////////////////////////
	//////////////PAGE CONTENT///////////// 
	////////////////////////////////////-->
    @include('section.featured')
        <div class="container">
            <div class="row row-wrap">
                <div class="col-md-6">
                    <div id="map-canvas" style="width:100%; height:300px;"></div>
                </div>
                <div class="col-md-3">
                    {{ Form::open(array('url' => '/contact-us', 'id' => "contact-form", 'class' => "contact-form", 'name' => 'contactForm')) }}
                    <form name="contactForm" id="contact-form" class="contact-form"  method="post" action="includes/mail/index.html">
                        <fieldset>
                            <div class="form-group">
                                <label>Name</label>
                                <div class="bg-warning form-alert" id="form-alert-name">Please enter your name</div>
                                <input class="form-control" id="name" type="text" placeholder="Enter Your name here" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <div class="bg-warning form-alert" id="form-alert-email">Please enter your valid E-mail</div>
                                <input class="form-control" id="email" type="text" placeholder="You E-mail Address" />
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <div class="bg-warning form-alert" id="form-alert-message">Please enter message</div>
                                <textarea class="form-control" id="message" placeholder="Your message"></textarea>
                            </div>
                            <div class="bg-warning alert-success form-alert" id="form-success">Your message has been sent successfully!</div>
                            <div class="bg-warning alert-error form-alert" id="form-fail">Sorry, error occured this time sending your message</div>
                            <button id="send-message" type="submit" class="btn btn-primary">Send Message</button>
                        </fieldset>
                    {{ Form::close() }}
                </div>
                <div class="col-md-3">
                    <h5>Contact Info</h5>
                    <p>Contact us if you have any questions.</p>
                    <ul class="list">
                        {{--<li><i class="icon-map-marker"></i> Location: Mountain View, CA 94043</li>
                        <li><i class="icon-phone"></i> Phone: 555-555-555</li>--}}
                        <li><i class="icon-envelope"></i> E-mail: <a href="#">info@marketplace.gorigins.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="gap gap-small"></div>
        </div>


        <!-- //////////////////////////////////
	//////////////END PAGE CONTENT///////// 
	////////////////////////////////////-->



        <!-- //////////////////////////////////
	//////////////MAIN FOOTER////////////// 
	////////////////////////////////////-->
    @include('shared.footer')
        <!-- //////////////////////////////////
	//////////////END MAIN  FOOTER///////// 
	////////////////////////////////////-->


    @include('shared.foot')
    </div>
</body>

</html>
