<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
  <select
    class="{{ 'form-control ' . $attributes['class']}}"
    id="{{ $attributes['id'] }}"
    name="{{ $name }}"
    @if($attributes['disabled']) disabled @endif
  >
    <option value="" disabled selected>{{ $attributes['placeholder'] }}</option>
    @foreach ($options as $key => $option)
      <option value="{{ $key }}" @if($selected == $key) selected @endif>{{ $option }}</option>
    @endforeach
  </select>
  @isset($error)
    <x-crudbuilder::utils.error-message>
      <x-slot name="message">{{ $error }}</x-slot>
    </x-crudbuilder::utils.error-message>
  @endisset
  @isset($helpText)
    <span class="form-text text-muted">{{ $helpText }}</span>
  @endisset
</div>