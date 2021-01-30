<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
  <div class="input-group" id="kt_daterangepicker_2">
    <input 
      type="text" class="{{ 'daterange form-control ' .  $attributes['class'] }}"
      readonly="readonly"
      placeholder="Select date range"
      name="{{ $name }}"
      id="{{ $attributes['id'] ?? Str::random(5) }}"
    >
    <div class="input-group-append">
      <span class="input-group-text">
        <i class="la la-calendar-check-o"></i>
      </span>
    </div>
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