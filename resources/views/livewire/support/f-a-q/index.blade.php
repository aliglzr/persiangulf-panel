<div>
    <livewire:support.header :user="$user"/>
    <div class="card">
        <!--begin::Body-->
        <div class="card-body p-10 p-lg-15">
            <!--begin::Classic content-->
            <div class="mb-13">
                <!--begin::Intro-->
                <div class="mb-15">
                    <!--begin::Title-->
                    <h4 class="fs-2x text-gray-800 w-bolder mb-6">سوالات متداول</h4>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <p class="fw-semibold fs-4 text-gray-600 mb-2">لطفا قبل از ارسال تیکت، سوال خود را جستجو کنید تا
                        پاسخ پرسش های خود را پیدا کنید. در صورت ابهام تیکت ارسال کنید.</p>
                    <!--end::Text-->
                </div>
                <!--end::Intro-->
                <!--begin::Row-->
                <div class="row mb-12">
                @foreach($categories as $key1 => $category)
                    <!--begin::Col-->
                        <div class="col-md-6 pe-md-10 mb-10">
                            <!--begin::Title-->
                            <h2 class="text-gray-800 fw-bold mb-4">{{$category}}</h2>
                            <!--end::Title-->
                            <!--begin::Accordion-->
                        @foreach(\App\Models\Question::where('name',$category)->get() as $key2 => $question)
                            <!--begin::Section-->
                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0"
                                         data-bs-toggle="collapse" data-bs-target="#question_{{$key1}}_{{$key2}}">
                                        <!--begin::Icon-->
                                        <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
                                        {!! get_svg_icon('icons/duotune/general/gen036.svg','svg-icon toggle-on svg-icon-primary svg-icon-1') !!}
                                        <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                        {!! get_svg_icon('icons/duotune/general/gen035.svg','svg-icon toggle-off svg-icon-1') !!}
                                        <!--end::Svg Icon-->
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">{{$question->question}}</h4>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div id="question_{{$key1}}_{{$key2}}" class="collapse fs-6 ms-1">
                                        <!--begin::Text-->
                                        <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">{!! $question->answer !!}</div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Section-->
                        @endforeach
                        <!--end::Accordion-->
                        </div>
                        <!--end::Col-->
                    @endforeach
                </div>
                @if(auth()->user()->can('modify-faqs'))
                    <!--start::Row-->
                        <div wire:ignore class="row">
                    <div id="faq_kanban"></div>
                </div>
                    <!--end::Row-->
                @endif
            </div>
            <!--end::Classic content-->
        </div>
        <!--end::Body-->
    </div>
    <livewire:support.f-a-q.submit-question-modal/>
</div>
@if(auth()->user()->can('modify-faqs'))
@section('title')
سوالات متداول
@endsection
@section('description')
    سوالات متداول
@endsection
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            function loadKanban(boards) {

                console.log(boards);
                $('#faq_kanban').empty();
                var kanban = new jKanban({
                    element: '#faq_kanban',
                    gutter: '0',
                    widthBoard: '250px',
                    dropEl: function (el, target, source, sibling) {
                        let category = el.parentNode.parentNode.getAttribute('data-id');
                        let questionId = el.getAttribute('data-eid');
                    @this.updateQuestionCategory(questionId, category);
                    },
                    dragBoard: function (el, source) {
                        console.log(el, source)
                    },
                    click: function (el) {
                    @this.emit('editServer', el.getAttribute('data-eid'));
                    },
                    dragendBoard: function (el) {
                        let turn = el.getAttribute('data-order');
                        let category = el.getAttribute('data-id');
                    @this.updateCategoryTurn(turn, category);
                    },
                    buttonClick: function (el, boardId) {
                    @this.emit('createQuestionForCategory', boardId);
                    },
                    itemAddOptions: {
                        enabled: true,                                              // add a button to board for easy item creation
                        content: '+',                                                // text or html content of the board button
                        class: 'kanban-title-button btn btn-secondary btn-sm text-dark',         // default class of the button
                        footer: false                                                // position the button on footer
                    },
                    boards: JSON.parse(boards),
                });
            }

            loadKanban('{!! json_encode($boards, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}');
            document.addEventListener('updateBoards', function (data) {
                loadKanban(data.detail.boards);
            })

        })


    </script>
@endpush
@endif