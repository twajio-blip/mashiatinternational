@extends('backend.admin.layouts.app')


@section('content')
    <!-- content header -->
    <section class="content-header flex justify-between sm:px-3 md:px-section md:py-4">
        <div>
            <h2 class="text-skin-backend-heading font-medium">{{translation("Dashboard")}}</h2>
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

    <!-- Language list table -->
    <section class="sm:mx-3 sm:my-4 md:mx-section bg-skin-backend-content rounded-md px-5 py-2 shadow-lg">
        <!-- Language list header -->
        <div class="cotent flex justify-between flex-wrap items-center">
            <h1 class="text-sm font-semibold">{{translation("All languages")}}</h1>

            <div class="relative rounded-md shadow-sm m-2 w-44 bg-skin-backend-highlight">
                <span
                    class="cursor-pointer h-full w-8 flex items-center justify-center text-skin-sub-header text-lg absolute top-0 left-0"><i
                        class="bx bx-search-alt-2"></i></span>

                <input type="text" placeholder="Search Language"
                    class="w-full pl-8 bg-skin-backend-highlight text-skin-sub-header focus:outline-none focus:ring-gray-300 border-none rounded-md" />
            </div>
        </div>
        <!-- table -->
        <div class="overflow-x-auto">
            <table class="w-full ">

                <thead>
                    <tr class="border-b-[1px] border-dashed border-border-color h-16 text-xs text-skin-sub-header">
                        <th class="text-start min-w-[180px] font-semibold">{{translation("Language")}}</th>
                        </th>
                        <th class="text-center min-w-[100px] font-semibold">{{translation("Status")}}</th>
                        </th>
                        <th class="text-center min-w-[100px] font-semibold">{{translation("Direction")}}</th>
                        </th>
                        <th class="text-end min-w-[200px] font-semibold">{{translation("Options")}}</th>
                        </th>
                    </tr>
                </thead>

                <tbody class="text-skin-table-data font-bold text-sm">
                    @forelse ($languages as $language)
                        <tr class="border-b-[1px] border-dashed border-border-color ">

                            <td class="text-start text-skin-header py-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ static_asset('images/language/' . $language->code . '.png') }}"
                                        alt="product 1" class="w-16 cursor-pointer bg-skin-table-button m-2 rounded-md">
                                    <p class="font-medium">{{ $language->name }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center justify-center">
                                    <label class="inline-flex items-center cursor-pointer my-auto">
                                        <input type="checkbox" id="checkbox" class="sr-only peer" @checked($language->status == 1)
                                            onchange="change_status(this)" value="{{ $language->id }}" type="checkbox"
                                            data-id="{{ $language->id }}" id="language{{ $language->id }}">
                                        <div
                                            class="relative w-10 h-4 bg-skin-backend-highlight peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-[25px] rtl:peer-checked:after:-translate-x-[25px] peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-skin-backend-button peer-checked:ring-2 peer-checked:ring-backend-highlight">
                                        </div>
                                    </label>
                                </div>
                               
                            </td>
                            <td class="text-end text-skin-backend-muted">
                                <div class="flex justify-center gap-4">
                                    {{$language->is_rtl == 0 ? ' LTR' : 'RTL'}}
                             
                                </div>
                            </td>
                            <td class="text-end text-skin-backend-muted">
                                <a href="{{ route('admin.language.show', $language->id) }}"
                                    class=" px-1 py-2 hover:bg-skin-backend-highlight">
                                    <i class="bx bx-show"></i>
                                </a>

                                @if($language->code != 'en')
                                <a href="{{ route('admin.language.edit', $language->id) }}"
                                    class=" px-1 py-2 hover:bg-skin-backend-highlight">
                                    <i class="bx bx-edit"></i>
                                </a>

                                <button onclick="deleteData({{ $language->id }})"
                                    class=" px-1 py-2 hover:bg-skin-backend-highlight">
                                    <i class="bx bx-trash"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.language.destroy', $language->id) }}"
                                    style="display: none" id="delete-language-{{ $language->id }}">
                                    @csrf
                                    @method('DELETE')

                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <h2>No Data Found!</h2>
                    @endforelse

                </tbody>

            </table>
        </div>

        <!-- Product List Footer -->
        <div class="product-list-footer py-4 flex justify-between overflow-auto">
            <div class="pagination">
                {{ $languages->links('backend.admin.paginations.default-pagination') }}
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        function deleteData(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {

                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-language-' + id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            });
        }

        // Change status
        function change_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('admin.language.status_change') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    //success message
                    toastr.success('Status updated', '');
                } else {
                    //error message
                    toastr.error('Failed!', '');
                }
            });
        }

        // Sorting
        function sort_data(el) {
            $('#sort_data').submit();
        }
    </script>
@endsection
