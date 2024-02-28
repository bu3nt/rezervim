<x-admin-layout>
        <x-slot:title>
        Apriori
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
                        <li class="breadcrumb-item">Semestri 2</li>
                        <li class="breadcrumb-item">Ekstratimi i Web</li>
                        <li class="breadcrumb-item active">Apriori</li>
                    </ol>
                </div>
            </div>
        </x-slot>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h5>Apriori</h5><span>Analizimi i Datasetit</span>
                    </div>
                    <div class="card-body">
                        <x-response-message></x-response-message>

                    </div>
                </div>
            </div>
        </div>
        <x-slot:custom_js>
            <script>

            </script>
        </x-slot:custom_js>
</x-admin-layout>
