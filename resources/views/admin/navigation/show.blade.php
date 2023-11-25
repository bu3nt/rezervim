<x-admin-layout>
    <x-slot:custom_css>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">  
    </x-slot:custom_css>    
    <x-slot:title>
        {{ __('navigation.show.title') }}
    </x-slot> 
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('navigation.show.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.navigation') }}">{{ __('navigation.index.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('navigation.show.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">    
            <div class="card height-equal">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('navigation.show.title') }}</h5><span>{{ __('navigation.show.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>             
                    <div class="col-12">
                        <div class="form-label">{{ __('navigation.show.fields.title') }}</div>
                        <h6 class="mb-4">{{ $navigation->title }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="form-label">{{ __('navigation.show.fields.url') }}</div>
                        <h6 class="mb-4">{{ $navigation->url }}</h6>
                    </div>
                    @if($navigation->parent)
                    <div class="col-12">
                        <div class="form-label">{{ __('navigation.show.fields.parent') }}</div>
                        <h6 class="mb-4">{{ $navigation->parent ? $navigation->parent->title : '' }}</h6>
                    </div>
                    @endif
                    @if($navigation->target)
                    <div class="col-12">
                        <div class="form-label">{{ __('navigation.show.fields.target') }}</div>
                        <h6 class="mb-4">{{ $navigation->target }}</h6>
                    </div>
                    @endif                                                         
                    <div class="col-12"> 
                        <div class="form-label">{{ __('navigation.show.fields.index') }}</div>
                        <h6 class="mb-4">{{ $navigation->index }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="form-label">{{ __('navigation.show.fields.status') }}</div>
                        <h6 class="mb-4">{{ $navigation->status ? __('navigation.active') : __('navigation.inactive') }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('admin.navigation.edit', ['navigation' => $navigation->id]) }}" class="btn btn-primary">{{ __('navigation.show.edit') }}</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0)" data-id="{{ $navigation->id }}" class="btn btn-danger delete-btn pull-right">{{ __('navigation.show.delete') }}</a>
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
                    var navigationId = $(this).data('id');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{ route('admin.navigation.destroy', ['navigation' => '__id__']) }}'.replace('__id__', navigationId),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (data) {
                            if(data.success){
                                swal("Navigimi u fshi me sukses!", {
                                    icon: "success",
                                }).then((result) => {
                                    window.location.href = "{{ route('admin.navigation') }}";
                                });
                            }
                        },
                        error: function (error) {
                            console.error('Diçka shkoi gabim ne fshirje te navigimit:', error);
                        }
                    });
                }
            });
        });        
      });  
    </script> 
    </x-slot:custom_js>     
</x-admin-layout>