<div class="form-group">
    <label>{{ $attributes['label'] }}@if($mandatory) <span class="text-danger">*</span>@endif</label>
    <div></div>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="{{ $attributes['id'] ?? Str::random(5) }}" name="{{ $attributes['name'] }}">
        <label class="custom-file-label" for="{{ $attributes['name'] }}">Choose file</label>
    </div>
    @isset($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endisset
    @isset($helpText)
        <span class="form-text text-muted">{{ $helpText }}</span>
    @endisset
</div>