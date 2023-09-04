<div wire:ignore.self class="col-xxl-4" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div xmlns:wire="http://www.w3.org/1999/xhtml">
        <!--begin::Forms widget 1-->
        <div class="card ">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">
                    <h2 class="text-dark fw-bold">دریافت کانفیگ V2Ray</h2>
                </div>
                <div class="card-toolbar">
                    @if($this->user->hasActiveSubscription())
                        <button wire:ignore.self onclick="copyToClipboard('subscription_link')" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="دریافت لینک Subscription"
                                class="btn btn-sm btn-icon btn-secondary btn-active-light-success mx-3">
                            <i class="fa fa-link fs-4"></i>
                            <span class="d-none" id="subscription_link">{{$subscriptionLink}}</span>
                        </button>
                    @endif
                    <button wire:ignore.self id="change_connection_id_button" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="غیر فعال سازی کانکشن های قبلی"
                            class="btn btn-sm btn-icon btn-secondary btn-active-light-warning">
                        <i class="fa fa-refresh fs-4"></i>
                    </button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body" wire:target="getServers,getOperators"
                 wire:loading.class="overlay overlay-block">
                <!--begin::Tab Content-->
                <div class="tab-content">
                    <!--begin::Tap pane-->
                    <div wire:loading.class="overlay-wrapper" wire:target="getServers,getOperators">
                        <!--begin::Input group-->
                        <div wire:ignore class="form-floating border border-gray-300 rounded mb-7">
                            <select class="form-select form-select-transparent select2-hidden-accessible"
                                    id="select_country">
                                <option value="" selected>انتخاب کشور</option>
                                @foreach(\App\Models\Country::all()->filter(function (\App\Models\Country $country) use($user){
                                        return $country->servers()->where('layer_id',$user->layer_id)->where('available',true)->where('active',true)->count() > 0;}) as $value)
                                    @php $count = $value->servers()
                                ->where('available', true)
                                ->where('active', true)->where('layer_id', $user->layer_id)->get()->count(); @endphp
                                    @if($count)
                                        <option data-flag="{{asset('media/'.$value->flag)}}"
                                                data-servers-count="{{convertNumbers($count)}}"
                                                value="{{ $value->id }}">{{ $value->slug }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="select_country">انتخاب کشور</label>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div wire:ignore class="form-floating border border-gray-300 rounded mb-7">
                            <select disabled class="form-select form-select-transparent select2-hidden-accessible"
                                    id="select_server">
                                <option value="" selected>در انتطار انتخاب کشور</option>
                            </select>
                            <label for="select_server">انتخاب سرور</label>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div wire:ignore class="form-floating border border-gray-300 rounded mb-7">
                            <select disabled class="form-select form-select-transparent select2-hidden-accessible"
                                    id="select_operator">
                                <option value="" selected>در انتطار انتخاب سرور</option>
                            </select>
                            <label for="select_operator">انتخاب اپراتور</label>
                        </div>
                        <!--end::Input group-->

                        <!--end::Row-->
                        <!--begin::Action-->
                        <div class="d-flex align-items-end">
                            <button {{$server_id == '' ? 'disabled' : ''}} wire:target="getConnection"
                                    id="get_connection" wire:click.prevent="getConnection()"
                                    wire:loading.attr="disabled"
                                    class="btn btn-primary fs-3 w-100">
                                <!--begin::Indicator label-->
                                <span class="indicator-label" wire:target="getConnection"
                                      wire:loading.class="d-none">دریافت کانکشن</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="d-none" wire:target="getConnection" wire:loading.class.remove="d-none">
															<span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"
                                                                wire:target="getConnection"
                                                                wire:loading.class.remove="d-none"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Action-->

                        <div class="overlay-layer bg-transparent w-100 d-none z-index-3"
                             style="backdrop-filter: blur(4px);"
                             wire:loading.class.remove="d-none" wire:target="getServers,getOperators">
                            <div class="spinner-border text-primary" role="status">
                            </div>
                        </div>

                    </div>
                    <!--end::Tap pane-->
                </div>
                <!--end::Tab Content-->
            </div>
            <!--end: Card Body-->
        </div>
        <!--end::Forms widget 1-->
    </div>
    @push('scripts')
        <script>
            var optionFormat = function (item) {
                if (!item.id) {
                    return item.text;
                }
                var span = document.createElement('span');
                var imgUrl = item.element.getAttribute('data-flag');
                var serversCount = item.element.getAttribute('data-servers-count');
                var template = '';

                template += '<img src="' + imgUrl + '" class="rounded-circle h-20px me-2" alt="image"/>';
                template += item.text;
                template += '<span class="badge badge-pill badge-light-primary mx-2">' + serversCount + '</span>';

                span.innerHTML = template;

                return $(span);
            }

            const e2p = s => s.replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d])

            var serverFormat = function (item) {
                if (!item.id) {
                    return item.text;
                }
                var span = document.createElement('span');
                var load = item.element.getAttribute('data-load');
                var template = '';
                var load_color = '';
                if (load < 30) {
                    load_color = 'success';
                } else if (load >= 30 && load < 60) {
                    load_color = 'primary';
                } else if (load >= 60 && load < 80) {
                    load_color = 'warning';
                } else {
                    load_color = 'danger';
                }
                template += item.text;
                load = e2p(load);
                template += '<span class="badge badge-pill badge-light-' + load_color + ' mx-2">' + load + '%</span>';

                span.innerHTML = template;

                return $(span);
            }

            document.addEventListener('livewire:load', function () {
                // Format options
                // Init Select2 --- more info: https://select2.org/
                $('#select_country').select2({
                    templateSelection: optionFormat,
                    templateResult: optionFormat,
                    placeholder: "انتخاب کشور",
                }).on('change', function () {
                @this.getServers($(this).val());
                    $('#select_server').prop('disabled', false);
                });

                $('#select_server').select2({
                    placeholder: "در انتظار انتخاب کشور",
                    templateSelection: serverFormat,
                    templateResult: serverFormat,
                    // disabled: true,
                }).on('change', function () {
                @this.getOperators($(this).val());
                    $('#select_operator').prop('disabled', false);
                });

                $('#select_operator').select2({
                    placeholder: "در انتطار انتخاب سرور",
                    minimumResultsForSearch: -1
                    // disabled: true,
                }).on('change', function () {
                @this.set('operator', $(this).val());
                });

                document.addEventListener('appendServers', function (data) {
                    var servers = data.detail.servers;
                    console.log(servers);
                    $("#select_server").empty();
                    // $('#select_server').append(new Option('انتخاب سرور', null, true));
                    // $('#select_server').val(null).trigger('change');
                    if (servers.length > 0) {
                        servers.forEach(function (server, index) {
                            // $('#select_server').append(new Option(server.name, server.id, index === 0))
                            $('#select_server').append("<option value=" + server.id + " data-load=" + server.connections_load + ">" + server.name + "</option>")
                        });
                        $('#select_server').trigger('change');
                    } else {
                        toastr.error('سروری در کشور انتخاب شده شما، در دسترس نیست');
                    }
                })


                document.addEventListener('appendOperators', function (data) {
                    var operators = data.detail.operators;
                    $("#select_operator").empty();
                    // $('#select_server').append(new Option('انتخاب سرور', null, true));
                    // $('#select_server').val(null).trigger('change');
                    if (operators.length > 0) {
                        operators.forEach(function (operator, index) {
                            $('#select_operator').append(new Option(operator.text, operator.type, index === 0))
                        });
                        $('#select_operator').trigger('change');
                    } else {
                        toastr.error('متاسفانه امکان اتصال به این سرور وجود ندارد، لطفا سرور دیگری را انتخاب نمایید');
                    }
                })

            });
        </script>
        <script>
            var copyConnection;
            document.addEventListener('show_connection', function (event) {
                var connectionQrCodeDark = event.detail.connectionQrCodeDark;
                var connectionQrCodeLight = event.detail.connectionQrCodeLight;
                $('#qrcodeImage').attr('src', (document.documentElement.getAttribute('data-theme') === 'dark') ? connectionQrCodeDark : connectionQrCodeLight);
                $('#showConnectionModal').modal('toggle');
                var link = event.detail.link;
                copyConnection = () => {
                    navigator.clipboard.writeText(link);
                    toastr.info('کانکشن کپی شد');
                }
                // Swal.fire({
                //     html: '<img class="mb-3" src="' + ((document.documentElement.getAttribute('data-theme') === 'dark') ? connectionQrCodeDark : connectionQrCodeLight) + '"/>',
                //     showConfirmButton: false,
                //     customClass: 'swal-wide',
                //     heightAuto : true
                // })
            });

            $('#change_connection_id_button').on('click', function () {
                $('#change_connection_id').modal('toggle');
            })
        </script>

    @endpush
</div>
