<x-admin-layout>
    <x-slot:title>
        {{ __('navigation.create.title') }}
    </x-slot:title>
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('navigation.create.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.navigation') }}">{{ __('navigation.index.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('navigation.create.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">
            <div class="card height-equal">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('navigation.create.title') }}</h5><span>{{ __('navigation.create.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <form method="POST" action="{{ route('admin.navigation.store') }}" class="row g-3 needs-validation custom-input" enctype="multipart/form-data" novalidate="">
                        @csrf
                        @method('POST')              
                        <div class="col-12">
                            <label class="form-label" for="navigationTitle">{{ __('navigation.create.form.title') }}</label>
                            <input class="form-control" id="navigationTitle" name="title" type="text" value="" required="">
                            <div class="invalid-feedback">{{ __('navigation.create.invalid_feedback') }}{{ __('navigation.create.form.title') }}</div>
                            <div class="valid-feedback">{{ __('navigation.create.valid_feedback') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="navigationUrl">{{ __('navigation.create.form.url') }}</label>
                            <input class="form-control" id="navigationUrl" name="url" type="text" value="" required="">
                            <div class="invalid-feedback">{{ __('navigation.create.invalid_feedback') }}{{ __('navigation.create.form.url') }}</div>
                            <div class="valid-feedback">{{ __('navigation.create.valid_feedback') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="navigationParent">{{ __('navigation.create.form.parent') }}</label>
                            <select class="form-select" name="parent_id" id="navigationParent" aria-label="navigationParent">
                                <option value="">- Zgjedh Prindin -</option>
                                @foreach($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">{{ __('navigation.create.invalid_feedback') }}{{ __('navigation.create.form.parent') }}</div>
                            <div class="valid-feedback">{{ __('navigation.create.valid_feedback') }}</div>
                        </div>                        
                        <div class="col-12">
                            <label class="form-label" for="navigationTarget">{{ __('navigation.create.form.target') }}</label>
                            <select class="form-select" name="target" id="navigationTarget" aria-label="navigationTarget" >
                                <option value="">- Zgjedh Targetin -</option>
                                <option value="_blank">Blank</option>
                                <option value="_parent">Parent</option>
                                <option value="_top">Top</option>
                            </select>
                            <div class="invalid-feedback">{{ __('navigation.create.invalid_feedback') }}{{ __('navigation.create.form.target') }}</div>
                            <div class="valid-feedback">{{ __('navigation.create.valid_feedback') }}</div>
                        </div>                                              
                        <div class="col-12">
                            <label class="form-label" for="navigationStatus">{{ __('navigation.create.form.status') }}</label>
                            <div class="media">
                            <div class="media-body text-end icon-state">
                                <label class="switch">
                                <input id="navigationStatus" name="status" type="checkbox" value="1"><span class="switch-state"></span>
                                </label>
                            </div>
                            <label class="col-form-label m-l-10" id="navigationStatusLabel">{{ __('navigation.inactive') }}</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ __('navigation.create.save') }}</button>
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
            var active = '{{ __('navigation.active') }}';
            var inactive = '{{ __('navigation.inactive') }}';
            var yes = '{{ __('navigation.yes') }}';
            var no = '{{ __('navigation.no') }}';

            $('#navigationStatus').change(function() {
                if($(this).prop('checked')){
                    $('#navigationStatusLabel').html(active);
                    $('#navigationStatusLabel').removeClass('font-danger');
                    $('#navigationStatusLabel').addClass('font-success');
                }else{
                    $('#navigationStatusLabel').html(inactive);
                    $('#navigationStatusLabel').removeClass('font-success');
                    $('#navigationStatusLabel').addClass('font-danger');
                }                
            });           
        });  
    </script> 
    </x-slot:custom_js>   
</x-admin-layout>