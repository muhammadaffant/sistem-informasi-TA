<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        {{-- Category Name Input --}}
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="category_name">Nama Kategori</label>
                <input type="text" class="form-control" name="category_name" id="category_name" autocomplete="off">
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Slug Input (Disabled) --}}
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" name="slug" id="slug" autocomplete="off" disabled>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="category_icon">Icon Kategori</label>
                <input type="text" class="form-control" name="category_icon" id="category_icon" autocomplete="off"
                    placeholder="fas fa-users">
            </div>
        </div>
    </div> --}}

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary" id="submitBtn">
            <i class="fas fa-save mr-1"></i>
            Simpan
        </button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>

{{-- Add this script to your page --}}
<script>
    // Select the input elements
    const categoryNameInput = document.getElementById('category_name');
    const slugInput = document.getElementById('slug');

    // Listen for input on the category name field
    categoryNameInput.addEventListener('keyup', function() {
        // Generate the slug
        const slug = this.value
            .toLowerCase() // Convert to lowercase
            .trim() // Remove leading/trailing whitespace
            .replace(/[^a-z0-9\s-]/g, '') // Remove non-alphanumeric characters except spaces and hyphens
            .replace(/\s+/g, '-') // Replace spaces with a single hyphen
            .replace(/-+/g, '-'); // Replace multiple hyphens with a single one

        // Update the slug input's value
        slugInput.value = slug;
    });

    // Modify the submitForm function to enable the slug field before submission
    // This ensures its value is sent to the server.
    function submitForm(form) {
        // Re-enable the slug input so its value is included in the form data
        document.getElementById('slug').disabled = false;
        
        // You can now proceed with your form submission logic (e.g., AJAX call or standard form.submit())
        // Example:
        // form.submit();

        // For demonstration, we'll log the form data
        const formData = new FormData(form);
        console.log('Submitting form...');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        // It's good practice to re-disable it in case of submission failure
        document.getElementById('slug').disabled = true;
    }
</script>