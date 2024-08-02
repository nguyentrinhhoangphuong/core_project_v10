<div class="middle-box">
    <div class="search-box">
        <form action="{{ route('frontend.home.filterProduct') }}" method="get" id="search-filter-form">
            <div class="input-group">
                <input type="search" class="form-control" name="search" placeholder="Tìm sản phẩm..."
                    value="{{ request('search') }}">
                <button class="btn" type="submit" id="button-addon2">
                    <i data-feather="search"></i>
                </button>
            </div>
            <div id="filter-inputs"></div>
        </form>
    </div>
</div>
