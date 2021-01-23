@foreach ($fields as $field)
  <x-dynamic-component
    component="crudbuilder::{{ $field->type }}"
    :resource="$resource ?? null"
    :type="$field->textType"
    :options="$field->options"
    :taggable="$field->taggable"
    :name="$field->name"
    class="{{ $errors->get($field->name) ? 'is-invalid' : '' }}"
    :id="$field->name"
    :label="$field->label"
    :placeholder="$field->placeholder"
    :help-text="$field->helpText"
    :mandatory="$field->mandatory">
    <x-slot name="helpText">{{ $field->helpText }}</x-slot>
    @error($field->name)
      <x-slot name="error">{{ $message }}</x-slot>
    @enderror
  </x-dynamic-component>
@endforeach