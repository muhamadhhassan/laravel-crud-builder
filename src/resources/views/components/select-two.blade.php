<div class="form-group">
    <label class="col-form-label">{{ $attributes['label'] }}@if($mandatory) <span class="text-danger">*</span>@endif</label>
    <select 
        class="{{ 'form-control kt-select2 select2 ' . $attributes['class'] }}"
        id="{{ $attributes['id'] ?? Str::random(5) }}"
        name="{{ $name }}[]"
        multiple
        @if($attributes['disabled']) disabled @endif>
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" @if($isSelected($key)) selected @endif>{{ $option }}</option>
        @endforeach
    </select>
    @isset($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endisset
    @isset($helpText)
        <span class="form-text text-muted">{{ $helpText }}</span>
    @endisset
</div>

{{-- Scripts Section --}}
@section('scripts')
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
@endsection
