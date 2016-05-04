<h3 class="text-center">I am looking for</h3>
<ul data-highlight-active class="nav nav-tabs nav-stacked nav-coupon-category nav-coupon-category-left">
   {{-- <li class="active"><a href="#"><i class="fa fa-ticket"></i>All</a></li>--}}
    @foreach($categories as $cat)
    <li class="{{Active::pattern("category/" . $cat->title_alias)}} {{--{{count($cat->deals) == 0 ? 'hidden':null;}}--}}">
        <a href="{{url('/category/' . $cat->title_alias)}}"><i class="fa {{$cat->category_icon}}"></i>{{$cat->title}}<span>{{count($cat->deals)}}</span></a>
    </li>
    @endforeach
</ul>