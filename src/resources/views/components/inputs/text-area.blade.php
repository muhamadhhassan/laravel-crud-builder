<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
  <textarea class="{{ 'form-control ' . $attributes['class'] }}" name="{{ $name }}" id="{{ $attributes['id'] }}" rows="{{ $attributes['rows'] }}" placeholder="{{ $attributes['placeholder'] }}" @if($attributes['readonly']) readonly @endif @if($attributes['disabled']) disabled @endif>{{ $value }}</textarea>
  @isset($error)
    <x-crudbuilder::utils.error-message>
      <x-slot name="message">{{ $error }}</x-slot>
    </x-crudbuilder::utils.error-message>
  @endisset
  @isset($helpText)
    <span class="form-text text-muted">{{ $helpText }}</span>
  @endisset
</div>