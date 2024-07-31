<style>
    header.active .sticky-header {
        transition: all 0.3s ease;
        top: -2.5rem !important;
    }
</style>
<header>
    <div class="sticky-header">
        <div class="top-nav top-header ">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="navbar-top">
                            <x-frontend.header.logo />
                            <x-frontend.header.middle-box />
                            <x-frontend.header.rightside-box />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-nav">
                        <x-frontend.header.categories-products />
                        <div class="header-nav-middle">
                            <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                                <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                    <div class="offcanvas-header navbar-shadow">
                                        <h5>Menu</h5>
                                        <button class="btn-close lead" type="button"
                                            data-bs-dismiss="offcanvas"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <ul class="navbar-nav">
                                            <x-frontend.header.header-nav-middle />
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('header');
        const stickyHeader = document.querySelector('.sticky-header');
        const headerHeight = stickyHeader.offsetHeight;

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > headerHeight) {
                header.classList.add('active');
            } else {
                header.classList.remove('active');
            }
        });
    });
</script>
