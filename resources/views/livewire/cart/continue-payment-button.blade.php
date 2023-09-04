<div>
    <a href="{{route('carts.index')}}" {{(auth()->user()->cart()->count() == 0) ? 'disabled' : ''}} class="btn btn-sm {{(auth()->user()->cart()->count() == 0) ? 'btn-secondary' : 'btn-primary'}}">ادامه جهت پرداخت <i class="bi bi-arrow-left fs-4 ms-2"></i> </a>
</div>
