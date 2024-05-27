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
                        </form>
                        <div id="generated-results" class="mt-4"></div>
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
                                    var fis_res = `<div class="horizontal-list-wrapper dark-list">`;
                                    var fis = Object.values(response.frequent_items_sets);
                                    var c_fis = fis.length;
                                    var item_sets = [];
                                    if(c_fis > 0) {

                                        $(fis).each(function (i, set) {
                                            var c_set = set.length;
                                            if(c_set > 0) {
                                                $(set).each(function (j, item_set) {
                                                    var c_item_set = item_set.length;
                                                    if (c_item_set > 1) {
                                                        item_sets.push(item_set)
                                                    } else {
                                                        fis_res += `<ul class="fw-bold list-group list-group-horizontal-sm pb-2">`;

                                                        fis_res += `<li class="list-group-item border-left-primary">` + item_set[0] + `</li>`;

                                                        fis_res += `</ul>`;

                                                    }
                                                });
                                            }
                                        });

                                    }

                                    var c_is = item_sets.length;
                                    if(c_is > 0) {
                                        var set_color = 'secondary';
                                        $(item_sets).each(function (i, i_set) {
                                            fis_res += `<ul class="fw-bold list-group list-group-horizontal-sm pb-2">`;
                                            var c_i_set = i_set.length;
                                            if(c_i_set > 2) {
                                                set_color = 'warning';
                                            }
                                            $(i_set).each(function (j, i_set_set) {
                                                var primary = '';
                                                if (j === 0) {
                                                    primary = ' border-left-' + set_color;
                                                }

                                                fis_res += `<li class="list-group-item`+primary+`">` + i_set_set + `</li>`;
                                            });

                                            fis_res += `</ul>`;
                                        });
                                    }

                                    fis_res += `</div>`;
                                    $('#generated-results').html(fis_res);
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
