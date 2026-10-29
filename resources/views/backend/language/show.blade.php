@extends('backend.admin.layouts.app')


@section('content')
    <!-- content header -->
    <section class="content-header flex justify-between sm:px-3 md:px-section md:py-4">
        <div>
            <h2 class="text-skin-backend-heading font-medium">{{translation('Dashboard')}}</h2>
            <p class="text-skin-backend-muted font-semibold text-xs">{{translation("Language")}}</p>
        </div>
        <div class="sm:space-x-2 flex flex-wrap gap-4 items-center">

            <div>
                <a href="{{ route('admin.language.create') }}"
                    class="bg-skin-backend-button px-4 py-2 text-sm text-white font-medium rounded-md hover:bg-skin-backend-button-hover">
                    {{translation("Add Language")}}
                </a>
            </div>

        </div>
    </section>

    <!-- product list table -->
    <section class="sm:mx-3 sm:my-4 md:mx-section bg-skin-backend-content rounded-md px-5 py-2 shadow-lg">
      <!-- product list header -->
      <div class="cotent flex justify-between flex-wrap items-center">
        <h1 class="text-sm font-semibold">{{translation("English")}}</h1>
        <!-- Search bar -->
        <form class="rounded-md shadow-sm  px-4 flex items-center m-2 bg-skin-backend-highlight" id="sort_data" method="GET">
          <i class="bx bx-search-alt-2 text-skin-sub-header text-lg"></i>
          <input type="text" placeholder="Type Key & Enter" name="language_key_search" @isset($sort_search) value="{{ $sort_search }}" @endisset
            class="w-28 sm:w-44 bg-skin-backend-highlight text-skin-sub-header focus:outline-none focus:ring-transparent border-none text-sm" />
        </form>
      </div>

      <!-- table -->
      <form class="overflow-x-auto" action="{{route('admin.language.store_value')}}" method="POST">
        @csrf

        <input type="hidden" name="language_id" value="{{ $language->id }}">
        <table class="w-full ">

          <thead>
            <tr class="border-b-[1px] border-dashed border-gray-200 text-xs text-skin-sub-header">
              <th class="text-start min-w-[50px] font-semibold px-2 py-4">#</th>
              </th>
              <th class="text-start min-w-[180px] font-semibold">{{translation("Key")}}</th>
              </th>
              <th class="text-start min-w-[180px] font-semibold">{{translation("Value")}}</th>
              </th>
            </tr>
          </thead>

          <tbody class="text-skin-table-data font-medium text-sm">
              @foreach ($translations as $key=>$translation)
                  
            <tr class="odd:bg-gray-100 even:bg-gray-50 border-b-[1px] border-dashed border-gray-200">
              <td class="text-start text-skin-header py-4 px-2">{{$key+1}}</td>
              <td class="">	{{$translation->translation_value}}</td>
              <td class="text-start">
                <input type="text" name="translations[{{ $translation->translation_key }}]" @if (($traslate_lang = \App\Models\Translation::where('language', $language->code)->where('translation_key', $translation->translation_key)->latest()->first()) != null)
                value="{{ $traslate_lang->translation_value }}" @endif class="bg-gray-50 w-full text-sm px-4 py-2 rounded-md border-gray-200 focus:border-gray-200 focus:ring-0">
              </td>
            </tr>
            @endforeach
          
          </tbody>

        </table>

        <button type="submit" class="float-right bg-skin-backend-button hover:bg-skin-backend-button-hover transition-colors duration-300 text-skin-backend-invert px-4 py-2 rounded-md my-4">Save</button>

      </form>

      <!-- Product List Footer -->
      <div class="product-list-footer py-4 flex justify-between overflow-auto">
          <div class="pagination">
              {{ $translations->links('backend.admin.paginations.default-pagination') }}
          </div>
      </div>
    </section>
@endsection
@section('script')
<script type="text/javascript">
    function sort_data(el) {
            $('#sort_data').submit();
        }
</script>
@endsection
