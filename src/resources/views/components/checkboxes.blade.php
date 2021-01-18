<div class="form-group">
    <label>{{ $attributes['label'] }}</label>
    <div class="{{ 'checkbox-' . $attributes['type'] }}">
        @foreach ($options as $key => $option)    
            <label class="{{ 'checkbox ' . $attributes['size'] }}">
                <input 
                    type="checkbox"
                    name="{{ $name }}"
                    id="{{ $attributes['id'] ?? Str::random(5) }}"
                    value="{{ $key }}"
                    @if($isChecked($key)) checked @endif>
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