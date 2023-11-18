<style>
    .carousel {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .carousel-inner {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        min-width: 100%;
        box-sizing: border-box;
        position: relative;
        text-align: center;
    }

    .slide img {
        width: 100%;
        height: auto;
        height:90%;
    }

    .caption {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 25px 0px 82px 0px;
    }

    .caption h3 {
        font-size:35px
    }

    /* Navigation Buttons */
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 40%;
        width: auto;
        padding: 16px;
        margin-top: -22px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
    }

    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    /* Button Hover Effects */
    .prev:hover, .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    /* Responsive Media Queries */
    @media (max-width: 768px) {
        .caption {
            font-size: 18px;
            padding: 15px 0;
            bottom: 10px;
        }

        .caption h3 {
            font-size: 25px;
        }

        .prev, .next {
            font-size: 16px;
            padding: 12px;
            top: 30%;
        }
    }

    @media (max-width: 480px) {
        .caption {
            font-size: 16px;
            padding: 12px 0;
            bottom: 5px;
        }

        .caption h3 {
            font-size: 20px;
        }

        .prev, .next {
            font-size: 14px;
            padding: 10px;
            top: 20%;
        }
    }   
</style>

<div class="carousel" onmouseenter="stopAutoplay()" onmouseleave="startAutoplay()">
    <div class="carousel-inner">
        @foreach($slider as $key => $slide)
        <div class="slide">
            <img src="{{ asset('storage/images/slider/'.$slide->image) }}" alt="{{ $slide->name }}">
            @if($slide->caption)
            <div class="caption">
                <h3>{{ $slide->caption }}</h3>
                @if($slide->description)
                <p>{{ $slide->description }}</p>
                @endif
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Navigation Buttons -->
    <div class="prev" onclick="changeSlide(-1)">&#10094;</div>
    <div class="next" onclick="changeSlide(1)">&#10095;</div>
</div>

<script>
    let currentSlide = 0;
    let autoplayInterval;

    function changeSlide(n) {
        const slides = document.querySelector('.carousel-inner');
        const totalSlides = document.querySelectorAll('.slide').length;
        currentSlide = (currentSlide + n + totalSlides) % totalSlides;
        const translateValue = -currentSlide * 100 + '%';
        slides.style.transform = 'translateX(' + translateValue + ')';
    }

    function startAutoplay() {
        autoplayInterval = setInterval(function() {
            changeSlide(1);
        }, 3000); // Adjust autoplay interval as needed
    }

    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }

    startAutoplay(); // Start autoplay initially
</script>