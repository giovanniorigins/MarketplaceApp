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
                <div class="col-md-8">
                    <!-- START BOOTSTRAP CAROUSEL -->
                    <div id="my-carousel" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="active item">
                                <img src="img/logos/960x540_banner.jpg" alt="Image Alternative text" title="Agora" />
                            </div>
                            <div class="item">
                                <img src="img/logos/960x540_banner.jpg" alt="Image Alternative text" title="Agora" />
                            </div>
                        </div>
                        <a class="carousel-control left" href="#my-carousel" data-slide="prev"></a>
                        <a class="carousel-control right" href="#my-carousel" data-slide="next"></a>
                    </div>
                    <!-- END BOOTSTRAP CAROUSEL -->
                </div>
                <div class="col-md-4">
                    <h3>The Company</h3>
                    <p>Agora is a new start-up that aims to become the digital downtown. We foster a culture of forward thinking and provide services that bring consumers and vendors even closer together.</p>
                </div>
            </div>
            <div class="gap gap-small"></div>
            <div class="row row-wrap">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h3>Mission</h3>
                    <p>Provide a platform for businesses to engage their customers and for our users to have real-time deals and promotions available at their fingertips.</p>
                </div>
                <div class="col-md-3"></div>
                {{--<div class="col-md-6">
                    <h3>Vision</h3>
                    <p>Mauris lorem hac cras porttitor orci ipsum orci nostra orci iaculis pretium maecenas fermentum donec venenatis adipiscing adipiscing id litora leo netus taciti sed maecenas hendrerit conubia class gravida dignissim cubilia ultricies quam ipsum himenaeos</p>
                </div>--}}
            </div>
            <div class="gap gap-small"></div>
            {{--<div class="row row-wrap">
                <div class="col-md-3">
                    <h3>Behind the Scenes</h3>
                    <p>Id ultrices tempor rutrum arcu nascetur ultricies sollicitudin arcu ultrices integer montes vitae platea ornare feugiat torquent condimentum mattis dapibus interdum tellus fringilla mollis nulla duis velit ipsum consequat suscipit primis enim a accumsan magna</p>
                </div>
                <div class="col-md-9">
                    <div class="row row-no-gutter " id="popup-gallery">
                        <div class="col-md-3">
                            <!-- HOVER IMAGE -->
                            <a class="hover-img popup-gallery-image" href="img/800x600.png" data-effect="mfp-zoom-out">
                                <img src="img/800x600.png" alt="Image Alternative text" title="4 Strokes of Fun" /><i class="fa fa-resize-full hover-icon"></i>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <!-- HOVER IMAGE -->
                            <a class="hover-img popup-gallery-image" href="img/800x600.png" data-effect="mfp-zoom-out">
                                <img src="img/800x600.png" alt="Image Alternative text" title="new york at an angle" /><i class="fa fa-resize-full hover-icon"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap gap-small"></div>--}}
            {{--<div class="row row-wrap">
                <div class="col-md-3">
                    <h3>Meet The Team</h3>
                    <p>Adipiscing suscipit inceptos netus dolor risus eleifend suspendisse quam hac elementum parturient cubilia porttitor odio sem habitant in cras phasellus sit metus vestibulum condimentum nam platea sociosqu justo ac vulputate</p>
                    <div class="gap gap-small"></div>
                    <h4>Want to Join Our Team?</h4>
                    <p>Vivamus luctus cubilia adipiscing commodo nulla lacinia taciti justo platea</p>
                    <a href="#" class="btn btn-primary">Join Team</a>
                </div>
                <div class="col-md-9">
                    <div class="row row-wrap">
                        <div class="col-md-4">
                            <div class="team-member">
                                <img src="https://lh3.googleusercontent.com/-6qgt9SxErOU/U5HvBOHzOAI/AAAAAAAAAeU/DkDJsvF4r9M/w834-h835-no/2014-05-25%2B09.31.17-1.jpg" alt="Image Alternative text" title="iGiovanni" />
                                <h4>Jerez Bain</h4>
                                <p class="team-member-position">CEO</p>
                                <ul class="team-member-social">
                                    <li>
                                        <a class="fa fa-link" href="http://gorigins.com"></a>
                                    </li>
                                    <li>
                                        <a class="fa fa-facebook" href="https://www.facebook.com/jerezb"></a>
                                    </li>
                                    <li>
                                        <a class="fa fa-google-plus" href="https://plus.google.com/+JerezBain"></a>
                                    </li>
                                    <li>
                                        <a class="fa fa-git" href="https://github.com/giovanniorigins"></a>
                                    </li>
                                    <li>
                                        <a class="fa fa-linkedin" href="https://www.linkedin.com/in/jgiovanni"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap gap-small"></div>--}}
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
