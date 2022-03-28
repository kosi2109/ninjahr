@props(['name'])
<label for="{{$name}}" {{ $attributes->merge(['class' => 'form-label']) }}>
    {{ucwords($name)}}
</label>
