<div class="form-group">
    <label for="{{ $name }}">{{ $attributes['label'] }} @if($mandatory) <span class="text-danger">*</span>@endif</label>
    <select
        class="{{ 'form-control ' . $attributes['class']}}"
        id="{{ $attributes['id'] ?? Str::random(5) }}"
        name="{{ $name }}"
        @if($attributes['disabled']) disabled @endif>
        <option value="" disabled selected>{{ $attributes['placeholder'] }}</option>
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" @if($selected == $key) selected @endif>{{ $option }}</option>
        @endforeach
    </select>
    @isset($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endisset
    @isset($helpText)
        <span class="form-text text-muted">{{ $helpText }}</span>
    @endisset
</div>