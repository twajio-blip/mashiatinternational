@props(['message'])

<p class=" {{ $message ? 'block' : 'hiden' }} text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
