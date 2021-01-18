<div class="form-group">
    <label for="{{ $name }}">{{ $attributes['label'] }} @if($mandatory)<span class="text-danger">*</span>@endif</label>
    <input
        type="{{ $attributes['type'] }}"
        class="{{ 'form-control ' . $attributes['class'] }}"
        placeholder="{{ $attributes['placeholder'] }}"
        name="{{ $name }}"
        value="{{ isset($value) && $attributes['type'] == 'date' ? $value->format('Y-m-d') : $value }}"
        id="{{ $attributes['id'] ?? Str::random(5) }}"
        @if($attributes['readonly']) readonly @endif
        @if($attributes['disabled']) disabled @endif
    >
    @isset($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endisset
    @isset($helpText)
        <span class="form-text text-muted">{{ $helpText }}</span>
    @endisset
</div>