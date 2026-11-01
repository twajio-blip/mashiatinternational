<x-Deshboard-layout>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-16">
        <!-- Card -->
        <div class="shadow-sm rounded-[10px] bg-skin-backend-secondary p-4 space-y-2">
            <span
                class="text-2xl rounded-[10px] w-[44px] h-[44px] bg-skin-backend-primary flex items-center justify-center text-skin-hover">
                <i class="fa-solid fa-file-pen"></i>
            </span>
            <p class="text-[18px] text-skin-backend-text-base">
                Blog Posts
            </p>
            <h3 class="text-xl sm:text-[40px] font-[800] text-skin-backend-text-base py-3">
                {{ formatNumberShort($data['blog_post']) ?? 0 }}
            </h3>
        </div>
        <div class="shadow-sm rounded-[10px] bg-skin-backend-secondary p-4 space-y-2">
            <span
                class="text-2xl rounded-[10px] w-[44px] h-[44px] bg-skin-backend-primary flex items-center justify-center text-skin-hover">
                <i class="fa-solid fa-users"></i>
            </span>
            <p class="text-[18px] text-skin-backend-text-base">
                Website Visitors
            </p>
            <h3 class="text-xl sm:text-[40px] font-[800] text-skin-backend-text-base py-3">
                {{ formatNumberShort($data['visitors']) ?? 0 }}
            </h3>
        </div>
        <div class="shadow-sm rounded-[10px] bg-skin-backend-secondary p-4 space-y-2">
            <span
                class="text-2xl rounded-[10px] w-[44px] h-[44px] bg-skin-backend-primary flex items-center justify-center text-skin-hover">
                <i class="fa-solid fa-user-plus"></i>
            </span>
            <p class="text-[18px] text-skin-backend-text-base">
                Subscribers
            </p>
            <h3 class="text-xl sm:text-[40px] font-[800] text-skin-backend-text-base py-3">
                {{ formatNumberShort($data['subscribers']) ?? 0 }}
            </h3>
        </div>
        <div class="shadow-sm rounded-[10px] bg-skin-backend-secondary p-4 space-y-2">
            <span
                class="text-2xl rounded-[10px] w-[44px] h-[44px] bg-skin-backend-primary flex items-center justify-center text-skin-hover">
                <i class="fa-solid fa-headset"></i>
            </span>
            <p class="text-[18px] text-skin-backend-text-base">
                Contact
            </p>
            <h3 class="text-xl sm:text-[40px] font-[800] text-skin-backend-text-base py-3">
                {{ formatNumberShort($data['contacts']) ?? 0 }}
            </h3>
        </div>
        <!-- End Card -->
    </div>

    <div class="mt-8 bg-skin-backend-secondary p-6 rounded-xl text-skin-backend-text-base">
        <!-- Card -->
        <div class="relative">
            <h2 class="text-[20px] font-bold absolute">Total Site Visitor</h2>
            <div class="text-center">
                <h2 class="text-[16px]">Total Site Visitor</h2>
                <div class="text-[30px] font-bold text-skin-hover mt-2">{{ $data['visitors_total'] }}</div>
                <div class="text-[16px] mb-4"><span class="text-green-400 font-bold">+{{ $data['growth_percent'] }}
                        %</span> than last month</div>
            </div>
        </div>
        <div id="visitorsChart" data="{{ $data['month_wise_visitors'] }}"></div>
        <!-- End Card -->
    </div>
    <div class="lg:grid grid-cols-12 gap-8 mt-8 space-y-4 lg:space-y-0">
        <div class="col-span-12 lg:col-span-8 bg-skin-backend-secondary p-6 rounded-xl text-skin-backend-text-base">
            <h2 class="text-[20px] font-bold">Site Visitor By Device: Mobile vs PC</h2>
            <!-- Card -->
            <div class="h-full flex flex-col items-center justify-center">
                <div id="visitorsByDeviceChart" class="w-full" data="{{ $data['device_wise_visitors'] }}"></div>
            </div>

            <!-- End Card -->
        </div>
        <div class="col-span-12 lg:col-span-4 bg-skin-backend-secondary p-6 rounded-xl text-skin-backend-text-base">
            <div class="space-y-2">
                <h2 class="text-[20px] font-bold">New Subscribers</h2>
                <h3 class="text-[14px] text-skin-backend-text-base text-opacity-25">You have
                    {{ formatNumberShort($data['subscribers']) ?? 0 }} new
                    {{ formatNumberShort($data['subscribers']) > 1 ? 'subscribers' : 'subscriber' }}</h3>
            </div>
            <!-- Card -->
            <ul
                class="my-4 space-y-4 h-[300px] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-800">
                @foreach ($data['subscribers_details'] as $subscribers_detail)
                    <li class="flex items-center gap-4">
                        <span
                            class="shrink-0 w-[50px] h-[50px] flex items-center justify-center rounded-[10px] bg-skin-backend-primary text-skin-hover text-xl"><i
                                class="fa-solid fa-user-plus"></i></span>
                        <div class="text-[14px]">
                            <h3 class="text-skin-backend-text-base">
                                {{ \Carbon\Carbon::parse($subscribers_detail->created_at)->format('d M y h:i A') }}


                            </h3>

                            <h2 class="text-skin-backend-text-base text-opacity-25 break-all">
                                {{ $subscribers_detail->email }}</h2>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div>
                <a href="{{ route('subscriber.index') }}"
                    class="block text-center px-6 py-3 bg-skin-backend-accent text-skin-invert rounded-[10px] text-[14px] font-[600] hover:opacity-90 transition-opacity duration-300">View
                    More</a>
            </div>
            <!-- End Card -->
        </div>
        <div class="col-span-12 lg:col-span-8 bg-skin-backend-secondary p-6 rounded-xl text-skin-backend-text-base">
            <div class="space-y-4">
                <h2 class="text-[20px] font-bold">Recent Activity</h2>
                <h3 class="text-[14px] text-skin-backend-text-base text-opacity-25">Maiores dicta atque dolorem
                    temporibus </h3>
            </div>

            <!-- Card -->
            <!--
            Activity Timeline
            This section displays a vertical scrollable timeline of system activities, such as created or updated events.
            -->
            <ul
                class="[&>:last-child_span]:after:hidden pt-8 h-[330px] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-800">

                @foreach ($data['activities'] as $activity)
                    <li class="relative pl-8 pb-6">

                        <!--
                        Timeline Dot and Vertical Connector Line
                        - Dot represents the activity point
                        - Line visually connects the items vertically
                    -->
                        <div class="h-full absolute top-0 left-0">
                            <span
                                class="w-4 inline-block relative h-full 
                            before:absolute before:top-0 before:left-1/2 
                            before:bg-skin-backend-secondary before:z-30 
                            before:w-4 before:h-4 before:rounded-full 
                            before:border-4 before:border-highlight 
                            before:-translate-x-1/2 before:translate-y-[10px]
                            after:absolute after:w-[1px] after:h-full 
                            after:left-1/2 after:top-0 
                            after:-translate-x-1/2 after:translate-y-[10px] 
                            after:bg-[#e3e3e3] after:bg-opacity-80 after:z-20">
                            </span>
                        </div>

                        <!-- Activity Content Block -->
                        <div class="space-y-2">
                            <!-- Display formatted activity timestamp -->
                            <h2 class="text-skin-backend-text-base text-[14px] font-[500]">
                                {{ \Carbon\Carbon::parse($activity->created_at)->format('F jS, h:i A') }}
                            </h2>

                            <p class="text-[14px] text-skin-backend-text-base text-opacity-70 leading-relaxed">
                                @php
                                    // Fields we don't want to show in the changes list
$ignoredFields = ['updated_at', 'created_at', 'deleted_at'];

// Placeholder for formatted change messages
$changes = [];

// Get new and old values from activity properties
$newData = $activity->properties['attributes'] ?? [];
$oldData = $activity->properties['old'] ?? [];

// Format the log name (e.g., "user_login" → "User Login")
$logName = ucwords(str_replace('_', ' ', $activity->log_name ?? 'Item'));

// Format action name (e.g., "created", "updated")
$action = ucfirst($activity->description);

// Helper function to limit length of string content
$truncate = function ($text, $limit = 150) {
    if (is_array($text) || is_object($text)) {
        $text = json_encode($text);
    }
    $text = (string) $text;
    return strlen($text) > $limit ? substr($text, 0, $limit) . '...' : $text;
};

// Handle 'updated' activity: Compare old vs. new data
if ($activity->description === 'updated') {
    foreach ($newData as $field => $newValue) {
        if (in_array($field, $ignoredFields)) {
            continue;
        }

        $oldValue = $oldData[$field] ?? null;

        // If the field value changed, add to the list
        if ($oldValue !== null && $oldValue != $newValue) {
            $fieldLabel = ucwords(str_replace('_', ' ', $field));

            $changes[] =
                "<strong>{$fieldLabel}</strong> changed from “<span class='text-skin-hover'>" .
                e($truncate($oldValue)) .
                "</span>” to “<span class='text-green-600'>" .
                e($truncate($newValue)) .
                '</span>”.';
        }
    }
}

// Handle 'created' activity (optional): You may want to list created fields if needed
elseif ($activity->description === 'created') {
    foreach ($newData as $field => $value) {
        if (in_array($field, $ignoredFields)) {
            continue;
        }

        // Currently does nothing — you can show "Field: Value" if needed
        $fieldLabel = ucwords(str_replace('_', ' ', $field));
                                        }
                                    }
                                @endphp

                                <!-- Display the summary of the action -->
                                <strong>{{ $action }} {{ $logName }}</strong>

                                <!-- Display a detailed list of changes if available -->
                                @if (count($changes))
                                    <ul class="mt-1 list-disc list-inside space-y-1 text-sm">
                                        @foreach ($changes as $change)
                                            <li>{!! $change !!}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </p>
                        </div>
                    </li>
                @endforeach

            </ul>
            <!-- End Card -->
        </div>
        <div class="col-span-12 lg:col-span-4 bg-skin-backend-secondary p-6 rounded-xl text-skin-backend-text-base">
            <div class="space-y-2">
                <h2 class="text-[20px] font-bold">Contacts</h2>
                <h3 class="text-[14px] text-skin-backend-text-base text-opacity-25">You have
                    {{ formatNumberShort($data['contacts']) ?? 0 }} new
                    {{ formatNumberShort($data['contacts']) > 1 ? 'contacts' : 'contact' }}</h3>
            </div>
            <!-- Card -->
            <ul
                class="my-4 space-y-4 h-[300px] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-800">
                @foreach ($data['contacts_details'] as $contacts_detail)
                    <li class="flex items-center gap-4">
                        <span
                            class="shrink-0 w-[50px] h-[50px] flex items-center justify-center rounded-[10px] bg-skin-backend-primary text-skin-hover text-xl"><i
                                class="fa-solid fa-comment"></i></span>
                        <div class="text-[14px]">
                            <h3 class="text-skin-backend-text-base">{{ $contacts_detail->name }}</h3>
                            <h2 class="text-skin-backend-text-base text-opacity-25 line-clamp-2">
                                {{ $contacts_detail->subject }}</h2>
                        </div>
                    </li>
                @endforeach

            </ul>
            <div>
                <a href="#"
                    class="block text-center px-6 py-3 bg-skin-backend-accent text-skin-invert rounded-[10px] text-[14px] font-[600] hover:opacity-90 transition-opacity duration-300">View
                    More</a>
            </div>
            <!-- End Card -->
        </div>
    </div>



</x-Deshboard-layout>
