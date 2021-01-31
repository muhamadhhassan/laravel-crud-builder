<div class="form-group">
  @if($attributes['label'])
    <x-crudbuilder::utils.input-label :label="$attributes['label']" :name="$name" :mandatory="$mandatory"/>
  @endif
  <div 
    id="{{ $attributes['id'] }}"
    class="{{ $attributes['class'] }}">
    {!! $value !!}
  </div>
  <input type="hidden" name="{{ $name }}" id="{{ $attributes['id'].'value' }}">
  @isset($error)
    <div class="invalid-feedback">{{ $error }}</div>
  @endisset
  @isset($helpText)
    <span class="form-text text-muted">{{ $helpText }}</span>
  @endisset
</div>

@prepend(config('crudbuilder.layouts.stacks.styles'))
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
@endprepend

@prepend(config('crudbuilder.layouts.stacks.scripts'))
  <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var quill = new Quill('{{ '#' . $attributes['id'] }}', {
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline', 'strike', 'image'],        // toggled buttons
            ['blockquote', 'code-block'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'font': [] }],
            [{ 'align': [] }],
            ['clean']                                         // remove formatting button
          ]
        },
        theme: 'snow'
      });

      $("{{'#'.$attributes['id'].'value'}}").val(quill.container.firstChild.innerHTML);

      quill.on('text-change', function(delta, oldDelta, source) {
        $("{{'#'.$attributes['id'].'value'}}").val(quill.container.firstChild.innerHTML);
      });
    });
  </script>
@endprepend
