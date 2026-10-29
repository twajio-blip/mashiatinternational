@props(['id', 'form_id', 'value' => null])


<textarea id="{{ $id }}" {{ $attributes }} class="w-full bg-skin-backend-secondary text-skin-backend-text-base text-opacity-50">
    {{ $value }}
</textarea>


<script>
    var editTextEditor = '';
    document.addEventListener('DOMContentLoaded', () => {
        // Store editor and form element in variables for reuse
        const editorElement = document.getElementById('{{ $id }}');
        const formElement = document.querySelector('#{{ $form_id }}');
        if (typeof SUNEDITOR === 'undefined' || !editorElement) {
            return;
        }
        if (editorElement._sunEditor) {
            return;
        }
        let editor = null;

        try {
            editor = SUNEDITOR.create(editorElement, {
                defaultStyle: 'font-family: Arial, sans-serif; font-size: 14px;',
                buttonList: [
                    ['undo', 'redo', 'font', 'fontSize', 'formatBlock'],
                    ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript', 'removeFormat'],
                    ['fontColor', 'hiliteColor', 'textStyle', 'removeFormat'],
                    ['align', 'list', 'lineHeight', 'table', 'link', 'image'],
                    ['fullScreen', 'showBlocks', 'codeView'],
                    ['horizontalRule', 'template', 'blockquote', 'indent', 'outdent'],
                ],
                table: {
                    maxWidth: '100%',
                    maxHeight: '300px',
                    resize: true
                },
                imageUploadSizeLimit: 2 * 1024 * 1024,
                font: ['Arial', 'Comic Sans MS', 'Courier New', 'Georgia', 'Tahoma', 'Trebuchet MS',
                    'Verdana'
                ],
                fontSize: [
                    '8', '10', '12', '14', '16', '18', '20', '24', '28', '32', '36', '40',
                    '46', '52', '58', '64', '70', '76', '82', '88', '94', '100', '106', '112', '118',
                    '120'
                ],
                mode: 'classic',
                height: '200px',
                colorList: null
            });
        } catch (e) {
            console.error('[SunEditor] Failed to init #' + '{{ $id }}' + ':', e);
            return;
        }
        editTextEditor = editor;
        if (editorElement) editorElement._sunEditor = editor;

        const syncEditorContent = () => {
            if (typeof editor.save === 'function') {
                editor.save();
            }

            if (typeof editor.core?.codeViewDisabled === 'function') {
                editor.core.codeViewDisabled();
            }

            editorElement.value = editor.getContents();
        };

        editor.onChange = function(contents) {
            editorElement.value = contents;
        };

        if (formElement) {
            formElement.addEventListener('submit', () => {
                syncEditorContent();
            });
        }
    });
</script>
