<x-admin-layout>
    <x-slot:title>
    Konvertimi i SQL në XML
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('plan.index.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item">Semestri 1</li>
                    <li class="breadcrumb-item">Databaze Avancuar</li>
                    <li class="breadcrumb-item active">Konvertimi i SQL në XML</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12 file-content">   
            <div class="card">
                <div class="card-header pb-0 card-no-border ribbon-wrapper-right height-equal alert-light-light">
                    <div class="ribbon ribbon-primary ribbon-clip-right ribbon-right">ALPHA VERSION</div>
                    <h5>Konvertimi i SQL në XML</h5><span><a href="{{ route('admin.lendet.databaze_avancuar.sql_to_xml') }}">Kthehu</a></span>
                </div>
                <div class="card-body file-manager">
                    <x-response-message></x-response-message>
                    <style>
                        .file-content .files .file-box {
                            width: calc(35% - 5px) !important;
                        }
                        /* Style the multilevel list */
                        ul {
                            padding: 0;
                            list-style: none;
                            margin-bottom: 5px;
                        }

                        li {
                            padding: 3px;
                        }

                        /* Add additional styling for nested lists */
                        ul ul {
                            margin-left: 20px;
                        }
                        table {
                            border-collapse: collapse;
                            width: 100%;
                            margin-bottom: 20px;
                        }

                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }

                        th {
                            background-color: #f2f2f2;
                        }                     
                    </style>
                    <div class="row">    
                        <div class="col-md-4 col-xs-12">
                            <h5 class="mb-2">Tabelat nga DB (<span class="txt-primary">{{ $databaseName }}</span>)</h5>
                            <div class="accordion dark-accordion" id="simpleaccordion">
                                @foreach($entities as $key => $entity)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $key }}">
                                    <button class="accordion-button accordion-light-primary txt-primary collapsed active" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="{{ $key == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $key }}">{{ $entity->name }}<i class="svg-color" data-feather="chevron-down"></i></button>
                                    </h2>
                                    <div class="accordion-collapse collapse{{ $key == 0 ? ' show' : '' }}" id="collapse{{ $key }}" aria-labelledby="heading{{ $key }}" data-bs-parent="#simpleaccordion">
                                        <div class="accordion-body">
                                            <div class="figure d-block dark-blockquote">
                                            <blockquote class="blockquote light-card mb-2">
                                                <p class="mb-0 txt-dark">Atributet</p>
                                            </blockquote>
                                            </div>

                                            <table>
                                                <thead>
                                                    <tr><th>Atributi</th><th>Tipi</th></tr>
                                                </thead>
                                                <tbody>
                                            @foreach($entity->columns as $atributi)
                                                <tr><td>{{ $atributi->column_name }}</td><td>{{ $atributi->data_type }}</td></tr>
                                            @endforeach
                                                </tbody>
                                            </table>                                            

                                            @if(!empty($entity->foreignKeys))
                                            <div class="figure d-block dark-blockquote">
                                            <blockquote class="blockquote light-card mb-2">
                                                <p class="mb-0 txt-dark">Çelësat e huaj</p>
                                            </blockquote>
                                            </div>
                                            <ul>
                                            @foreach($entity->foreignKeys as $key2 => $foreignKey)
                                                <li>
                                                    <h6><strong>{{ $foreignKey->column_name }}</strong></h6>
                                                    <p>(Referencon në tabelën <span class="txt-primary">{{ $foreignKey->referenced_table_name }}</span> tek qelësi primar <span class="txt-secondary">{{ $foreignKey->referenced_column_name }}</span>)</p>
                                                    <table>
                                                        <thead>
                                                            <tr><th>Kolonat e tabelës referencuese <span class="txt-primary">{{ $foreignKey->referenced_table_name }}</span></th></tr>
                                                        </thead>
                                                        <tbody>
                                                    @foreach($foreignKey->referenced_table_columns as $referenced_table_column)
                                                        <tr><td>{{ $referenced_table_column }}</td></tr>
                                                    @endforeach
                                                        </tbody>
                                                    </table>
                                                </li>
                                            @endforeach
                                            </ul>
                                            @else
                                            <p>Nuk ka çelësa të huaj!</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>                            
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <h5 class="mb-2">Konvertimi në XML</h5>
                            <x-response-message></x-response-message>
                            <form class="row g-3 needs-validation custom-input" novalidate="">
                            <input type="hidden" id="databaseName" value="{{ $databaseName }}" />
                            <div class="col-12"> 
                                <label class="form-label" for="sql">SQL pyetësori</label>
                                <textarea class="form-control" id="sql" rows="10" name="sql" required="required"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 mt-2"> 
                                <label class="form-label" for="rrenja">Rrënja e XML dokumentit</label>
                                <input class="form-control" id="rrenja" name="rrenja" required="required">
                                <div class="invalid-feedback"></div>
                            </div>                             
                            <div class="col-12 mt-2">
                                <button class="btn btn-primary" type="submit" id="konverto">Konverto në XML</button>
                            </div>
                            </form>
                            <div id="generated-files" class="mt-4"></div>                            
                        </div>
                    </div>               
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    <script>
      $(document).ready(function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#konverto').click(function (e) {   
            e.preventDefault();
            $('#generated-files').empty();
            var sql = $('#sql').val();
            var databaseName = $('#databaseName').val();
            var rrenja = $('#rrenja').val();
            $.ajax({
                url: "{{ route('admin.lendet.databaze_avancuar.generate_xml') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: { 'sql': sql, 'databaseName': databaseName, 'rrenja':rrenja },
                success: function (response) {
                    if(response.success) {
                        $('#generated-files').html(`
                        <ul class="files">
                            <li class="file-box">
                                <a href="{{ asset('storage/`+response.xml.url+`') }}" target="_blank"><div class="file-top"><i class="fa fa-file-code-o txt-primary"></i></div></a>
                                <div class="file-bottom mt-2">
                                    <h5 class="mb-1">XML</h5>
                                    <p class="mb-1"><b>Emri : </b>`+response.xml.fileName+`</p>
                                    <p class="mb-1"><b>Madhësia : </b>`+response.xml.fileSize+` KB</p>
                                    <p><b>Gjeneruar : </b>`+response.xml.timeAgo+`</p>
                                </div>
                            </li>
                            <li class="file-box">
                                <a href="{{ asset('storage/`+response.xsd.url+`') }}" target="_blank"><div class="file-top"><i class="fa fa-file-code-o txt-secondary"></i></div></a>
                                <div class="file-bottom mt-2">
                                    <h5 class="mb-1">XSD</h5>
                                    <p class="mb-1"><b>Emri : </b>`+response.xsd.fileName+`</p>
                                    <p class="mb-1"><b>Madhësia : </b>`+response.xsd.fileSize+` KB</p>
                                    <p><b>Gjeneruar : </b>`+response.xsd.timeAgo+`</p>
                                </div>
                            </li>
                        </ul>                    
                        `);
                    } else {
                        $('#generated-files').html(`
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            `+response.message+`
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        `);
                    }   
                },
                error: function (error) {
                    console.log(error);
                }
            });            
        });     
      });
    </script>        
    </x-slot:custom_js>
</x-admin-layout>