@props(['messages'])

@if ($messages)
    <div class="mt-1">
        @foreach ((array) $messages as $message)
            <div class="text-danger text-sm">{{ $message }}</div>
        @endforeach
    </div>
@endif
