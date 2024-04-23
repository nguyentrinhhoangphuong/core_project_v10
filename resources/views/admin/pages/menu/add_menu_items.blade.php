<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Add menu items
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="accordion" id="accordion-example">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-2" aria-expanded="false">
                                Categories
                            </button>
                        </h2>
                        <div id="collapse-2" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                            <div class="accordion-body pt-0 menu-scroll" data-category-model-type="categories">
                                @include('admin.components.category-checkboxes', [
                                    'itemsCategory' => $itemsCategory,
                                    'level' => 0,
                                ])
                            </div>
                            <p style="text-align: end">
                                <input type="submit" id="sumbitMenuCategory" class="btn btn-sm btn-primary "
                                    value="Add to Menu">
                            </p>
                        </div>
                    </div>


                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-3" aria-expanded="false">
                                Category Products
                            </button>
                        </h2>
                        <div id="collapse-3" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                            <div class="accordion-body pt-0 menu-scroll"
                                data-category-products-model-type="category_products">
                                @include('admin.components.category-products-checkboxes', [
                                    'itemsCategoryProducts' => $itemsCategoryProducts,
                                    'level' => 0,
                                ])
                            </div>
                            <p style="text-align: end">
                                <input type="submit" id="sumbitMenuCategoryProducts" class="btn btn-sm btn-primary"
                                    value="Add to Menu">
                            </p>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-4" aria-expanded="false">
                                Custom Links
                            </button>
                        </h2>
                        <div id="collapse-4" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                            <div class="accordion-body pt-0">
                                <form action="{{ route('admin.menus.add.custom.link') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="urlInput" class="form-label">URL:</label>
                                        <input type="url" class="form-control" id="urlInput" name="url"
                                            placeholder="Enter URL">
                                    </div>
                                    <div class="mb-3">
                                        <label for="linkTextInput" class="form-label">Url Name:</label>
                                        <input type="text" class="form-control" id="linkTextInput" name="name"
                                            placeholder="Enter Url Name">
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-primary">Add to menu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
