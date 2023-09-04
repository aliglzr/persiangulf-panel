<td class="text-end">
    @if(!$payment->checkout)
        <button onclick="checkoutPayment({{$payment->id}})"
                class="btn btn-sm btn-icon btn-icon-secondary opacity-25 opacity-100-hover mx-1"
                title="تغییر وضعیت به تسویه شده"><i class="fas fa-check fs-4"></i></button>
    @else
        <button class="btn btn-sm btn-icon btn-icon-success opacity-100 mx-1"
                title="تسویه شده"><i class="fas fa-check fs-4"></i></button>
    @endif
</td>



