<div class="shop-left-sidebar">
    <div class="accordion custom-accordion" id="accordionExample">
        @if ($filterSummary)
            <div class="filter-category">
                <a href="{{ route('frontend.home.clearAllFilters') }}">Clear All</a>
                <ul>
                    @foreach ($filterSummary as $filter)
                        <li>
                            <a
                                href="{{ route('frontend.home.removeFilter', ['type' => $filter['type'], 'id' => $filter['id']]) }}">
                                {{ ucfirst($filter['value']) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (count($brands))
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo">
                        <span>Brand</span>
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <ul class="category-list custom-padding">

                            @foreach ($brands as $item)
                                <li>
                                    <div class="form-check ps-0 m-0 category-list-box">
                                        <input class="checkbox_animated" type="checkbox" id="brand_{{ $item->id }}"
                                            name="brand[]" value="{{ $item->id }}"
                                            {{ in_array($item->id, (array) request()->input('brand', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="brand_{{ $item->id }}">
                                            <span class="name">{{ ucwords($item->name) }}</span>
                                            <span class="number">({{ $item->product_count }})</span>
                                        </label>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($filterAttributes as $attribute)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $loop->index }}">
                        <span>{{ $attribute->name }}</span>
                    </button>
                </h2>
                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <ul class="category-list custom-padding custom-height">
                            @foreach ($attribute->attributeValue as $item)
                                <li>
                                    <div class="form-check ps-0 m-0 category-list-box">
                                        <input class="checkbox_animated" type="checkbox" value="{{ $item->id }}"
                                            name="filters[{{ $item->id }}][]" id="{{ $item->id }}"
                                            {{ in_array($item->id, (array) request()->input('filters.' . $item->id, [])) ? 'checked' : '' }} />
                                        <label class="form-check-label" for="{{ $item->id }}">
                                            <span class="name">{{ $item->value }}</span>
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('search-filter-form'); // middle-box.blade.php
        const filterInputs = document.getElementById('filter-inputs'); // middle-box.blade.php
        const searchField = document.querySelector('input[name="search"]'); // middle-box.blade.php
        const checkboxes = document.querySelectorAll('.shop-left-sidebar input[type="checkbox"]');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateForm);
        });

        function updateForm() {
            filterInputs.innerHTML = '';
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = checkbox.name;
                    input.value = checkbox.value;
                    filterInputs.appendChild(input);
                }
            });
            form.submit();
        }
    });
</script>
