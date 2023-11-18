<x-admin-layout>
    <x-slot:title>
        {{ __('plan.create.title') }}
    </x-slot:title>
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('plan.create.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.plan') }}">{{ __('plan.index.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('plan.create.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">
            <div class="card height-equal">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('plan.create.title') }}</h5><span>{{ __('plan.create.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <form method="POST" action="{{ route('admin.plan.store') }}" class="row g-3 needs-validation custom-input" enctype="multipart/form-data" novalidate="">
                        @csrf
                        @method('POST')              
                        <div class="col-12">
                            <label class="form-label" for="planName">{{ __('plan.create.form.name') }}</label>
                            <input class="form-control" id="planName" name="name" type="text" value="" required="">
                            <div class="invalid-feedback">{{ __('plan.create.invalid_feedback') }}{{ __('plan.create.form.name') }}</div>
                            <div class="valid-feedback">{{ __('plan.create.valid_feedback') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="planMonthly">{{ __('plan.create.form.monthly') }}</label>
                            <input class="form-control" id="planMonthly" name="monthly" type="text" value="" required="">
                            <div class="invalid-feedback">{{ __('plan.create.invalid_feedback') }}{{ __('plan.create.form.monthly') }}</div>
                            <div class="valid-feedback">{{ __('plan.create.valid_feedback') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="planYearly">{{ __('plan.create.form.yearly') }}</label>
                            <input class="form-control" id="planYearly" name="yearly" type="text" value="" required="">
                            <div class="invalid-feedback">{{ __('plan.create.invalid_feedback') }}{{ __('plan.create.form.yearly') }}</div>
                            <div class="valid-feedback">{{ __('plan.create.valid_feedback') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="planPopular">{{ __('plan.create.form.popular') }}</label>
                            <div class="media">
                            <div class="media-body text-end icon-state">
                                <label class="switch">
                                <input id="planPopular" name="popular" type="checkbox" value="1"><span class="switch-state"></span>
                                </label>
                            </div>
                            <label class="col-form-label m-l-10" id="planPopularLabel">{{ __('plan.no') }}</label>
                            </div>
                        </div>                        
                        <div class="col-12">
                            <label class="form-label" for="planStatus">{{ __('plan.create.form.status') }}</label>
                            <div class="media">
                            <div class="media-body text-end icon-state">
                                <label class="switch">
                                <input id="planStatus" name="status" type="checkbox" value="1"><span class="switch-state"></span>
                                </label>
                            </div>
                            <label class="col-form-label m-l-10" id="planStatusLabel">{{ __('plan.inactive') }}</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ __('plan.create.save') }}</button>
                        </div>
                    </form>          
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    <script>
        $(document).ready(function () {
            var active = '{{ __('plan.active') }}';
            var inactive = '{{ __('plan.inactive') }}';
            var yes = '{{ __('plan.yes') }}';
            var no = '{{ __('plan.no') }}';

            $('#planStatus').change(function() {
                if($(this).prop('checked')){
                    $('#planStatusLabel').html(active);
                    $('#planStatusLabel').removeClass('font-danger');
                    $('#planStatusLabel').addClass('font-success');
                }else{
                    $('#planStatusLabel').html(inactive);
                    $('#planStatusLabel').removeClass('font-success');
                    $('#planStatusLabel').addClass('font-danger');
                }                
            });

            $('#planPopular').change(function() {
                if($(this).prop('checked')){
                    $('#planPopularLabel').html(yes);
                    $('#planPopularLabel').removeClass('font-danger');
                    $('#planPopularLabel').addClass('font-success');
                }else{
                    $('#planPopularLabel').html(no);
                    $('#planPopularLabel').removeClass('font-success');
                    $('#planPopularLabel').addClass('font-danger');
                }                
            });            
        });  
    </script> 
    </x-slot:custom_js>   
</x-admin-layout>