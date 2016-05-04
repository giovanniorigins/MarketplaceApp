<?php $user = Confide::user(); ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Home | Marketplace</title>
    @include('shared.head')
</head>

<body ng-app="app" class="">


    <div class="global-wrap" ng-controller="AppCtrl">


        <!-- //////////////////////////////////
	//////////////MAIN HEADER///////////// 
	////////////////////////////////////-->
	@include('shared.header')
        <!-- //////////////////////////////////
	//////////////END MAIN HEADER////////// 
	////////////////////////////////////-->


        <!-- //////////////////////////////////
	//////////////PAGE CONTENT///////////// 
	////////////////////////////////////-->
    @include('section.featured')

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        @include('account.shared.nav')
                    </aside>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" value="{{{$user->username}}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">E-mail</label>
                                    <input type="text" value="{{{$user->email}}}" class="form-control">
                                </div>
                                <pre>{{$user}}</pre>
                                {{--<div class="form-group">
                                    <label for="">First Name</label>
                                    <input type="text" value="{{{$window->user->username}}}" class="form-control">
                                </div>
                                <div class="form-group hidden">
                                    <label for="">Phone Number</label>
                                    <input type="text" value="+1 202 555 0113" class="form-control">
                                </div>--}}
                                <input type="submit" value="Save Changes" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
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
