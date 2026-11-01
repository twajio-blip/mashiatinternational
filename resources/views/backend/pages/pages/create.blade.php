<x-Deshboard-layout>
    <style>
        .preview-parent #hs-pro-deuuf-error {
            padding-left: 92px;
            font-size: 12px
        }

        .preview-parent #image-input-error {
            padding-left: 92px;
            font-size: 12px
        }
    </style>
    <!-- Table Section -->
    <div class=" py-10 ">
        <!-- Card -->
        <div class="space-y-4">
            <!-- Header -->
            <div class="space-y-2 max-w-[304px] text-skin-backend-text-base">
                <h2 class="text-[24px]">
                    <a href="{{ route('pages.index') }}" class="font-bold text-skin-backend-text-base">Pages</a> / <span
                        class="text-skin-backend-text-base text-opacity-50">Add Pages</span>
                </h2>
                <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                    Create new pages for your website by adding titles, content, SEO details, and layout preferences.
                </p>
            </div>
            {{-- Body --}}
            <form id='pages-create' action="{{ route('pages.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- End Header -->
                <div class="grid grid-cols-12 text-skin-backend-text-base gap-4">
                    <div class="space-y-6 col-span-12 lg:col-span-8 p-6 bg-skin-backend-secondary rounded-[10px] h-fit">
                        <h2 class="text-[18px] font-bold">Page Details</h2>
                        <div class="space-y-2">
                            <div>
                                <x-backend.input-label :value="'Page Name'" for="name" />
                                <x-backend.input-field type="text" name="name" data-slug="name-slag"
                                    oninput="makeSlug(this)" id='name' :value="old('name')"
                                    placeholder="Enter page name" />
                            </div>
                            <div>
                                <x-backend.input-label :value="'Page URL'" for="permalink " />
                                <div tabindex="0"
                                    class="url flex items-center border border-default border-opacity-25 rounded-[4px] focus:border-highlight">
                                    <span
                                        class="text-sm url text-skin-backend-text-base text-opacity-50 pl-3  whitespace-nowrap ">{{
                                        Request::root() }}/</span>
                                    <x-backend.input-field type="text" name="permalink" id='permalink'
                                        :value="old('permalink')" placeholder="Enter Page URL"
                                        class="border-none focus:border-none pl-1" target="name-slag" />
                                </div>
                            </div>
                            <div>
                                <x-backend.input-label :value="'Breadcrumbs Content'" for="breadcrumbs_title" />
                                <x-backend.textEditor :id="'breadcrumbs_title'" name='description' :form_id="'pages-create'"
                                    class="w-full" />
                            </div>
                            <x-backend.input-checkbox :checked="''" :id="'text_content_only'"
                                :label="'Switch to Text Content Only'" />
                            <div id="text-content" class="hidden">
                                <x-backend.input-label :value="__('Main Content')" for="create" />
                                <x-backend.textEditor :id="'create'" name='page_text_content' :form_id="'pages-create'"
                                    class="w-full" />
                            </div>
                        </div>


                        <div id='component-content'>
                            <x-backend.page-component />
                        </div>
                    </div>
                    <div class="space-y-6 col-span-12 lg:col-span-4 p-6 bg-skin-backend-secondary rounded-[10px]">
                        <div class="space-y-4 pb-4 border-b border-default border-opacity-50">
                            <h2 class="text-[18px] font-bold">Publish Settings</h2>
                            <div
                                class="flex flex-col flex-wrap sm:flex-row sm:items-center sm:justify-between gap-3 w-full max-w-3xl">
                                <!-- Save & Exit -->
                                <input type="submit" value="Save & Exit" name="save_exit" id="save_exit"
                                    class="cursor-pointer flex-1 py-3 px-5 text-sm font-semibold rounded-xl bg-skin-backend-accent hover:bg-opacity-90 transition-opacity text-skin-invert disabled:opacity-50 disabled:pointer-events-none shadow-md hover:shadow-lg" />

                                <!-- Save -->
                                <input type="submit" value="Save" name="save" id="save"
                                    class="cursor-pointer flex-1 py-3 px-5 text-sm font-semibold rounded-xl bg-[#E4DB9B] hover:bg-[#d3c986] transition-all text-black disabled:opacity-50 disabled:pointer-events-none shadow-md hover:shadow-lg" />

                                <!-- Preview -->
                                <input type="submit" value="Preview" name="preview" id="preview"
                                    class="cursor-pointer flex-1 py-3 px-5 text-sm font-semibold rounded-xl bg-blue-400 hover:bg-blue-300 transition-all text-white disabled:opacity-50 disabled:pointer-events-none shadow-md hover:shadow-lg" />
                            </div>
                        </div>
                        {{-- Status --}}
                        <div class="space-y-4 pb-4 border-b border-default border-opacity-50">
                            <h2 class="text-[18px] font-bold">
                                Status
                            </h2>
                            <div>
                                <x-backend.input-select name='status' id="component"
                                    :values="['0' => 'Draft', '1' => 'Published']" :placeholder="'Select one'"
                                    selected='1' required />
                            </div>
                        </div>
                        <div class="space-y-3 pb-4 border-b border-default border-opacity-50">
                            <h2 class="text-[18px] font-bold">
                                Header Template
                            </h2>
                            <div class="pt-4">
                                <x-backend.input-dropdown name="header_component"
                                    :values="getHeaderFooter()->get('header')" :label_name="'level'" :label_id="'value'"
                                    :placeholder="'Select one'" selected="{{$general->header_component ?? '' }}"
                                    required />

                                <div class="flex items-center gap-4 mt-4">
                                    <x-backend.input-checkbox :value="'fix'" :checked="$general?->header_component_position === 'fix'" :id="'fix'"
                                        :label="'Fixed Header'" name="header_component_position" />

                                    <x-backend.input-checkbox :value="'sticky'" :checked="$general?->header_component_position === 'sticky'" :id="'sticky'"
                                        :label="'Sticky Header'" name="header_component_position" />

                                </div>
                            </div>
                        </div>
                        <div class="space-y-3 pb-4 border-b border-default border-opacity-50">
                            <h2 class="text-[18px] font-bold">
                                Footer Template
                            </h2>
                            <div class="pt-4">
                                <x-backend.input-dropdown name="footer_component"
                                    selected="{{ $general->footer_component ?? '' }}"
                                    :values="getHeaderFooter()->get('footer')" :label_name="'level'" :label_id="'value'"
                                    :placeholder="'Select one'" required />
                            </div>
                        </div>
                        {{-- Breadcrumbs --}}
                        <div class="space-y-4 pb-4 border-b border-default border-opacity-50">
                            <div class="space-y-2">
                                <h2 class="text-[18px] font-bold">Breadcrumb</h2>

                                <x-backend.switch :id="'is_breadcrumb'" :name="'is_breadcrumb'" :value="''" />

                            </div>
                            <h2 class="text-[18px] font-bold">
                                Breadcrumbs Image
                            </h2>
                            <!-- Body -->
                            <div class="space-y-2 preview-parent w-full max-w-md">
                                <label for="imageUpload"
                                    class="relative block border border-default border-opacity-50 rounded-md p-3 min-h-[110px] w-full cursor-pointer hover:border-primary transition">
                                    <div class="flex items-center space-x-4">
                                        <img id="preview" src="{{ asset('/defualt/placeholder.png') }}"
                                            class="w-[90px] h-[90px] object-cover rounded border border-gray-200" />
                                        <div class="flex-1">
                                            <p class="text-sm text-skin-backend-text-base">Click to upload image</p>
                                            <p class="text-xs text-skin-muted mt-1">Only JPG, PNG, and JPEG formats are
                                                supported.</p>
                                        </div>
                                    </div>
                                    <input onchange="imagePreview(this)" type="file" name="image"
                                        accept=".png,.jpg,.jpeg"
                                        class="absolute inset-0 opacity-0 cursor-pointer image-preview" />
                                    <!-- Reset Button -->
                                    <button type="button" id="resetImage" onclick="resetCurrentImage(this)"
                                        class="absolute top-2 right-2 p-1 bg-white rounded-full shadow hover:bg-gray-100 focus:outline-none hidden z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 01-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 01-1.414-1.414L8.586 10 2.636 4.05a1 1 0 011.414-1.414L10 8.586z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </button>
                                </label>
                            </div>
                            <!-- End Body -->
                        </div>
                        {{-- SEO --}}
                        <div class="space-y-4 preview-parent">
                            <div class="space-y-4">
                                <h2 class="text-[18px] font-bold">SEO Settings</h2>
                                <div>
                                    <x-backend.input-label :value="'SEO title'" for="seo_title" maxlength="60" />
                                    <x-backend.input-field type="text" name="seo_title" id='seo_title'
                                        :value="old('seo_title')" placeholder="Enter Seo Title" maxlength="60" />
                                    <small class="text-xs text-skin-backend-text-base text-opacity-50 ">Maximum 60
                                        characters allowed.</small>

                                </div>
                                <div>
                                    <x-backend.input-label :value="'SEO description'" for="seo_description" />
                                    <x-backend.input-textarea name="seo_description" :id="'seo_description'" :text="''"
                                        placeholder='Enter Seo Description' required maxlength="160" />
                                    <small class="text-xs text-skin-backend-text-base text-opacity-50">Maximum 160
                                        characters allowed.</small>
                                </div>
                            </div>

                            <div class="space-y-4 image-container">
                                <h2 class="text-[18px] font-bold">Seo Image</h2>


                                <div class="space-y-2 preview-parent w-full max-w-md">
                                    <label for="imageUpload"
                                        class="relative block border border-default border-opacity-50 rounded-md p-3 min-h-[110px] w-full cursor-pointer hover:border-primary transition">
                                        <div class="flex items-center space-x-4">
                                            <img id="preview" src="{{ asset('/defualt/placeholder.png') }}"
                                                class="w-[90px] h-[90px] object-cover rounded border border-gray-200" />
                                            <div class="flex-1">
                                                <p class="text-sm text-skin-backend-text-base">Click to upload image</p>
                                                <p class="text-xs text-skin-muted mt-1">Only JPG, PNG, and JPEG formats
                                                    are supported.</p>
                                            </div>
                                        </div>
                                        <input onchange="imagePreview(this)" type="file" name='seo_image'
                                            accept=".png,.jpg,.jpeg"
                                            class="absolute inset-0 opacity-0 cursor-pointer image-preview" />
                                        <!-- Reset Button -->
                                        <button type="button" id="resetImage" onclick="resetCurrentImage(this)"
                                            class="absolute top-2 right-2 p-1 bg-white rounded-full shadow hover:bg-gray-100 focus:outline-none hidden z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 01-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 01-1.414-1.414L8.586 10 2.636 4.05a1 1 0 011.414-1.414L10 8.586z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                        </button>
                                    </label>
                                </div>




                            </div>
                            <div class="space-y-4">
                                <h2 class="text-[18px] font-bold">Indexing Options</h2>
                                <div class="space-y-2">
                                    <div class="flex gap-2 items-center">
                                        <input id="seo_index" type="radio" value="index" name="seo_index"
                                            class="w-4 h-4 text-skin-hover bg-gray-100 border-default focus:ring-0 focus:ring-offset-0">
                                        <label for="seo_index" class="text-sm">Index</label>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <input checked id="seo_no_index" type="radio" value="noindex" name="seo_index"
                                            class="w-4 h-4 text-skin-hover bg-gray-100 border-default focus:ring-yellow-500 focus:ring-0 focus:ring-offset-0">
                                        <label for="seo_no_index" class="text-sm">No Index</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Card -->
    </div>
    <!-- End Table Section -->
    {{-- Model --}}
    @include('backend.pages.pages.model.ui-model')
    @include('backend.pages.pages.model.field-data-model')
    {{-- Message --}}
    @if ($message = Session::get('success'))
    <x-backend.flash-error :message="$message" :type="'success'" />
    @endif

</x-Deshboard-layout>
{{-- servier error --}}
<x-backend.server-error :form_id="'pages-create'" :request_form="'Pages\PagesCreateRequest'" />

<script>
    $(function() {
$("#sortable").sortable();
});

$('input[name="header_component_position"]').on('change', function() {
$('input[name="header_component_position"]').not(this).prop('checked', false);
});





function applyTextEditor(initialize) {
if (typeof SUNEDITOR === 'undefined') {
return;
}
var id = (String(initialize)).replace(/^#/, '');
var el = document.getElementById(id);
if (!el || el._sunEditor) {
return;
}
var editor = SUNEDITOR.create(el, {
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
imageUploadSizeLimit: 2 * 1024 * 1024, // 2 MB upload limit
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
el._sunEditor = editor;

editor.onChange = function(contents) {
el.value = contents;
};
}
$('#text_content_only').on('change', function() {
if ($(this).is(':checked')) {
$('#text-content').show();
$('#component-content').hide();
applyTextEditor('create');
} else {
$('#text-content').hide();
$('#component-content').show();
}
});
    
</script>