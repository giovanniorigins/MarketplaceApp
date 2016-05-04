<!-- meta info -->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Marketplace, deals" />
    <meta name="description" content="Marketplace">
    <meta name="author" content="iGiovanni">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow, noindex">
    <base href="http://marketplace.gorigins.com/" />

<!-- Google fonts -->
{{ HTML::style('//fonts.googleapis.com/css?family=Open+Sans:400,600,700,300') }}
{{ HTML::style('//fonts.googleapis.com/css?family=Roboto:400,100,300') }}
<!-- Bootstrap styles -->
{{ HTML::style("//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/css/bootstrap.min.css") }}
<!-- Font Awesome styles (icons) -->
{{ HTML::style("//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css") }}
<!-- Main Template styles -->
{{ HTML::style("css/styles.css") }}
<!-- IE 8 Fallback -->
<!--[if lt IE 9]>
    {{ HTML::style("css/ie.css") }}
<![endif]-->

<!-- Your custom styles (blank file) -->
{{ HTML::style("css/mystyles.css") }}

<script>
    window.App = window.App || {{ $window }};
</script>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-27155404-10', 'auto');
ga('require', 'displayfeatures');
//ga('send', 'pageview');

</script>

{{ HTML::style("bower_components/angular-socialshare/angular-socialshare.min.css") }}
{{ HTML::script("//platform.twitter.com/widgets.js") }}
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
{{ HTML::script("//platform.tumblr.com/v1/share.js") }}