@props(['id', 'name', 'value'])

<label for="{{ $id }}" class="inline-flex items-center cursor-pointer">
    
    <input type="checkbox"  
           id="{{ $id }}"  
           name="{{ $name }}" 
           {{ $value ? 'checked' : '' }}
           class="sr-only peer">
           
    <div {{ $attributes->merge(['class' => 'relative w-11 h-6 bg-[#323232] rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:bg-skin-backend-accent peer-focus:ring-2 peer-focus:ring-yellow-500 peer-focus:outline-none  peer-checked:after:border-white after:content-[""] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all']) }}></div>
</label>
