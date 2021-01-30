<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
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