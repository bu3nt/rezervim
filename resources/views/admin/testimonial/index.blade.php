<x-admin-layout>
    <x-slot:custom_css>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">  
    </x-slot:custom_css>
    <x-slot:title>
        {{ __('testimonial.index.title') }}
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('testimonial.index.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item active">{{ __('testimonial.index.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('testimonial.index.title') }}</h5><span>{{ __('testimonial.index.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <div class="table-responsive">
                        <table class="row-border order-column" id="testimonial-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ __('testimonial.index.table.name') }}</th>
                                <th>{{ __('testimonial.index.table.position') }}</th>
                                <th>{{ __('testimonial.index.table.rating') }}</th>
                                <th>{{ __('testimonial.index.table.status') }}</th>
                                <th>{{ __('testimonial.index.table.action') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>{{ __('testimonial.index.table.name') }}</th>
                                <th>{{ __('testimonial.index.table.position') }}</th>
                                <th>{{ __('testimonial.index.table.rating') }}</th>
                                <th>{{ __('testimonial.index.table.status') }}</th>
                                <th>{{ __('testimonial.index.table.action') }}</th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script>
      $(document).ready(function () {
        var testimonials = $("#testimonial-table").DataTable({
            processing: true,
            serverSide: true,
            debug: true,
            columns: [
                { data: 'name', name: 'name', orderable: true },
                { data: 'position', name: 'position', orderable: true  },
                { data: 'rating', name: 'rating', orderable: true  },
                { data: 'status', name: 'status', orderable: true  },
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },  
            ],
            ajax: "{{ route('admin.testimonial') }}",
        });
        
        $('#testimonial-table').on('click', '.delete-btn', function () {
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
                                testimonials.ajax.reload(null, false);  
                                swal("Dëshmia u fshi me sukses!", {
                                    icon: "success",
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