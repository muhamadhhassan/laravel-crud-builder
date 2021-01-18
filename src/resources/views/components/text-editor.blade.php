<div class="form-group">
    <label class="col-form-label">{{ $attributes['label'] }}@if($mandatory) <span class="text-danger">*</span>@endif</label>
    <textarea 
        id="{{ $attributes['id'] ?? Str::random(5) }}"
        class="{{ 'summernote ' . $attributes['class'] }}"
        name="{{ $name }}">
        {!! $value !!}
    </textarea>
    @isset($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endisset
    @isset($helpText)
        <span class="form-text text-muted">{{ $helpText }}</span>
    @endisset
</div>