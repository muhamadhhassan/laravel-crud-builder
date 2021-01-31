<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
  <div class="{{ 'radio-' . $attributes['type'] }}">
    @foreach ($options as $key => $option)    
      <label class="{{ 'radio ' . $attributes['size'] }}">
        <input 
          type="radio"
          name="{{ $name }}"
          value="{{ $key }}"
          id="{{ $attributes['id'] }}"
          @if($isSelected($key)) checked @endif
        >
        <span></span>
        &nbsp;{{ $option }}
      </label>
    @endforeach
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