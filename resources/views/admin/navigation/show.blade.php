<x-admin-layout>
    <x-slot:custom_css>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">  
    </x-slot:custom_css>    
    <x-slot:title>
        {{ __('plan.show.title') }}
    </x-slot> 
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('plan.show.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.plan') }}">{{ __('plan.index.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('plan.show.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">    
            <div class="card height-equal">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('plan.show.title') }}</h5><span>{{ __('plan.show.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>             
                    <div class="col-12">
                        <div class="form-label">{{ __('plan.show.fields.name') }}</div>
                        <h6 class="mb-4">{{ $plan->name }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="form-label">{{ __('plan.show.fields.monthly') }}</div>
                        <h6 class="mb-4">{{ __('currency', ['value' => $plan->monthly]) }}</h6>
                    </div>
                    <div class="col-12"> 
                        <div class="form-label">{{ __('plan.show.fields.yearly') }}</div>
                        <h6 class="mb-4">{{ __('currency', ['value' => $plan->yearly]) }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="form-label">{{ __('plan.show.fields.popular') }}</div>
                        <h6 class="mb-4">{{ $plan->popular ? __('plan.yes') : __('plan.no') }}</h6>
                    </div>                    
                    <div class="col-12"> 
                        <div class="form-label">{{ __('plan.show.fields.index') }}</div>
                        <h6 class="mb-4">{{ $plan->index }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="form-label">{{ __('plan.show.fields.status') }}</div>
                        <h6 class="mb-4">{{ $plan->status ? __('plan.active') : __('plan.inactive') }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('admin.plan.edit', ['plan' => $plan->id]) }}" class="btn btn-primary">{{ __('plan.show.edit') }}</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0)" data-id="{{ $plan->id }}" class="btn btn-danger delete-btn pull-right">{{ __('plan.show.delete') }}</a>
                            </div> 
                        </div>
                    </div>           
                </div>
            </div>
        </div>
    </div> 
    <x-slot:custom_js>
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>        
    <script>
      $(document).ready(function () {      
        $(document).on('click', '.delete-btn', function () {
            swal({
                title: "A jeni të sigurt?",
                text: "Nëse e fshini, nuk mund ta ktheni mbrapa këtë veprim!",
                icon: "warning",
                buttons: ["Anulo", "Po"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var planId = $(this).data('id');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{ route('admin.plan.destroy', ['plan' => '__id__']) }}'.replace('__id__', planId),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (data) {
                            if(data.success){
                                swal("plani u fshi me sukses!", {
                                    icon: "success",
                                }).then((result) => {
                                    window.location.href = "{{ route('admin.plan') }}";
                                });
                            }
                        },
                        error: function (error) {
                            console.error('Dicka shkoi gabim ne fshirje te planit:', error);
                        }
                    });
                }
            });
        });        
      });  
    </script> 
    </x-slot:custom_js>     
</x-admin-layout>