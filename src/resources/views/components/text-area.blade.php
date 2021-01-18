<div class="form-group">
    <label for="{{ $name }}">{{ $attributes['label'] }} @if($mandatory)<span class="text-danger">*</span>@endif</label>
    <textarea class="{{ 'form-control ' . $attributes['class'] }}" name="{{ $name }}" id="{{ $attributes['id'] ?? Str::random(5) }}" rows="{{ $attributes['rows'] }}" placeholder="{{ $attributes['placeholder'] }}" @if($attributes['readonly']) readonly @endif @if($attributes['disabled']) disabled @endif>{{ $value }}</textarea>
    @isset($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endisset
    @isset($helpText)
        <span class="form-text text-muted">{{ $helpText }}</span>
    @endisset
</div>