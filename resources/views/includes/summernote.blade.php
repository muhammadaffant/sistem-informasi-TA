@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/summernote/dist/summernote-bs4.css') }}">
@endpush


@push('scripts_vendor')
    <script src="{{ asset('stisla/node_modules/summernote/dist/summernote-bs4.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $('.summernote').summernote({
            fontNames: [''],
            height: 200
        });
        $('.note-btn-group.note-fontname').remove();
        setTimeout(() => {
            $('.note-btn-group.note-fontname').remove();
        }, 300);
    </script>
@endpush
