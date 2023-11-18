<x-admin-layout>
    <x-slot:custom_css>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">  
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    </x-slot:custom_css>
    <x-slot:title>
        {{ __('slider.index.title') }}
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('slider.index.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item active">{{ __('slider.index.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">   
            <div class="card">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('slider.index.title') }}</h5><span>{{ __('slider.index.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <div class="table-responsive">
                        <table class="row-border order-column" id="slider-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ __('slider.index.table.name') }}</th>
                                <th>{{ __('slider.index.table.caption') }}</th>
                                <th>{{ __('slider.index.table.index') }}</th>
                                <th>{{ __('slider.index.table.status') }}</th>
                                <th>{{ __('slider.index.table.action') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>{{ __('slider.index.table.name') }}</th>
                                <th>{{ __('slider.index.table.caption') }}</th>
                                <th>{{ __('slider.index.table.index') }}</th>
                                <th>{{ __('slider.index.table.status') }}</th>
                                <th>{{ __('slider.index.table.action') }}</th>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script>
      $(document).ready(function () {
        var sliders = $("#slider-table").DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            lengthChange: false,
            ajax: "{{ route('admin.slider') }}",            
            columns: [
                { data: 'name', name: 'name', orderable: false },
                { data: 'caption', name: 'caption', orderable: false },
                { data: 'index', name: 'index', orderable: false },
                { data: 'status', name: 'status', orderable: false },
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },  
            ],
            drawCallback: function () {
                $('#slider-table tbody tr').each(function () {
                    var data = $('#slider-table').DataTable().row(this).data();
                    $(this).attr('data-id', data.id);
                    $(this).addClass('draggable-row');
                });
            }            
        });

        // Make rows draggable
        $("#slider-table tbody").sortable({
            update: function (event, ui) {
                // Get the new order of the rows
                var newOrder = $(this).sortable('toArray', { attribute: 'data-id' });

                // Call the backend API to update the order
                updateOrder(newOrder);
            }
        });

        // Function to update the order in the backend
        function updateOrder(newOrder) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('admin.slider.updateOrder') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: { newOrder: newOrder },
                success: function (response) {
                    sliders.ajax.reload(null, false);
                },
                error: function (error) {
                    console.error('Error updating order', error);
                }
            });
        }
        
        $('#slider-table').on('click', '.delete-btn', function () {
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
                                sliders.ajax.reload(null, false);  
                                swal("Slideri u fshi me sukses!", {
                                    icon: "success",
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