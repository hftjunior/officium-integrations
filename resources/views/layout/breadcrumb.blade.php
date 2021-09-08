<ol class="breadcrumb">
    @foreach ($breadcrumb as $key => $item)
        @if ($key == (count($breadcrumb) -1))
        <li class="active">
        @else
        <li>
        @endif
        <a href="{{$item['url']}}">
        @if ($key == 0)
            <i class="fa fa-home"></i>
        @endif
        {{$item['page']}}</a></li>
    @endforeach            
</ol>  