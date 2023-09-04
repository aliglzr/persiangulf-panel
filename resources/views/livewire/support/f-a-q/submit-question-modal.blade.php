<div wire:ignore.self class="modal fade" tabindex="-1" id="submit_question_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{$editMode ? 'ویرایش سوال' : 'ثبت سوال جدید'}}</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="fa fa-close"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <!--begin::question input-->
                <label wire:ignore for="question"
                       class="col-lg-4 col-form-label fs-6 fw-bolder">سوال</label>
                <input id="question" wire:model.lazy="question.question"
                       class="form-control @error('question.question') is-invalid @enderror">
                @error('question.question')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            <!--end::question input-->

                <!--begin::description input-->
                <label for="answer"
                       class=" col-lg-4 col-form-label fs-6 fw-bolder">پاسخ</label>
                <textarea id="answer" wire:model.lazy="question.answer"
                          class="form-control @error('question.answer') is-invalid @enderror"></textarea>
                @error('question.answer')
                <div class="invalid-feedback" role="alert">{{$message}}</div>
                @enderror
            <!--end::title input-->

                <div class="row" wire:ignore>
                    <!--begin::team input-->
                    <label wire:ignore for="question_name"
                           class="col-lg-4 col-form-label fs-6 fw-bolder">دسته</label>
                    <select wire:ignore id="question_name" class="form-select"
                            data-placeholder="انتخاب دسته">
                        @foreach($categories as $category)
                            <option value="{{$category}}">{{$category}}</option>
                        @endforeach
                    </select>
                </div>
                @error('selectedCategory')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            <!--end::team input-->
            </div>


            <div class="modal-footer {{$editMode ? 'justify-content-between' : ''}}">
                @if($editMode)
                    <div>
                        <button type="button" wire:click.prevent="delete()" class="btn btn-danger">حذف</button>
                    </div>
                @endif
                <div>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">انصراف</button>
                    <button type="button" wire:click.prevent="submitQuestion()" class="btn btn-primary">ارسال</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $('#question_name').select2({
                dropdownParent: $('#submit_question_modal'),
                tags : true
            });
            });

            document.addEventListener('dehydrate', function () {
                $('#question_name').select2({
                    dropdownParent: $('#submit_question_modal'),
                    tags : true
                });
            })

            const submitQuestionModal = document.getElementById('submit_question_modal');
            submitQuestionModal.addEventListener('hidden.bs.modal', event => {
            @this.resetModal();
                $("#question_name").val("").trigger('change');
            });

            document.addEventListener('toggleSubmitQuestionModal', function () {
                $('#submit_question_modal').modal('toggle');
            });

            $('#question_name').on('select2:select', function (e) {
            @this.set('selectedCategory', e.target.value);
            });

        document.addEventListener('setSelectValues',function (data) {
            data = data.detail;
            $("#question_name").val(data['category']).trigger('change');
        })
    </script>
@endpush
