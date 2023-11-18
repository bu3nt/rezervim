<x-admin-layout>
    <x-slot:custom_css>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">  
    </x-slot:custom_css>    
    <x-slot:title>
        {{ __('testimonial.show.title') }}
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('testimonial.show.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.testimonial') }}">{{ __('testimonial.index.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('testimonial.show.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">    
            <div class="card height-equal">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('testimonial.show.title') }}</h5><span>{{ __('testimonial.show.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <div class="col-12"> 
                        <div class="form-label">{{ __('testimonial.show.fields.image') }}</div>
                        <div class="avatar mb-4"><img class="img-100 rounded-circle" src="{{ asset('storage/images/testimonial/'.$testimonial->image) }}" alt="{{ $testimonial->name }}"></div>
                    </div>                
                    <div class="col-12">
                        <div class="form-label">{{ __('testimonial.show.fields.name') }}</div>
                        <h6 class="mb-4">{{ $testimonial->name }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="form-label">{{ __('testimonial.show.fields.position') }}</div>
                        <h6 class="mb-4">{{ $testimonial->position }}</h6>
                    </div>
                    <div class="col-12"> 
                        <div class="form-label">{{ __('testimonial.show.fields.message') }}</div>
                        <h6 class="mb-4">{{ $testimonial->message }}</h6>
                    </div>
                    <div class="col-12"> 
                        <div class="form-label">{{ __('testimonial.show.fields.rating') }}</div>
                        <h6 class="mb-4"><?php echo $rating; ?></h6>
                    </div>
                    <div class="col-12">
                        <div class="form-label">{{ __('testimonial.show.fields.status') }}</div>
                        <h6 class="mb-4">{{ $testimonial->status ? __('testimonial.active') : __('testimonial.inactive') }}</h6>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('admin.testimonial.edit', ['testimonial' => $testimonial->id]) }}" class="btn btn-primary">{{ __('testimonial.show.edit') }}</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0)" data-id="{{ $testimonial->id }}" class="btn btn-danger delete-btn pull-right">{{ __('testimonial.show.delete') }}</a>
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
                    var testimonialId = $(this).data('id');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{ route('admin.testimonial.destroy', ['testimonial' => '__id__']) }}'.replace('__id__', testimonialId),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (data) {
                            if(data.success){
                                swal("Dëshmia u fshi me sukses!", {
                                    icon: "success",
                                }).then((result) => {
                                    window.location.href = "{{ route('admin.testimonial') }}";
                                });
                            }
                        },
                        error: function (error) {
                            console.error('Dicka shkoi gabim ne fshirje te deshmive:', error);
                        }
                    });
                }
            });
        });        
      });  
    </script> 
    </x-slot:custom_js>     
</x-admin-layout>