@if($rows->total() > 0)
    <p class="text-xs text-skin-backend-text-base text-opacity-50 mb-3">
        Showing {{ $rows->firstItem() }}–{{ $rows->lastItem() }} of {{ $rows->total() }} {{ $rows->total() === 1 ? 'record' : 'records' }}
    </p>
@endif
<div class="w-full overflow-x-auto">
    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
        <thead class="bg-[#323232] font-bold">
            <tr>
                @foreach($columns as $col)
                    <th class="py-3 text-start min-w-[120px] px-4 {{ !$loop->first ? 'border-l border-default border-opacity-[6%]' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $col)) }}
                    </th>
                @endforeach
                <th class="py-3 text-center w-[120px] px-4 border-l border-default border-opacity-[6%]">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#ffffff06]">
            @forelse($rows as $row)
                <tr class="text-xs">
                    @foreach($columns as $col)
                        <td class="py-3 px-4 {{ !$loop->first ? 'border-l border-default border-opacity-[6%]' : '' }}">
                            @php
                                $val = $row->{$col} ?? '';
                                $field = $dynamicComponent->componentFiled->where('group', 1)->firstWhere('name', $col);
                                $fieldType = $field->type ?? null;
                                $isFileLike = in_array($fieldType, ['file', 'upload', 'upload_multi'], true);
                            @endphp

                            @if($isFileLike)
                                @php
                                    $names = [];
                                    if (is_string($val) && (Str::startsWith($val, '[') || Str::startsWith($val, '{'))) {
                                        $decoded = json_decode($val, true);
                                        if (is_array($decoded)) {
                                            foreach ($decoded as $v) {
                                                $names[] = is_string($v) ? $v : (string) $v;
                                            }
                                        }
                                    } elseif($val !== null && $val !== '') {
                                        $names[] = (string) $val;
                                    }
                                    $totalNames = count($names);
                                    $displayNames = array_slice($names, 0, 3);
                                @endphp
                                @if(empty($displayNames))
                                    <span class="text-skin-backend-text-base text-opacity-50">—</span>
                                @else
                                    <div class="flex items-center gap-1 flex-wrap">
                                        @foreach($displayNames as $fileName)
                                            @php
                                                $fileUrl = Str::startsWith($fileName, ['http://', 'https://', '/']) ? $fileName : asset('images/' . $fileName);
                                                $lower = strtolower($fileName);
                                                $isImage = Str::endsWith($lower, ['.jpg', '.jpeg', '.png', '.webp', '.gif', '.bmp', '.svg']);
                                            @endphp
                                            @if($isImage)
                                                <img src="{{ $fileUrl }}" alt="" class="w-10 h-10 object-cover rounded border border-default border-opacity-25">
                                            @else
                                                <a href="{{ $fileUrl }}" target="_blank" class="text-[11px] text-skin-backend-accent underline break-all max-w-[120px]">
                                                    {{ Str::limit($fileName, 20) }}
                                                </a>
                                            @endif
                                        @endforeach
                                        @if($totalNames > 3)
                                            <span class="text-[11px] text-skin-backend-text-base opacity-60">
                                                +{{ $totalNames - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            @else
                                {{ Str::limit(strip_tags($val), 50) ?: '—' }}
                            @endif
                        </td>
                    @endforeach
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-x-2">
                            <a href="{{ route('dynamic-component.edit', [$dynamicComponent->name, $row->id ?? $row->_group ?? $row->id]) }}"
                                class="inline-flex items-center justify-center w-[26px] h-[26px] bg-[#3762ED] rounded-full hover:bg-opacity-90">
                                <i class="fa-solid fa-pen-to-square text-white text-xs"></i>
                            </a>
                            <button type="button" data-id="{{ $row->id ?? $row->_group ?? '' }}"
                                data-hs-overlay="#hs-danger-alert"
                                class="delete-btn inline-flex items-center justify-center w-[26px] h-[26px] bg-[#E61714] rounded-full hover:bg-opacity-90">
                                <i class="fa-solid fa-trash-can text-white text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) + 1 }}" class="px-4 py-8 text-center text-skin-backend-text-base text-opacity-50">
                        No data found. <a href="{{ route('dynamic-component.create', $dynamicComponent->name) }}" class="text-skin-backend-accent hover:underline">Add first record</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($rows->hasPages())
    <div class="flex justify-end mt-4">
        <x-backend.pagination :paginator="$rows" />
    </div>
@endif
