<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
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
    <x-crudbuilder::utils.error-message>
      <x-slot name="message">{{ $error }}</x-slot>
    </x-crudbuilder::utils.error-message>
  @endisset
  @isset($helpText)
    <x-crudbuilder::utils.help-text>
      <x-slot name="text">{{ $helpText }}</x-slot>
    </x-crudbuilder::utils.help-text>
  @endisset
</div>