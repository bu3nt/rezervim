<x-admin-layout>
        <x-slot:custom_css>
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/range-slider.css') }}">
        </x-slot:custom_css>
        <x-slot:title>
        Apriori
        </x-slot>
        <x-slot name="header">
            <div class="row">
                <div class="col-6">
                    <!-- <h3>{{ __('plan.index.title') }}</h3> -->
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Semestri 2</li>
                        <li class="breadcrumb-item">Ekstratimi i Web</li>
                        <li class="breadcrumb-item active">Apriori</li>
                    </ol>
                </div>
            </div>
        </x-slot>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h5>Apriori</h5><span>Analizimi i Datasetit</span>
                    </div>
                    <div class="card-body">
                        <x-response-message></x-response-message>
                        <form class="row g-3 needs-validation custom-input" novalidate="">
                            <div class="col-12">
                                <label class="form-label" for="planName">{{ __('apriori.create.form.support') }}</label>
                                <input id="support" name="support" type="text" required="">
                                <div class="invalid-feedback">{{ __('apriori.create.invalid_feedback') }}{{ __('apriori.create.form.support') }}</div>
                                <div class="valid-feedback">{{ __('apriori.create.valid_feedback') }}</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="planMonthly">{{ __('apriori.create.form.confidence') }}</label>
                                <input id="confidence" name="confidence" type="text" required="">
                                <div class="invalid-feedback">{{ __('apriori.create.invalid_feedback') }}{{ __('apriori.create.form.confidence') }}</div>
                                <div class="valid-feedback">{{ __('apriori.create.valid_feedback') }}</div>
                            </div>
                            <div class="col-12 mt-2">
                                <button class="btn btn-primary" type="submit" id="generate">{{ __('apriori.create.generate') }}</button>
                            </div>
                            <div id="generated-results" class="mt-4"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-slot:custom_js>
            <script src="{{ asset('assets/js/range-slider/ion.rangeSlider.min.js') }}"></script>
            <script>
                $(document).ready(function () {
                    var range_slider_custom = {
                        init: function () {
                            $("#support").ionRangeSlider({
                                skin: "round",
                                min: 0,
                                max: 100,
                                from: 50,
                                postfix: "%",
                            }),
                            $("#confidence").ionRangeSlider({
                                skin: "round",
                                min: 0,
                                max: 100,
                                from: 50,
                                postfix: "%",
                            });
                        },
                    };

                    range_slider_custom.init();

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $('#generate').click(function (e) {
                        e.preventDefault();
                        $('#generated-results').empty();
                        var support = $('#support').val();
                        var confidence = $('#confidence').val();
                        $.ajax({
                            url: "{{ route('admin.lendet.ekstratimi_i_web.generate_frequent_item_sets') }}",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: { 'support' : support, 'confidence' : confidence },
                            success: function (response) {
                                if(response.success) {
                                    $('#generated-results').html(``);
                                } else {
                                    $('#generated-results').html(`
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            `+response.message+`
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        `);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    });
                });
            </script>
        </x-slot:custom_js>
</x-admin-layout>
