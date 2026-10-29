<x-Deshboard-layout>
    <div class="mt-16 space-y-8 text-skin-backend-text-base">
        <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">
            <div class="shadow-sm rounded-[10px] bg-skin-backend-secondary p-4 space-y-2">
                <span class="text-2xl rounded-[10px] w-[44px] h-[44px] bg-skin-backend-primary flex items-center justify-center text-skin-hover">
                    <i class="fa-solid fa-inbox"></i>
                </span>
                <p class="text-[16px]">Unread Inquiries</p>
                <h3 class="text-xl sm:text-[38px] font-[800] py-3">{{ formatNumberShort($data['contacts_unread']) ?? 0 }}</h3>
                <p class="text-[13px] text-skin-backend-text-base text-opacity-50">{{ formatNumberShort($data['contacts_total']) ?? 0 }} total inquiries</p>
            </div>

            <div class="shadow-sm rounded-[10px] bg-skin-backend-secondary p-4 space-y-2">
                <span class="text-2xl rounded-[10px] w-[44px] h-[44px] bg-skin-backend-primary flex items-center justify-center text-skin-hover">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
                <p class="text-[16px]">Page Components</p>
                <h3 class="text-xl sm:text-[38px] font-[800] py-3">{{ formatNumberShort($data['page_components_total']) ?? 0 }}</h3>
                <p class="text-[13px] text-skin-backend-text-base text-opacity-50">{{ formatNumberShort($data['active_page_components']) ?? 0 }} active sections</p>
            </div>

            <div class="shadow-sm rounded-[10px] bg-skin-backend-secondary p-4 space-y-2">
                <span class="text-2xl rounded-[10px] w-[44px] h-[44px] bg-skin-backend-primary flex items-center justify-center text-skin-hover">
                    <i class="fa-solid fa-file-lines"></i>
                </span>
                <p class="text-[16px]">Website Pages</p>
                <h3 class="text-xl sm:text-[38px] font-[800] py-3">{{ formatNumberShort($data['pages_total']) ?? 0 }}</h3>
                <p class="text-[13px] text-skin-backend-text-base text-opacity-50">{{ formatNumberShort($data['active_pages']) ?? 0 }} active pages</p>
            </div>

            <div class="shadow-sm rounded-[10px] bg-skin-backend-secondary p-4 space-y-2">
                <span class="text-2xl rounded-[10px] w-[44px] h-[44px] bg-skin-backend-primary flex items-center justify-center text-skin-hover">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
                <p class="text-[16px]">Content To Check</p>
                <h3 class="text-xl sm:text-[38px] font-[800] py-3">{{ formatNumberShort($data['empty_component_fields']) ?? 0 }}</h3>
                <p class="text-[13px] text-skin-backend-text-base text-opacity-50">{{ formatNumberShort($data['pages_missing_breadcrumb']) ?? 0 }} empty breadcrumbs</p>
            </div>
        </div>

        <div class="grid xl:grid-cols-12 gap-8">
            <div class="xl:col-span-8 bg-skin-backend-secondary p-6 rounded-[10px]">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <h2 class="text-[20px] font-bold">Latest Inquiries</h2>
                        <p class="text-[14px] text-skin-backend-text-base text-opacity-50">New customer messages and service requests.</p>
                    </div>
                    <a href="{{ route('contact.index') }}" class="shrink-0 px-4 py-2 bg-skin-backend-accent text-skin-invert rounded-[10px] text-[13px] font-[600] hover:opacity-90 transition-opacity duration-300">Open</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                        <thead class="bg-[#323232] font-bold">
                            <tr>
                                <th class="py-3 px-4 text-start">Name</th>
                                <th class="py-3 px-4 text-start">Service</th>
                                <th class="py-3 px-4 text-start">Message</th>
                                <th class="py-3 px-4 text-start">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#ffffff06]">
                            @forelse ($data['contacts_details'] as $contact)
                                <tr>
                                    <td class="py-3 px-4">
                                        <div class="font-[600]">{{ $contact->name ?: '-' }}</div>
                                        <div class="text-[12px] text-skin-backend-text-base text-opacity-50">{{ $contact->email ?: $contact->phone }}</div>
                                    </td>
                                    <td class="py-3 px-4">{{ $contact->service ?: ($contact->subject ?: '-') }}</td>
                                    <td class="py-3 px-4 max-w-[320px]">{{ \Illuminate\Support\Str::limit($contact->message ?: $contact->description, 80) ?: '-' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[12px] {{ $contact->status == 1 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                            {{ $contact->status == 1 ? 'Viewed' : 'New' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-6 text-center text-skin-backend-text-base text-opacity-50" colspan="4">No inquiries found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="xl:col-span-4 bg-skin-backend-secondary p-6 rounded-[10px]">
                <h2 class="text-[20px] font-bold">Quick Actions</h2>
                <div class="mt-5 grid gap-3">
                    <a href="{{ route('pages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] bg-skin-backend-primary hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
                        <i class="fa-solid fa-file-lines w-5"></i>
                        <span class="font-[600] text-[14px]">Edit Pages</span>
                    </a>
                    <a href="{{ route('component.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] bg-skin-backend-primary hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
                        <i class="fa-solid fa-layer-group w-5"></i>
                        <span class="font-[600] text-[14px]">Manage Components</span>
                    </a>
                    <a href="{{ route('contact.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] bg-skin-backend-primary hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
                        <i class="fa-solid fa-headset w-5"></i>
                        <span class="font-[600] text-[14px]">View Inquiries</span>
                    </a>
                    <a href="{{ route('theme-option.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] bg-skin-backend-primary hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
                        <i class="fa-solid fa-gear w-5"></i>
                        <span class="font-[600] text-[14px]">Theme Options</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid xl:grid-cols-12 gap-8">
            <div class="xl:col-span-7 bg-skin-backend-secondary p-6 rounded-[10px]">
                <h2 class="text-[20px] font-bold">Content Status</h2>
                <div class="mt-5 overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                        <thead class="bg-[#323232] font-bold">
                            <tr>
                                <th class="py-3 px-4 text-start">Page</th>
                                <th class="py-3 px-4 text-start">Permalink</th>
                                <th class="py-3 px-4 text-start">Status</th>
                                <th class="py-3 px-4 text-start">Breadcrumb</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#ffffff06]">
                            @foreach ($data['pages'] as $page)
                                <tr>
                                    <td class="py-3 px-4 font-[600]">{{ $page->name }}</td>
                                    <td class="py-3 px-4 text-skin-backend-text-base text-opacity-60">/{{ $page->permalink }}</td>
                                    <td class="py-3 px-4">{{ $page->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td class="py-3 px-4">
                                        @if ($page->is_breadcrumb && blank($page->description))
                                            <span class="text-red-400">Empty</span>
                                        @elseif ($page->is_breadcrumb)
                                            <span class="text-green-400">Added</span>
                                        @else
                                            <span class="text-skin-backend-text-base text-opacity-50">Off</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="xl:col-span-5 bg-skin-backend-secondary p-6 rounded-[10px]">
                <h2 class="text-[20px] font-bold">Recent Activity</h2>
                <p class="text-[14px] text-skin-backend-text-base text-opacity-50">Latest admin changes.</p>

                <ul class="mt-5 space-y-4 h-[330px] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-800">
                    @forelse ($data['activities'] as $activity)
                        <li class="flex gap-3">
                            <span class="shrink-0 w-10 h-10 rounded-[10px] bg-skin-backend-primary text-skin-hover flex items-center justify-center">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </span>
                            <div>
                                <h3 class="text-[14px] font-[600]">{{ ucfirst($activity->description) }} {{ ucwords(str_replace('_', ' ', $activity->log_name ?? 'item')) }}</h3>
                                <p class="text-[12px] text-skin-backend-text-base text-opacity-50">{{ \Carbon\Carbon::parse($activity->created_at)->format('d M y h:i A') }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="text-[14px] text-skin-backend-text-base text-opacity-50">No recent activity found</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="bg-skin-backend-secondary p-6 rounded-[10px]">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-[20px] font-bold">Website Visitors</h2>
                    <p class="text-[14px] text-skin-backend-text-base text-opacity-50">{{ formatNumberShort($data['visitors']) ?? 0 }} visits this month, {{ formatNumberShort($data['visitors_total']) ?? 0 }} total visits.</p>
                </div>
                <div class="text-[14px]">
                    <span class="{{ $data['growth_percent'] >= 0 ? 'text-green-400' : 'text-red-400' }} font-bold">{{ $data['growth_percent'] }}%</span>
                    <span class="text-skin-backend-text-base text-opacity-50">than last month</span>
                </div>
            </div>
            <div id="visitorsChart" data="{{ $data['month_wise_visitors'] }}"></div>
        </div>
    </div>
</x-Deshboard-layout>
