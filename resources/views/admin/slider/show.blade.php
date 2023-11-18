<x-admin-layout>
    <x-slot:custom_css>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">  
    </x-slot:custom_css>    
    <x-slot:title>
        {{ __('slider.show.title') }}
    </x-slot> 
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('slider.show.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.slider') }}">{{ __('slider.index.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('slider.show.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">    
            <div class="card height-equal">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('slider.show.title') }}</h5><span>{{ __('slider.show.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <div class="col-12"> 
                        <div class="form-label">{{ __('slider.show.fields.image') }}</div>
                        <div class="mb-4"><img style="width:100%" src="{{ asset('storage/images/slider/'.$slider->image) }}" alt="{{ $slider->name }}"></div>
                    </div>                
                    <div class="col-12">
                        <div class="form-label">{{ __('slider.show.fields.name') }}</div>
                        <h6 class="mb-4">{{ $slider->name }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="form-label">{{ __('slider.show.fields.caption') }}</div>
                        <h6 class="mb-4">{{ $slider->caption }}</h6>
                    </div>
                    <div class="col-12"> 
                        <div class="form-label">{{ __('slider.show.fields.description') }}</div>
                        <h6 class="mb-4">{{ $slider->description }}</h6>
                    </div>
                    <div class="col-12"> 
                        <div class="form-label">{{ __('slider.show.fields.index') }}</div>
                        <h6 class="mb-4">{{ $slider->index }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="form-label">{{ __('slider.show.fields.status') }}</div>
                        <h6 class="mb-4">{{ $slider->status ? __('slider.active') : __('slider.inactive') }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('admin.slider.edit', ['slider' => $slider->id]) }}" class="btn btn-primary">{{ __('slider.show.edit') }}</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0)" data-id="{{ $slider->id }}" class="btn btn-danger delete-btn pull-right">{{ __('slider.show.delete') }}</a>
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
                    var sliderId = $(this).data('id');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{ route('admin.slider.destroy', ['slider' => '__id__']) }}'.replace('__id__', sliderId),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (data) {
                            if(data.success){
                                swal("Slideri u fshi me sukses!", {
                                    icon: "success",
                                }).then((result) => {
                                    window.location.href = "{{ route('admin.slider') }}";
                                });
                            }
                        },
                        error: function (error) {
                            console.error('Dicka shkoi gabim ne fshirje te sliderit:', error);
                        }
                    });
                }
            });
        });        
      });  
    </script> 
    </x-slot:custom_js>     
</x-admin-layout>