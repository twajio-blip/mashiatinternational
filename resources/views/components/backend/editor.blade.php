@section('css')

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@3.2.6/css/froala_style.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@3.2.6/css/froala_editor.pkgd.min.css">
        <!-- Froala Editor JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/froala-editor@3.2.6/js/froala_editor.pkgd.min.js"></script>
@endsection

@props(['height', 'full', 'form_id', 'id', 'validate'])
<textarea {{ $attributes->merge(['id' => $id]) }}>
               
</textarea>


<script>
    var height = @json($height);
    var editor = new FroalaEditor('#{{ $id }}', {
        @if (!$full)
            toolbarButtons: {
                'moreText': {
                    'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',
                        'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass',
                        'inlineStyle', 'clearFormatting'
                    ]
                },
                'moreParagraph': {
                    'buttons': ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'indent',
                        'outdent', 'lineHeight'
                    ]
                }
            },
            imageInsertButtons: ['imageBack', '|', 'imageUpload', 'imageByURL'],
            imageUpload: false,
            imageUploadURL: '/your-file-upload-endpoint',
        @endif

        height: height
    });
</script>

@if ($validate)
    {{-- validate --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('{{ $form_id }}');
            if (form) {
                form.addEventListener('submit', function(event) {
                    var editorContent = new FroalaEditor('#{{ $id }}').html.get();
                    var validationMessage = document.querySelector('.validation-message');

                    if (editorContent.trim().length === 0) {
                        // Create a new span element for the validation message
                        var span = document.createElement('span');
                        span.textContent = 'Editor must be required';
                        span.className = 'help-block validation-message';

                        // Check if a validation message already exists
                        if (validationMessage) {
                            // Replace the existing validation message with the new one
                            validationMessage.replaceWith(span);
                        } else {
                            // Append the new validation message after the editor tag
                            var editor = document.querySelector('#{{ $id }}');
                            editor.parentNode.insertBefore(span, editor.nextSibling);
                        }

                        // Prevent form submission
                        event.preventDefault();
                    } else {
                        // Remove any existing validation message
                        if (validationMessage) {
                            validationMessage.remove();
                        }

                        // Form submission will proceed normally
                    }
                });
            }
        });
    </script>
@endif
