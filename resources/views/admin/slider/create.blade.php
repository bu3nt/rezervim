<x-admin-layout>
    <x-slot:title>
        {{ __('slider.create.title') }}
    </x-slot:title>
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('slider.create.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.slider') }}">{{ __('slider.index.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('slider.create.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">
            <div class="card height-equal">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('slider.create.title') }}</h5><span>{{ __('slider.create.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <form method="POST" action="{{ route('admin.slider.store') }}" class="row g-3 needs-validation custom-input" enctype="multipart/form-data" novalidate="">
                        @csrf
                        @method('POST')
                        <div class="col-12"> 
                            <label class="form-label" for="sliderImage">{{ __('slider.create.form.image') }}</label>
                            <input class="form-control" id="sliderImage" name="image" type="file" accept="image/png, image/jpeg" aria-label="file example">
                            <div class="invalid-feedback">{{ __('slider.create.invalid_feedback') }}{{ __('slider.create.form.image') }}</div>
                        </div>                
                        <div class="col-12">
                            <label class="form-label" for="sliderName">{{ __('slider.create.form.name') }}</label>
                            <input class="form-control" id="sliderName" name="name" type="text" value="" required="">
                            <div class="invalid-feedback">{{ __('slider.create.invalid_feedback') }}{{ __('slider.create.form.name') }}</div>
                            <div class="valid-feedback">{{ __('slider.create.valid_feedback') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="sliderCaption">{{ __('slider.create.form.caption') }}</label>
                            <input class="form-control" id="sliderCaption" name="caption" type="text" value="" required="">
                            <div class="invalid-feedback">{{ __('slider.create.invalid_feedback') }}{{ __('slider.create.form.caption') }}</div>
                            <div class="valid-feedback">{{ __('slider.create.valid_feedback') }}</div>
                        </div>
                        <div class="col-12"> 
                            <label class="form-label" for="sliderDescription">{{ __('slider.create.form.description') }}</label>
                            <textarea class="form-control" id="sliderDescription" rows="4" name="description" required=""></textarea>
                            <div class="invalid-feedback">{{ __('slider.create.invalid_feedback') }}{{ __('slider.create.form.description') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="sliderStatus">{{ __('slider.create.form.status') }}</label>
                            <div class="media">
                            <div class="media-body text-end icon-state">
                                <label class="switch">
                                <input id="sliderStatus" name="status" type="checkbox" value="1"><span class="switch-state"></span>
                                </label>
                            </div>
                            <label class="col-form-label m-l-10" id="sliderStatusLabel">{{ __('slider.inactive') }}</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ __('slider.create.save') }}</button>
                        </div>
                    </form>          
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
    <script>
        $(document).ready(function () {
            var active = '{{ __('slider.active') }}';
            var inactive = '{{ __('slider.inactive') }}';
          
            $('#sliderStatus').change(function() {
                if($(this).prop('checked')){
                    $('#sliderStatusLabel').html(active);
                    $('#sliderStatusLabel').removeClass('font-danger');
                    $('#sliderStatusLabel').addClass('font-success');
                }else{
                    $('#sliderStatusLabel').html(inactive);
                    $('#sliderStatusLabel').removeClass('font-success');
                    $('#sliderStatusLabel').addClass('font-danger');
                }                
            });
        });  
    </script> 
    </x-slot:custom_js>   
</x-admin-layout>