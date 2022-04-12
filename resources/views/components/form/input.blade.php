@props(['name','value'=>old($name),'type'=>'text','label'=>ucwords($name)])
<div class="mb-3">
    <label for="{{$name}}" class="form-label">
        {{$label}}
    </label>
    @if ($type == "textarea")
        <textarea name="{{$name}}" class="form-control" id="{{$name}}">{{$value}}</textarea>
    @else
        <input value="{{$value}}" name="{{$name}}" type="{{$type}}" class="form-control" id="{{$name}}">
    @endif
</div>   