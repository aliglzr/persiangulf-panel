<x-base-layout>

    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="d-none d-lg-flex flex-column flex-lg-row-auto w-100 w-lg-275px" data-kt-drawer="true"
             data-kt-drawer-name="inbox-aside" data-kt-drawer-activate="{default: true, lg: false}"
             data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start"
             data-kt-drawer-toggle="#kt_inbox_aside_toggle">
            <!--begin::Sticky aside-->
            <div class="card card-flush mb-0" data-kt-sticky="false" data-kt-sticky-name="inbox-aside-sticky"
                 data-kt-sticky-offset="{default: false, xl: '100px'}" data-kt-sticky-width="{lg: '275px'}"
                 data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false"
                 data-kt-sticky-zindex="95">
                <!--begin::Aside content-->
                <div class="card-body">
                    <!--begin::Button-->
                    <h2 class="fw-bold w-100 mb-8">جزییات</h2>
                    <!--end::Button-->
                    <div class="mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold text-muted">ایمیل</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div>
                            <a href="{{ route('mailables.show', ['name' => $name]) }}">{{ $name }}</a>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold text-muted">Namespace (فضای نام)</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div>
                            <span dir="ltr" class="fw-bold fs-6 text-gray-800">{{$templateData['namespace']}}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold text-muted">{{ $templateData['is_markdown'] ? 'Markdown' : 'View' }}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div>
                            <span class="fw-bold fs-6 text-gray-800">{{ $templateData['template_name'] }}</span>
                        </div>
                        <!--end::Col-->
                    </div>

                </div>
                <!--end::Aside content-->
            </div>
            <!--end::Sticky aside-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header align-items-center py-5 gap-5">
                    <!--begin::Actions-->
                    <div class="d-flex">
                        <!--begin::Back-->
                        <a href="{{route('mailables.index')}}"
                           class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="برگشت" aria-label="Back">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                        {!! get_svg_icon('icons/duotune/arrows/arr064.svg','svg-icon svg-icon-1 m-0') !!}
                        <!--end::Svg Icon-->
                        </a>
                        <!--end::Back-->
                        <!--begin::Send Test-->
                        <button class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2 send-test"
                                data-bs-toggle="modal" data-bs-target="#sendTestMail" title="ارسال ایمیل تست">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                        {!! get_svg_icon('icons/duotune/communication/com010.svg','svg-icon svg-icon-2 m-0') !!}
                        <!--end::Svg Icon-->
                        </button>
                        <!--end::Send Test-->

                        <!--begin::Edit-->
                        <button id="save-template" onclick="saveTemplate()"
                                class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2"
                                data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit" title="ذخیره">
                            <i class="fa fa-save"></i>
                            <!--end::Svg Edit-->
                        </button>
                        <!--end::Edit-->

                        <!--begin::Preview-->
                        <button class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2 preview-toggle"
                           data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Preview"
                           title="مشاهده پیش نمایش">
                            <i class="fa fa-eye"></i>
                            <!--end::Svg Preview-->
                        </button>
                        <!--end::Edit-->

                    </div>
                    <!--end::Actions-->
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                               role="tab" aria-controls="pills-home" aria-selected="true">Editor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ !is_null($templateData['text_template']) ? '' : 'disabled' }}"
                               id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                               aria-controls="pills-profile" aria-selected="false">Plain Text</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">


                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                            <div class="p-3" style="border-top: 1px solid #ccc;">
                                @foreach($templateData['view_data'] as $param)

                                    @if (isset($param['data']['type']) && $param['data']['type'] === 'model')
                                        <div class="btn-group dropright">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    maileclipse-data-toggle="tooltip" data-placement="top"
                                                    title="Elequent Model">
                                                <i class="fas fa-database mr-1"></i>{{ $param['key'] }}
                                            </button>
                                            <div class="dropdown-menu">

                                                <!-- Dropdown menu links -->
                                                @if ( !$param['data']['attributes']->isEmpty() )
                                                    <a class="dropdown-item view_data_param"
                                                       param-key="{{ $param['key'] }}"
                                                       href="#param">{{ $param['key'] }}</a>
                                                    <div class="dropdown-divider"></div>
                                                    @foreach( $param['data']['attributes'] as $key => $val )
                                                        <a class="dropdown-item is-attribute view_data_param"
                                                           param-parent-key="{{ $param['key'] }}" param-key="{{ $key }}"
                                                           href="#param">{{ $key }}</a>
                                                    @endforeach

                                                @else

                                                    <span class="dropdown-item">No attributes found</span>

                                                @endif

                                            </div>
                                        </div>

                                    @elseif(isset($param['data']['type']) && $param['data']['type'] === 'elequent-collection')

                                        <button type="button" class="btn btn-info btn-sm view_data_param"
                                                maileclipse-data-toggle="tooltip" data-placement="top"
                                                title="Elequent Collection" param-key="{{ $param['key'] }}">
                                            <i class="fa fa-table mr-1" aria-hidden="true"></i>{{ $param['key'] }}
                                        </button>

                                    @elseif(isset($param['data']['type']) && $param['data']['type'] === 'collection')

                                        <button type="button" class="btn btn-success btn-sm view_data_param"
                                                maileclipse-data-toggle="tooltip" data-placement="top"
                                                title="Collection" param-key="{{ $param['key'] }}">
                                            <i class="fa fa-table mr-1" aria-hidden="true"></i>{{ $param['key'] }}
                                        </button>

                                    @else

                                        <button type="button" class="btn btn-secondary btn-sm view_data_param mb-2"
                                                maileclipse-data-toggle="tooltip" data-placement="top"
                                                title="Simple Variable" param-key="{{ $param['key'] }}">
                                            <i class="fa fa-anchor mr-1" aria-hidden="true"></i>{{ $param['key'] }}
                                        </button>

                                    @endif

                                @endforeach
                            </div>
                            <textarea id="template_editor" cols="30"
                                      rows="10">{{ $templateData['template'] }}</textarea>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                             aria-labelledby="pills-profile-tab">
                            @if(!is_null($templateData['text_template']))
                                <textarea id="plain_text" cols="30"
                                          rows="10">{{ $templateData['text_template'] }}</textarea>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content-->
    </div>

    <livewire:mail.send-test-mail-modal :name="$name"/>
    @push('scripts')


        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/codemirror.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/codemirror.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.0/tinymce.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/xml/xml.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/css/css.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/javascript/javascript.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/htmlmixed/htmlmixed.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/addon/display/placeholder.js"></script>

        <script type="text/javascript">

                @if ( isset($templateData['template']) )

                var templateID = "template_view_{{ $name }}_{{ $templateData['template_name'] }}";

                @if ( $templateData['is_markdown'] )

                var simplemde = new SimpleMDE(
                    {
                        element: $("#template_editor")[0],
                        toolbar: [
                            {
                                name: "bold",
                                action: SimpleMDE.toggleBold,
                                className: "fa fa-bold",
                                title: "Bold",
                            },
                            {
                                name: "italic",
                                action: SimpleMDE.toggleItalic,
                                className: "fa fa-italic",
                                title: "Italic",
                            },
                            {
                                name: "strikethrough",
                                action: SimpleMDE.toggleStrikethrough,
                                className: "fa fa-strikethrough",
                                title: "Strikethrough",
                            },
                            {
                                name: "heading",
                                action: SimpleMDE.toggleHeadingSmaller,
                                className: "fa fa-header",
                                title: "Heading",
                            },
                            {
                                name: "code",
                                action: SimpleMDE.toggleCodeBlock,
                                className: "fa fa-code",
                                title: "Code",
                            },
                            "|",
                            {
                                name: "unordered-list",
                                action: SimpleMDE.toggleBlockquote,
                                className: "fa fa-list-ul",
                                title: "Generic List",
                            },
                            {
                                name: "uordered-list",
                                action: SimpleMDE.toggleOrderedList,
                                className: "fa fa-list-ol",
                                title: "Numbered List",
                            },
                            {
                                name: "clean-block",
                                action: SimpleMDE.cleanBlock,
                                className: "fa fa-eraser fa-clean-block",
                                title: "Clean block",
                            },
                            "|",
                            {
                                name: "link",
                                action: SimpleMDE.drawLink,
                                className: "fa fa-link",
                                title: "Create Link",
                            },
                            {
                                name: "image",
                                action: SimpleMDE.drawImage,
                                className: "fa fa-picture-o",
                                title: "Insert Image",
                            },
                            /*{
                                    name: "table",
                                    action: SimpleMDE.drawTable,
                                    className: "fa fa-table",
                                    title: "Insert Table",
                            },*/
                            {
                                name: "horizontal-rule",
                                action: SimpleMDE.drawHorizontalRule,
                                className: "fa fa-minus",
                                title: "Insert Horizontal Line",
                            },
                            "|",
                            {
                                name: "button-component",
                                action: setButtonComponent,
                                className: "fa fa-hand-pointer-o",
                                title: "Button Component",
                            },
                            {
                                name: "table-component",
                                action: setTableComponent,
                                className: "fa fa-table",
                                title: "Table Component",
                            },
                            {
                                name: "promotion-component",
                                action: setPromotionComponent,
                                className: "fa fa-bullhorn",
                                title: "Promotion Component",
                            },
                            {
                                name: "panel-component",
                                action: setPanelComponent,
                                className: "fa fa-thumb-tack",
                                title: "Panel Component",
                            },
                            "|",
                            {
                                name: "side-by-side",
                                action: SimpleMDE.toggleSideBySide,
                                className: "fa fa-columns no-disable no-mobile",
                                title: "Toggle Side by Side",
                            },
                            {
                                name: "fullscreen",
                                action: SimpleMDE.toggleFullScreen,
                                className: "fa fa-arrows-alt no-disable no-mobile",
                                title: "Toggle Fullscreen",
                            },
                            {
                                name: "preview",
                                action: SimpleMDE.togglePreview,
                                className: "fa fa-eye no-disable",
                                title: "Toggle Preview",
                            },
                        ],
                        renderingConfig: {singleLineBreaks: false, codeSyntaxHighlighting: false,},
                        hideIcons: ["guide"],
                        spellChecker: false,
                        promptURLs: true,
                        placeholder: "Write your Beautiful Email",
                        previewRender: function (plainText, preview) {
                            $.ajax({
                                method: "POST",
                                url: "{{ route('previewMarkdownView') }}",
                                data: {
                                    markdown: plainText,
                                    namespace: '{{ addslashes($templateData['namespace']) }}',
                                    viewdata: "{{ preg_replace("/[\r\n]/","<br />", serialize($templateData['view_data'])) }}",
                                    name: '{{ $name }}'
                                }
                            }).done(function (HtmledTemplate) {
                                preview.innerHTML = HtmledTemplate;
                            });

                            return '';
                        },

                    });

                function setButtonComponent(editor) {

                    var cm = editor.codemirror;
                    var output = '';
                    var selectedText = cm.getSelection();
                    var text = selectedText || 'Button Text';

                    output = `
[component]: # ('mail::button',  ['url' => ''])
` + text + `
[endcomponent]: #
        `;
                    cm.replaceSelection(output);

                }

                function setPromotionComponent(editor) {

                    var cm = editor.codemirror;
                    var output = '';
                    var selectedText = cm.getSelection();
                    var text = selectedText || 'Promotion Text';

                    output = `
[component]: # ('mail::promotion')
` + text + `
[endcomponent]: #
        `;
                    cm.replaceSelection(output);

                }

                function setPanelComponent(editor) {

                    var cm = editor.codemirror;
                    var output = '';
                    var selectedText = cm.getSelection();
                    var text = selectedText || 'Panel Text';

                    output = `
[component]: # ('mail::panel')
` + text + `
[endcomponent]: #
        `;
                    cm.replaceSelection(output);

                }

                function setTableComponent(editor) {

                    var cm = editor.codemirror;
                    var output = '';
                    var selectedText = cm.getSelection();

                    output = `
[component]: # ('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
[endcomponent]: #
        `;
                    cm.replaceSelection(output);

                }

                $('.preview-toggle').click(function () {
                    simplemde.togglePreview();
                    $(this).toggleClass('active');
                });



                function viewMarkdownParser(plainText) {

                    $.ajax({
                        method: "POST",
                        url: "{{ route('previewMarkdownView') }}",
                        data: {
                            markdown: plainText,
                            namespace: '{{ addslashes($templateData['namespace']) }}',
                            viewdata: "{{ preg_replace("/[\r\n]/","<br />", serialize($templateData['view_data'])) }}",
                            name: '{{ $name }}'
                        }

                    }).done(function (HtmledTemplate) {
                        let data = HtmledTemplate;
                        console.log(data);
                    });

                    return data;
                }


                $('.view_data_param').click(function () {
                    var cm = simplemde.codemirror;
                    var output = '';
                    var selectedText = cm.getSelection();
                    var param = $(this).attr('param-key');

                    output = `\{\{ $` + param + ` \}\}`;

                    if ($(this).hasClass('is-attribute')) {

                        var output = `\{\{ $` + $(this).attr('param-parent-key') + '->' + param + ` \}\}`;
                    }

                    cm.replaceSelection(output);
                });

                @else

                tinymce.init({
                    selector: "textarea#template_editor",
                    menubar: false,
                    visual: false,
                    height: 560,
                    language_url: '/js/custom/tinymce/lang/fa.js',
                    inline_styles: true,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table directionality emoticons template paste fullpage code legacyoutput"
                    ],
                    content_css: "css/content.css",
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image fullpage | forecolor backcolor emoticons | preview | code",
                    fullpage_default_encoding: "UTF-8",
                    fullpage_default_doctype: "<!DOCTYPE html>",
                    init_instance_callback: function (editor) {



                        setTimeout(function () {
                            editor.execCommand("mceRepaint");
                        }, 2000);
                    }

                });

                simplemde = null;


                $('.view_data_param').click(function () {
                    var param = $(this).attr('param-key');
                    output = `\{\{ $` + param + ` \}\}`;

                    if ($(this).hasClass('is-attribute')) {

                        var output = `\{\{ $` + $(this).attr('param-parent-key') + '->' + param + ` \}\}`;
                    }

                    tinymce.activeEditor.selection.setContent(output);
                });

                $('.preview-toggle').click(function () {
                    tinyMCE.execCommand('mcePreview');
                    return false;
                });

                @endif

                @if (!is_null($templateData['text_template']))

                var plaintextEditor = CodeMirror.fromTextArea(document.getElementById("plain_text"), {
                    lineNumbers: false,
                    mode: 'plain/text',
                    placeholder: "Email Plain Text Version (Optional)",
                });

                @endif

                @endif


            function saveTemplate() {
                Swal.fire({
                    title: 'ذخیره قالب',
                    text: "آیا از ذخیره کردن قالب اطمینان دارید؟",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'بله',
                    cancelButtonText: 'انصراف',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-secondary'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {

                        if (typeof plaintextEditor !== 'undefined' && plaintextEditor.getValue() !== ''){
                            axios.post('{{ route('parseTemplate') }}', {
                                markdown: plaintextEditor.getValue(),
                                viewpath: "{{ base64_encode($templateData['text_view_path']) }}"
                            })
                        }

                        axios.post('{{ route('parseTemplate') }}', {
                            markdown: tinymce.get('template_editor').getContent(),
                            viewpath: "{{ base64_encode($templateData['view_path']) }}"
                        })

                            .then(function (response) {

                                if (response.data.status == 'ok') {



                                    toastr.success('قالب ایمیل بروزرسانی شد')

                                } else {
                                    toastr.error('بروزرسانی قالب ایمیل با خطا مواجه شد')
                                }


                            })
                            .catch(function (error) {
                                alert(error)
                            });
                    }
                })
            }

        </script>
    @endpush

</x-base-layout>



