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
                            class="text-skin-backend-text-base text-opacity-50">Subscribers</span>
                    </h2>
                    <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                        Manage notifications related to your newsletter subscribers and updates.
                    </p>
                </div>
                {{-- <form action="" method="POST">
                    @csrf
                    <button
                        class="view_all py-2.5 px-4 inline-flex items-center gap-x-2 text-xs font-[600] rounded-[10px] bg-green-500 hover:bg-green-600 transition-opacity duration-300 text-skin-backend-text-base disabled:opacity-50 disabled:pointer-events-none">View
                        All</button>
                </form> --}}
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="bg-skin-backend-secondary text-skin-backend-text-base p-6 rounded-[10px]">
                <div class="w-full overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                        <thead class="bg-[#323232] font-bold">
                            <tr>
                                <th class="py-3 text-start min-w-[100px]">
                                    <h2 class="px-6">Email</h2>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#ffffff06]">

                            @forelse ($subscribers as $subscriber)
                                <tr class="text-xs">
                                    <td class="py-3 px-6">
                                        {{ $subscriber->email }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="">
                                    <td class=" px-4 py-2 w-full text-gray-500 text-center" colspan="7">No data found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- End Table -->

            <div class="float-right mt-3">
                <x-backend.pagination :paginator="$subscribers" />
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Table Section -->

    {{-- Model --}}
    {{-- @include('backend.pages.contact.model.details-model') --}}

</x-Deshboard-layout>
