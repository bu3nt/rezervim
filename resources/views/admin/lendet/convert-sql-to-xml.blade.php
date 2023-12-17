<x-admin-layout>
    <x-slot:title>
    Converted SQL to XML
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
                    <li class="breadcrumb-item active">Converted SQL to XML</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12 file-content">   
            <div class="card">
                <div class="card-header pb-0 card-no-border">
                    <h5>Converted SQL to XML</h5><span><a href="{{ route('admin.lendet.databaze_avancuar.pgsql_to_xml') }}">Go Back</a></span>
                </div>
                <div class="card-body file-manager">
                    <x-response-message></x-response-message>
                    <style>
                        .file-content .files .file-box {
                            width: calc(35% - 5px) !important;
                        }
                    </style>
                    <div class="row">    
                        <div class="col-md-3 col-xs-12">
                            <div class="nav flex-column nav-pills nav-primary" id="xml-tables-tab" role="tablist" aria-orientation="vertical">
                            @foreach($entities as $key => $entity)
                                <a class="nav-link{{ $key == 0 ? ' active' : '' }}" id="xml-tables-{{ $key }}-tab" data-bs-toggle="pill" href="#xml-tables-{{ $key }}" role="tab" aria-controls="xml-tables-{{ $key }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ $entity->name }}</a>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-md-9 col-xs-12">
                            <div class="tab-content" id="xml-tables-tabContent">
                            @foreach($entities as $key => $entity)
                                <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}" id="xml-tables-{{ $key }}" role="tabpanel" aria-labelledby="xml-tables-{{ $key }}-tab">
                                <ul class="files">
                                    <li class="file-box">
                                        <a href="{{ asset('storage/'.$entity->xml['url']) }}" target="_blank"><div class="file-top"><i class="fa fa-file-code-o txt-primary"></i></div></a>
                                        <div class="file-bottom mt-2">
                                            <h5 class="mb-1">XML</h5>
                                            <p class="mb-1"><b>Emri : </b>{{ $entity->xml['fileName'] }}</p>
                                            <p class="mb-1"><b>Madhësia : </b>{{ $entity->xml['fileSize'] }} KB</p>
                                            <p><b>Gjeneruar : </b>{{ $entity->xml['timeAgo'] }}</p>
                                        </div>
                                    </li>
                                    <li class="file-box">
                                        <a href="{{ asset('storage/'.$entity->xsd['url']) }}" target="_blank"><div class="file-top"><i class="fa fa-file-code-o txt-secondary"></i></div></a>
                                        <div class="file-bottom mt-2">
                                            <h5 class="mb-1">XML Schema</h5>
                                            <p class="mb-1"><b>Emri : </b>{{ $entity->xml['fileName'] }}</p>
                                            <p class="mb-1"><b>Madhësia : </b>{{ $entity->xsd['fileSize'] }} KB</p>
                                            <p><b>Gjeneruar : </b>{{ $entity->xsd['timeAgo'] }}</p>
                                        </div>
                                    </li>
                                </ul>
                                </div>
                            @endforeach                  
                            </div>
                        </div>
                    </div>               
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    </x-slot:custom_js>
</x-admin-layout>