<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
  <div></div>
  <div class="custom-file">
    <input type="file" class="custom-file-input" id="{{ $attributes['id'] }}" name="{{ $attributes['name'] }}">
    <label class="custom-file-label" for="{{ $attributes['name'] }}">Choose file</label>
  </div>
  @isset($error)
    <x-crudbuilder::utils.error-message>
      <x-slot name="message">{{ $error }}</x-slot>
    </x-crudbuilder::utils.error-message>
  @endisset
  @isset($helpText)
    <span class="form-text text-muted">{{ $helpText }}</span>
  @endisset
</div>