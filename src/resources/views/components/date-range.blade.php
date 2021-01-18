<div class="form-group">
    <label for="{{ $name }}">{{ $attributes['label'] }}@if($mandatory) <span class="text-danger">*</span>@endif</label>
    <div class="input-group" id="kt_daterangepicker_2">
        <input 
            type="text" class="{{ 'daterange form-control ' .  $attributes['class'] }}"
            readonly="readonly"
            placeholder="Select date range"
            name="{{ $name }}"
            id="{{ $attributes['id'] ?? Str::random(5) }}">
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="la la-calendar-check-o"></i>
            </span>
        </div>
    </div>
    @isset($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endisset
    @isset($helpText)
        <span class="form-text text-muted">{{ $helpText }}</span>
    @endisset
</div>