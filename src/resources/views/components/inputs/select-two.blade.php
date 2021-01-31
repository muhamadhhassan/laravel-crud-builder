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

@prepend(config('crudbuilder.layouts.stacks.styles'))
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endprepend

@prepend(config('crudbuilder.layouts.stacks.scripts'))
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
