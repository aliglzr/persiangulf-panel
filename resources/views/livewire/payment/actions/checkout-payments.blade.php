<div>
    <div class="row">
            <div class="form-group col-12 col-md-6 col-lg-4 mt-6">
                <label for="selectOperation">عملیات</label>
                <select wire:model="operation" class="form-select" id="selectOperation">
                    <option value="checkout" selected>تسویه</option>
                </select>
            </div>
    </div>
    <button onclick="run()" class="btn btn-primary mt-3">اجرا</button>
</div>
@push('scripts')
    <script>
        var payments = [];
        function toggleItemInArray(item, arr) {
            const index = arr.indexOf(item);
            if (index > -1) {
                arr.splice(index, 1); // remove the item
            } else {
                arr.push(item); // add the item
            }
            return arr;
        }
        function add(paymentId){
            payments = toggleItemInArray(paymentId,payments)
        }

        function run() {
            Swal.fire({
                icon: "question",
                title: 'آیا از تسویه کردن پرداخت ها اطمینان دارید؟' ,
                showCancelButton: true,
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-secondary",
                }
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                @this.run(payments);
                }
            })
        }


        // Listen for clicks on the checkboxes in the table
        $('#payments-table').on('click', 'input[type="checkbox"]', function(e) {
            // Check if the shift key is being held down
            if (e.shiftKey) {
                // Get the data-id of the current checkbox
                var currentId = $(this).data('id');

                // Find the previous checkbox that was clicked
                var previousId = null;
                $('input[type="checkbox"]:checked').each(function() {
                    if (previousId === null || $(this).data('id') < currentId) {
                        previousId = $(this).data('id');
                    }
                });


                // Select all checkboxes between the previous and current checkboxes
                if (previousId !== null) {
                    var currentChecked = $(this).prop('checked');
                    $('input[type="checkbox"]').each(function() {
                        if ($(this).data('id') > previousId && $(this).data('id') < currentId) {
                            $(this).prop('checked', currentChecked);
                            payments = toggleItemInArray($(this).val(),payments)
                        }
                    });
                }
            }
        });
    </script>
    @endpush
