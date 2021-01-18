<div class="form-group">
    <label>{{ $attributes['label'] }}</label>
    <div class="{{ 'radio-' . $attributes['type'] }}">
        @foreach ($options as $key => $option)    
            <label class="{{ 'radio ' . $attributes['size'] }}">
                <input 
                    type="radio"
                    name="{{ $name }}"
                    value="{{ $key }}"
                    id="{{ $attributes['id'] ?? Str::random(5) }}"
                    @if($isSelected($key)) checked @endif>
                <span></span>
                &nbsp;{{ $option }}
            </label>
        @endforeach
    </div>
    @isset($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endisset
    @isset($helpText)
        <span class="form-text text-muted">{{ $helpText }}</span>
    @endisset
</div>