<x-modal data-backdrop="static" data-keyboard="false" size="modal-xl">
    <x-slot name="title">
        Tambah Produk
    </x-slot>

    @method('POST')

    <div class="row">
        <!-- Brand ID -->
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select class="form-control select2 brand_id" name="brand_id" id="brand_id" style="width: 100%"></select>
            </div>
        </div>

        <!-- Category ID -->
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select class="form-control select2 category_id" name="category_id" id="category_id"
                    style="width: 100%"></select>
            </div>
        </div>

        <!-- Subcategory ID -->
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="subcategory_id">Subkategori</label>
                <select class="form-control select2 subcategory_id" name="subcategory_id" id="subcategory_id"
                    style="width: 100%"></select>
            </div>
        </div>

        <!-- Subsubcategory ID -->
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="subsubcategory_id">Subsubkategori</label>
                <select class="form-control select2 subsubcategory_id" name="subsubcategory_id" id="subsubcategory_id"
                    style="width: 100%"></select>
            </div>
        </div>

        <!-- Product Code -->
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="product_code">Kode Produk</label>
<input type="text" class="form-control" name="product_code" id="product_code" readonly>

            </div>
        </div>

        <!-- Product Name -->
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="product_name">Nama Produk</label>
                <input type="text" class="form-control" name="product_name" id="product_name" autocomplete="off">
            </div>
        </div>

        <!-- Product Quantity -->
        {{-- <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="product_qty">Kuantitas Produk</label>
                <input type="number" class="form-control" name="product_qty" id="product_qty" autocomplete="off"
                    min="0" value="0">
            </div>
        </div> --}}

        <!-- Product Size -->
<!-- Ukuran dan Harga -->
<div class="col-md-12 col-12">
    <label>Ukuran & Harga</label>
    <div id="sizePriceContainer">
        <div class="row mb-2 size-price-group">
            <div class="col-md-3">
                <input type="text" name="sizes[]" class="form-control" placeholder="Ukuran (misal: S)" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="prices[]" class="form-control price-input" placeholder="Harga (misal: 30000)" required onkeyup="formatHarga(this)">
            </div>
            <div class="col-md-4 discount-wrapper" style="display: none;">
                <input type="number" name="discounts[]" class="form-control" placeholder="Diskon %" oninput="updateDiscountedPrice(this)">
            </div>
            <div class="col-md-3 price-discount-wrapper" style="display: none;">
                <input type="text" name="price_after_discounts[]" class="form-control" placeholder="Harga Setelah Diskon" readonly>
            </div>
            <div class="col-md-4">
                <input type="number" name="quantities[]" class="form-control" placeholder="Stok (misal: 10)" required min="0">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeSizePrice(this)">Hapus</button>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-success mt-2" onclick="addSizePrice()">+ Tambah Ukuran</button>
</div>


        <!-- Product Color -->
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="product_color">Warna Produk</label>
                <input type="text" class="form-control" name="product_color" id="product_color" autocomplete="off">
            </div>
        </div>

        <!-- Price Fields (Selling Price, Discount, Price After Discount) -->
        {{-- <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="selling_price">Harga Jual</label>
                <input type="text" class="form-control" name="selling_price" id="selling_price" autocomplete="off"
                    onkeyup="format_uang(this)">
            </div>
        </div> --}}

                <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="special_deals">Diskon</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="special_deals" id="special_deals">
                    <label class="form-check-label" for="special_deals">Diskon</label>
                </div>
            </div>
        </div>


  <!-- Diskon -->
{{-- <div class="col-md-6 col-12" id="discount_section">
    <div class="form-group">
        <label for="discount_price">Diskon %</label>
        <input type="number" class="form-control" name="discount_price" id="discount_price" autocomplete="off"
            min="0" oninput="calculateDiscountPrice()" placeholder="0">
    </div>
</div>

<!-- Harga Setelah Diskon -->
<div class="col-md-6 col-12" id="price_after_discount_section">
    <div class="form-group">
        <label for="price_after_discount">Harga Setelah Diskon</label>
        <input type="text" class="form-control" name="price_after_discount" id="price_after_discount"
            autocomplete="off" readonly>
    </div>
</div> --}}


        <!-- Descriptions -->
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="short_descp">Deskripsi Singkat</label>
                <input type="text" class="form-control" name="short_descp" id="short_descp" autocomplete="off">
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="long_descp">Deskripsi Lengkap</label>
                <textarea class="form-control" name="long_descp" id="long_descp"></textarea>
            </div>
        </div>

        <!-- Image Upload -->
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="product_thumbnail">Thumbnail Produk</label>
                <input type="file" class="form-control" name="product_thumbnail" id="product_thumbnail"
                    value="product_thumbnail.jpg" onchange="previewImage(this)">
                <br>
                <img id="thumbnailPreview" src="" alt="Image Preview"
                    style="max-width: 200px; display: none;">
            </div>
        </div>

                {{-- <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="photo_name">Upload Gambar Produk</label>
                <input type="file" class="form-control photo_name" name="photo_name[]" id="photo_name"
                    accept="image/*" multiple onchange="previewMultipleImages(this)">
                <br>
                <div id="imagePreviewContainer"></div>
            </div>
        </div> --}}

        <!-- Upload Gambar Produk -->
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Upload Gambar Produk</label>

                <div id="productImageContainer">
                    <div class="image-upload-group mb-3">
                        <input type="file" name="photo_name[]" class="form-control mb-2" accept="image/*" required onchange="previewMultipleImages(this)">
                    </div>
                </div>
                <div id="imagePreviewContainer" class="mt-3"></div>

                <button type="button" class="btn btn-sm btn-success" onclick="addImageUploadField()">
                    + Tambah Gambar
                </button>
                

            </div>
        </div>


        <!-- Special Options (Hot Deals, Featured, Special Offer) -->
        {{-- <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="hot_deals">Hot Deals</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hot_deals" id="hot_deals">
                    <label class="form-check-label" for="hot_deals">Pilih Hot Deals</label>
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="featured">Produk Unggulan</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured">
                    <label class="form-check-label" for="featured">Pilih Produk Unggulan</label>
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="special_offer">Special Offer</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="special_offer" id="special_offer">
                    <label class="form-check-label" for="special_offer">Pilih Special Offer</label>
                </div>
            </div>
        </div> --}}


        <!-- Status -->
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="0">Tidak Aktif</option>
                    <option value="1">Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary" id="submitBtn">
            <i class="fas fa-save mr-1"></i> Simpan
        </button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger">
            <i class="fas fa-times"></i> Close
        </button>
    </x-slot>
