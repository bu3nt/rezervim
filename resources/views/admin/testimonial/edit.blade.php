<x-admin-layout>
    <x-slot:custom_css>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/rating.css') }}">
    </x-slot:custom_css>
    <x-slot:title>
        {{ __('testimonial.edit.title') }}
    </x-slot:title> 
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('testimonial.edit.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.testimonial') }}">{{ __('testimonial.index.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('testimonial.edit.title') }}</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">
            <div class="card height-equal">
                <div class="card-header pb-0 card-no-border">
                    <h5>{{ __('testimonial.edit.title') }}</h5><span>{{ __('testimonial.edit.description') }}</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <form method="POST" action="{{ route('admin.testimonial.update', $testimonial) }}" class="row g-3 needs-validation custom-input" enctype="multipart/form-data" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="col-12"> 
                            <label class="form-label" for="testimonialImage">{{ __('testimonial.edit.form.image') }}</label>
                            <div class="avatar mb-4"><img class="img-100 rounded-circle" src="{{ asset('storage/images/testimonial/'.$testimonial->image) }}" alt="{{ $testimonial->name }}"></div>
                            <input class="form-control" id="testimonialImage" name="image" type="file" accept="image/png, image/jpeg" aria-label="file example">
                            <div class="invalid-feedback">{{ __('testimonial.edit.invalid_feedback') }}{{ __('testimonial.edit.form.image') }}</div>
                        </div>                
                        <div class="col-12">
                            <label class="form-label" for="testimonialName">{{ __('testimonial.edit.form.name') }}</label>
                            <input class="form-control" id="testimonialName" name="name" type="text" value="{{ $testimonial->name }}" required="">
                            <div class="invalid-feedback">{{ __('testimonial.edit.invalid_feedback') }}{{ __('testimonial.edit.form.name') }}</div>
                            <div class="valid-feedback">{{ __('testimonial.edit.valid_feedback') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="testimonialPosition">{{ __('testimonial.edit.form.position') }}</label>
                            <input class="form-control" id="testimonialPosition" name="position" type="text" value="{{ $testimonial->position }}" required="">
                            <div class="invalid-feedback">{{ __('testimonial.edit.invalid_feedback') }}{{ __('testimonial.edit.form.position') }}</div>
                            <div class="valid-feedback">{{ __('testimonial.edit.valid_feedback') }}</div>
                        </div>
                        <div class="col-12"> 
                            <label class="form-label" for="testimonialMessage">{{ __('testimonial.edit.form.message') }}</label>
                            <textarea class="form-control" id="testimonialMessage" rows="4" name="message" required="">{{ $testimonial->message }}</textarea>
                            <div class="invalid-feedback">{{ __('testimonial.edit.invalid_feedback') }}{{ __('testimonial.edit.form.name') }}</div>
                        </div>
                        <div class="col-12"> 
                            <label class="form-label" for="testimonialRating">{{ __('testimonial.edit.form.rating') }}</label>
                            <div class="rating-container">
                                <select id="testimonialRating" name="rating" autocomplete="off" required="">
                                    @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $testimonial->rating == $i ? 'selected' : ''}} >{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="invalid-feedback">{{ __('testimonial.edit.invalid_feedback') }}{{ __('testimonial.edit.form.rating') }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="testimonialStatus">{{ __('testimonial.edit.form.status') }}</label>
                            <div class="media">
                            <div class="media-body text-end icon-state">
                                <label class="switch">
                                <input id="testimonialStatus" name="status" type="checkbox" value="1" {{ $testimonial->status ? 'checked' : '' }}><span class="switch-state"></span>
                                </label>
                            </div>
                            <label class="col-form-label m-l-10" id="testimonialStatusLabel">{{ $testimonial->status ? __('testimonial.active') : __('testimonial.inactive') }}</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ __('testimonial.edit.save_changes') }}</button>
                        </div>
                    </form>          
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
    <script src="{{ asset('assets/js/rating/jquery.barrating.js') }}"></script>
    <script>
        $(document).ready(function () {
            var testimonialStatus = {{ $testimonial->status }};
            var active = '{{ __('testimonial.active') }}';
            var inactive = '{{ __('testimonial.inactive') }}';
            $("#testimonialRating").barrating({
                theme: "fontawesome-stars",
                showSelectedRating: false,
            });

            if(testimonialStatus){
                $('#testimonialStatusLabel').addClass('font-success'); 
            }else{
                $('#testimonialStatusLabel').addClass('font-danger');
            }
            
            $('#testimonialStatus').change(function() {
                if($(this).prop('checked')){
                    $('#testimonialStatusLabel').html(active);
                    $('#testimonialStatusLabel').removeClass('font-danger');
                    $('#testimonialStatusLabel').addClass('font-success');
                }else{
                    $('#testimonialStatusLabel').html(inactive);
                    $('#testimonialStatusLabel').removeClass('font-success');
                    $('#testimonialStatusLabel').addClass('font-danger');
                }                
            });
        });  
    </script> 
    </x-slot:custom_js>   
</x-admin-layout>