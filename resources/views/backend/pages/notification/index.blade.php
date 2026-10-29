<x-Deshboard-layout>
    <!-- Table Section -->
    <div class=" py-10 ">
        <div class="space-y-4">
            <!-- Header -->
            <div class="md:flex md:justify-between md:items-center space-y-4 md:space-y-0">
                <div class="space-y-2 max-w-[350px] text-skin-backend-text-base">
                    <h2 class="text-[24px]">
                        <a href="{{ route('dashboard') }}"
                            class="font-bold text-skin-backend-text-base">Dashboard</a> / <span
                            class="text-skin-backend-text-base text-opacity-50">All Notifications</span>
                    </h2>
                    <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                        View and manage all your system notifications in one place. 
                    </p>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="bg-skin-backend-secondary text-skin-backend-text-base p-6 rounded-[10px]">
                <div class="w-full overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                        <thead class="bg-[#323232] font-bold">

                            <tr>
                                <th class="py-3 text-start min-w-[200px]">
                                    <h2 class="px-6">Title</h2> 
                                </th>
                                <th class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Description</h2> 
                                </th> 
                            </tr>
                        </thead>
        
                        <tbody class="divide-y divide-[#ffffff06]">
                            @forelse ($all_notifications as $notification)
                                <tr class="text-xs">
                                    <td class="py-3 px-6"> 
                                        {{$notification->title}} 
                                    </td>
                                    <td class="py-3">
                                        {{$notification->message}}
                                    </td>  
                                </tr>
                            @empty
                                <tr class="">
                                    <td class=" px-4 py-2 w-full text-gray-500 text-center" colspan="7">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- End Table -->
        
                    <div class="float-right mt-3">
                        <x-backend.pagination :paginator="$all_notifications" />
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    <!-- End Table Section -->

    {{-- Model --}}
    {{-- @include('backend.pages.contact.model.details-model') --}}

</x-Deshboard-layout>