</x-modal>
<script>
    function addImageUploadField() {
        const container = document.getElementById('productImageContainer');
        const group = document.createElement('div');
        group.classList.add('image-upload-group', 'mb-3');

group.innerHTML = `
    <div class="row">
        <div class="col-md-11 mb-2">
            <input type="file" name="photo_name[]" class="form-control" accept="image/*" onchange="previewMultipleImages(this)" required>
        </div>
        <div class="col-md-1 mb-2">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeImageUploadField(this)">Hapus</button>
        </div>
    </div>
`;


        container.appendChild(group);
    }

    function removeImageUploadField(button) {
        button.closest('.image-upload-group').remove();
    }

        function previewMultipleImages(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        previewContainer.innerHTML = ""; // Kosongkan sebelum render ulang

        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement("img");
                    img.setAttribute("src", e.target.result);
                    img.setAttribute("style", "max-width: 150px; margin: 5px;");
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('special_deals');
    toggleDiscountFieldsPerSize(checkbox.checked);

    checkbox.addEventListener('change', function () {
        toggleDiscountFieldsPerSize(this.checked);
    });
});

function toggleDiscountFieldsPerSize(isChecked) {
    document.querySelectorAll('.discount-wrapper').forEach(el => {
        el.style.display = isChecked ? 'block' : 'none';
    });
    document.querySelectorAll('.price-discount-wrapper').forEach(el => {
        el.style.display = isChecked ? 'block' : 'none';
    });
}

function addSizePrice() {
    const container = document.getElementById('sizePriceContainer');
    const group = document.createElement('div');
    group.classList.add('row', 'mb-2', 'size-price-group');
    group.innerHTML = `
        <div class="col-md-3">
            <input type="text" name="sizes[]" class="form-control" placeholder="Ukuran (misal: L)" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="prices[]" class="form-control price-input" placeholder="Harga (misal: 35000)" required onkeyup="formatHarga(this)">
        </div>
        <div class="col-md-2 discount-wrapper" style="display: ${document.getElementById('special_deals').checked ? 'block' : 'none'};">
            <input type="number" name="discounts[]" class="form-control" placeholder="Diskon %" oninput="updateDiscountedPrice(this)">
        </div>
        <div class="col-md-3 price-discount-wrapper" style="display: ${document.getElementById('special_deals').checked ? 'block' : 'none'};">
            <input type="text" name="price_after_discounts[]" class="form-control" placeholder="Harga Setelah Diskon" readonly>
        </div>
        <div class="col-md-2">
            <input type="number" name="quantities[]" class="form-control" placeholder="Stok (misal: 10)" required min="0">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeSizePrice(this)">Hapus</button>
        </div>
    `;
    container.appendChild(group);
}

function removeSizePrice(button) {
    button.closest('.size-price-group').remove();
}

function formatHarga(input) {
    let val = input.value.replace(/\D/g, '');
    input.value = new Intl.NumberFormat("id-ID").format(val);
}

function updateDiscountedPrice(input) {
    const wrapper = input.closest('.size-price-group');
    const priceInput = wrapper.querySelector('[name="prices[]"]');
    const discountedInput = wrapper.querySelector('[name="price_after_discounts[]"]');

    let price = priceInput.value.replace(/\D/g, '');
    let discount = parseFloat(input.value) || 0;

    if (price && !isNaN(discount)) {
        let result = price - (price * (discount / 100));
        discountedInput.value = new Intl.NumberFormat("id-ID").format(result);
    }
}

</script>

