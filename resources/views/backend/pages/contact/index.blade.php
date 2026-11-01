<x-Deshboard-layout>

    <!-- Table Section -->
    <div class=" py-10 ">
        <!-- Card -->
        <div class="space-y-4">
            <!-- Header -->
            <div class="md:flex md:justify-between md:items-center space-y-4 md:space-y-0">
                <div class="space-y-2 max-w-[304px] text-skin-backend-text-base">
                    <h2 class="text-[24px]">
                        <a href="{{ route('notification.index') }}"
                            class="font-bold text-skin-backend-text-base">Notification</a> / <span
                            class="text-skin-backend-text-base text-opacity-50">Inquiries</span>
                    </h2>
                    <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                        View and manage notifications for customer inquiries and messages.
                    </p>
                </div>
                <form action="{{ route('contact.updateAll') }}" method="POST">
                    @csrf
                    <button
                        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-xs  font-[600] rounded-[10px] bg-green-500 hover:bg-green-600 transition-opacity duration-300 text-skin-backend-text-base disabled:opacity-50 disabled:pointer-events-none">View
                        All</button>
                </form>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="bg-skin-backend-secondary text-skin-backend-text-base p-6 rounded-[10px]">
                <div class="w-full overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                        <thead class="bg-[#323232] font-bold">
                            <tr>
                                <th class="py-3 text-start min-w-[100px]">
                                    <h2 class="px-6">Name</h2>
                                </th>
                                <th class="py-3 text-start min-w-[80px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Number</h2>
                                </th>
                                <th class="py-3 text-start min-w-[100px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Eamil</h2>
                                </th>
                                <th class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Address</h2>
                                </th>
                                <th class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Subject</h2>
                                </th>
                                <th class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Description</h2>
                                </th>
                                <th class="py-3 text-center w-[100px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Action</h2>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#ffffff06]">

                            @forelse ($contacts as $contact)
                            <tr class="text-xs">
                                <td class="py-3 px-6">
                                    {{ $contact->name }}
                                </td>
                                <td class="py-3">
                                    {{ $contact->phone }}
                                </td>
                                <td class="py-3">
                                    {{ $contact->email }}
                                </td>
                                <td class="py-3">
                                    {{ $contact->address }}
                                </td>
                                <td class="py-3">
                                    {{ $contact->subject }}
                                </td>
                                <td class="py-3">
                                    {{ $contact->description }}
                                </td>
                                <td class="text-center py-3">
                                    <div class="space-x-2">
                                        <span messageId="{{ $contact->id }}" data-hs-overlay="#details-model"
                                            details="{{ $contact }}"
                                            class="view-details-btn cursor-pointer inline-block {{ $contact->status == 1 ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }} inline-flex items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] rounded-full"><i
                                                class="fa-solid fa-eye"></i></span>
                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr class="">
                                <td class=" px-4 py-2 w-full text-gray-500 text-center" colspan="7">No data found</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Table -->

            <div class="float-right mt-3">
                <x-backend.pagination :paginator="$contacts" />

            </div>
            <!-- End Card -->
        </div>

    </div>
    <!-- End Table Section -->

    {{-- Model --}}
    @include('backend.pages.contact.model.details-model')

</x-Deshboard-layout>

{{-- Delete Element Confermation --}}
<script>
    $('.view-details-btn').click(function() {
        let id = $(this).attr('messageId');
        let route = '{{ route('contact.update', ':id') }}'.replace(':id', id);

        fetch(route, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": $('input[name="_token"]').val()
                },
                method: "put",
                credentials: "same-origin",
                body: JSON.stringify({
                    key: "value"
                })
            })
            .then(response => response.json())
            .then(json => {
                if (json) {
                    $(this).removeClass('bg-red-500 hover:bg-red-600').addClass(
                        'bg-green-500 hover:bg-green-600');
                }
            })
            .catch(error => {
                console.error(error);
            });
        let details = $(this).attr('details')
        details = JSON.parse(details)
        $('#details-model').find('.details-content .name').html(details.name);
        $('#details-model').find('.details-content .address').html(details.address);
        $('#details-model').find('.details-content .created_at').html(new Date(details.created_at)
            .toLocaleString());
        $('#details-model').find('.details-content .subject').html(details.subject);
        $('#details-model').find('.details-content .description').html(details.description);
        $('#details-model').find('.details-content .email').html(details.email);
        $('#details-model').find('.details-content .phone').html(details.phone);
    });
</script>