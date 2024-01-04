<x-admin-layout>
    <x-slot:title>
    SQL në XML
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
                    <li class="breadcrumb-item active">SQL në XML</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">   
            <div class="card">
                <div class="card-header pb-0 card-no-border ribbon-wrapper-right height-equal alert-light-light">
                    <div class="ribbon ribbon-primary ribbon-clip-right ribbon-right">ALPHA VERSION</div>
                    <h5>SQL to XML</h5><span>Shndërrimi automatik nga SQL në XML dhe XML Schema.</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <form method="POST" action="{{ route('admin.lendet.databaze_avancuar.upload_sql') }}" class="row g-3 needs-validation custom-input" enctype="multipart/form-data" novalidate="">
                        @csrf
                        @method('POST') 
                        <div class="col-12"> 
                            <label class="form-label" for="sql">SQL File</label>
                            <input class="form-control" id="sql" name="sql" type="file" accept=".sql" aria-label="file example" required="">
                            <div class="invalid-feedback"></div>
                        </div>                         
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Ngarko SQL skedarin</button>
                        </div>                             
                    </form>                    
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    </x-slot:custom_js>
</x-admin-layout>