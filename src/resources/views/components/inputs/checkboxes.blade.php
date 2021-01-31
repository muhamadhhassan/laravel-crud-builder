<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
  <div class="{{ 'checkbox-' . $attributes['type'] }}">
    @foreach ($options as $key => $option)    
      <label class="{{ 'checkbox ' . $attributes['size'] }}">
        <input 
          type="checkbox"
          name="{{ $name }}"
          id="{{ $attributes['id'] }}"
          value="{{ $key }}"
          @if($isChecked($key)) checked @endif
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