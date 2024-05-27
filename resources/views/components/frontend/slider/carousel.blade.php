@php
    $carouselIndicators = 0;
    $xhtmlCarouselIndicators = '';
    $xhtml = '';

    foreach ($items as $key => $item) {
        $activeClass = $key == 0 ? 'active' : '';
        $xhtmlCarouselIndicators .= sprintf(
            '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="%s" class="%s" aria-current="%s" aria-label="Slide %s"></button>',
            $carouselIndicators,
            $activeClass,
            $activeClass ? 'true' : 'false',
            $carouselIndicators + 1,
        );
        $carouselIndicators++;
    }

    foreach ($items as $key => $item) {
        $activeClass = $key == 0 ? 'active' : '';
        foreach ($item['media'] as $value) {
            $url = $value->getUrl();
            $xhtml .= sprintf(
                '<div class="carousel-item %s">
                    <img src="%s" class="d-block w-100" height="450" alt="">
                </div>',
                $activeClass,
                htmlspecialchars($url, ENT_QUOTES, 'UTF-8'),
            );
        }
    }
@endphp

<section class="home-section pt-2">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-12 ratio_65">
                <div class="home-contain h-100">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            {!! $xhtmlCarouselIndicators !!}
                        </div>
                        <div class="carousel-inner">
                            {!! $xhtml !!}
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
