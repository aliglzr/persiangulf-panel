<div class="text-gray-800 fs-7">
    {{auth()->user()->balance == 0 ? 'صفر' : convertNumbers(number_format(auth()->user()->balance))}}
    {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 ms-1') !!}
</div>

