<div class="jcarousel-wrapper border-primary p-1">
    <div class="jcarousel">
        <ul>
            @foreach($categories as $cat)
            <li class="text-center" style="cursor:pointer;" onclick="_loadDatasByCategory({{$cat->id}})">
                <p class="mb-0">
                <div class="btn-group">
                    <button class="btn btn-icon btn-sm btn-outline-primary" onclick="_formCategory({{$cat->id}})"
                        title="Edit">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!}</button>
                    @if($cat->services->count()==0)
                    <button type="button" onclick="_deleteCategory({{ $cat->id }})"
                        class="btn btn-icon btn-sm btn-outline-danger">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DELETE')!!}</button>
                    @endif
                </div>
                </p>
                @if($cat->path_icon)
                <p class="mb-0 text-center"><img style="height:60px" src="{{asset(base64_decode($cat->path_icon))}}"
                        class="" />
                </p>
                @endif
                <p class="mb-0"><span> {{$cat->name}}</span></p>
                <p class="mb-0"><span> {{$cat->name_ar}}</span></p>
                <p class="mb-0"><span class="badge badge-light-primary badge-pill mr-1">{{$cat->services->count()}}
                        services</span>
                    @if($cat->is_active==0)
                    <span class="badge badge-light-danger badge-pill">disabled</span>
                    @endif
                </p>
            </li>
            @endforeach
        </ul>
    </div>

    <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
    <a href="#" class="jcarousel-control-next">&rsaquo;</a>

    <p class="jcarousel-pagination d-none"></p>
</div>

@php
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp

<script>
(function($) {
    $(function() {
        var jcarousel = $('.jcarousel');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function() {
                var carousel = $(this),
                    width = carousel.innerWidth();

                if (width >= 600) {
                    width = width / 6;
                } else if (width >= 350) {
                    width = width / 2;
                }

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular',
                @if($lang=='ar')
                rtl: true,
                @endif
            });

        $('.jcarousel-control-prev')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=1'
            });

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .on('click', function(e) {
                e.preventDefault();
            })
            .jcarouselPagination({
                perPage: 1,
                item: function(page) {
                    return '<a href="#' + page + '">' + page + '</a>';
                }
            });
    });
})(jQuery);
</script>