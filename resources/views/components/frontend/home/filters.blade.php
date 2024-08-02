<div class="shop-left-sidebar">
    <div class="back-button">
        <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
    </div>
    <div class="accordion custom-accordion" id="accordionExample">
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
                        @if (count($brands))
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
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        @foreach ($filterOptions as $attributeName => $values)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $loop->index }}">
                        <span>{{ $attributeName }}</span>
                    </button>
                </h2>
                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <ul class="category-list custom-padding custom-height">
                            @foreach ($values as $value)
                                <li>
                                    <div class="form-check ps-0 m-0 category-list-box">
                                        <input class="checkbox_animated" type="checkbox"
                                            id="value{{ $value->value_id }}" name="filters[{{ $attributeName }}][]"
                                            value="{{ $value->value_id }}"
                                            {{ in_array($value->value_id, (array) request()->input('filters.' . $attributeName, [])) ? 'checked' : '' }}>

                                        <label class="form-check-label">
                                            <span class="name">{{ $value->value }}</span>
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
