<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
  <select 
    class="{{ 'form-control kt-select2 select2 ' . $attributes['class'] }}"
    id="{{ $attributes['id'] }}"
    name="{{ $name }}[]"
    multiple
    @if($attributes['disabled']) disabled @endif
  >
    @foreach ($options as $key => $option)
      <option value="{{ $key }}" @if($isSelected($key)) selected @endif>{{ $option }}</option>
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

@prepend(config('crudbuilder.layouts.stacks.scripts'))
  @if ($taggable)    
    <script>
      $(document).ready(function() {
        $('.select2').select2({
          tags: true
        });
      });
    </script>
  @else
    <script>
      $(document).ready(function() {
        $('.select2').select2();
      });
    </script>
  @endif
@endprepend
