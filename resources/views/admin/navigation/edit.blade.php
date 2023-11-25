<x-admin-layout>
    <x-slot:title>
        {{ __('navigation.edit.title') }}
    </x-slot:title>
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('navigation.edit.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.navigation') }}">{{ __('navigation.index.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('navigation.edit.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">
            <div class="card height-equal">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('navigation.edit.title') }}</h5><span>{{ __('navigation.edit.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <form method="POST" action="{{ route('admin.navigation.update', $navigation) }}" class="row g-3 needs-validation custom-input" enctype="multipart/form-data" novalidate="">
                        @csrf
                        @method('PUT')              
                        <div class="col-12">
                            <label class="form-label" for="navigationTitle">{{ __('navigation.edit.form.title') }}</label>
                            <input class="form-control" id="navigationTitle" name="title" type="text" value="{{ $navigation->title }}" required="">
                            <div class="invalid-feedback">{{ __('navigation.edit.invalid_feedback') }}{{ __('navigation.edit.form.title') }}</div>
                            <div class="valid-feedback">{{ __('navigation.edit.valid_feedback') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="navigationUrl">{{ __('navigation.edit.form.url') }}</label>
                            <input class="form-control" id="navigationUrl" name="url" type="text" value="{{ $navigation->url }}" required="">
                            <div class="invalid-feedback">{{ __('navigation.edit.invalid_feedback') }}{{ __('navigation.edit.form.url') }}</div>
                            <div class="valid-feedback">{{ __('navigation.edit.valid_feedback') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="navigationParent">{{ __('navigation.edit.form.parent') }}</label>
                            <select class="form-select" name="parent_id" id="navigationParent" aria-label="navigationParent">
                                <option value="">- Zgjedh Prindin -</option>
                                @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ ($parent->id == $navigation->parent_id ? 'selected' : '') }}>{{ $parent->title }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">{{ __('navigation.edit.invalid_feedback') }}{{ __('navigation.edit.form.parent') }}</div>
                            <div class="valid-feedback">{{ __('navigation.edit.valid_feedback') }}</div>
                        </div>                        
                        <div class="col-12">
                            <label class="form-label" for="navigationTarget">{{ __('navigation.edit.form.target') }}</label>
                            <select class="form-select" name="target" id="navigationTarget" aria-label="navigationTarget" >
                                <option value="">- Zgjedh Targetin -</option>
                                <option value="_blank" {{ ($navigation->target == '_blank' ? 'selected' : '') }}>Blank</option>
                                <option value="_parent" {{ ($navigation->target == '_parent' ? 'selected' : '') }}>Parent</option>
                                <option value="_top" {{ ($navigation->target == '_top' ? 'selected' : '') }}>Top</option>
                            </select>
                            <div class="invalid-feedback">{{ __('navigation.edit.invalid_feedback') }}{{ __('navigation.edit.form.target') }}</div>
                            <div class="valid-feedback">{{ __('navigation.edit.valid_feedback') }}</div>
                        </div>                        
                        <div class="col-12">
                            <label class="form-label" for="navigationStatus">{{ __('navigation.edit.form.status') }}</label>
                            <div class="media">
                            <div class="media-body text-end icon-state">
                                <label class="switch">
                                <input id="navigationStatus" name="status" type="checkbox" value="1" {{ $navigation->status ? 'checked' : '' }}><span class="switch-state"></span>
                                </label>
                            </div>
                            <label class="col-form-label m-l-10" id="navigationStatusLabel">{{ $navigation->status ? __('navigation.active') : __('navigation.inactive') }}</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ __('navigation.edit.save_changes') }}</button>
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
            var navigationStatus = {{ $navigation->status }};
            var active = '{{ __('navigation.active') }}';
            var inactive = '{{ __('navigation.inactive') }}';
            var yes = '{{ __('navigation.yes') }}';
            var no = '{{ __('navigation.no') }}';

            if(navigationStatus){
                $('#navigationStatusLabel').addClass('font-success'); 
            }else{
                $('#navigationStatusLabel').addClass('font-danger');
            }
            
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