@foreach($fields as $field_key => $field)
    <div class="mb-10">
        <label class="form-label">{{ $field['title'] }}</label>
        <input type="text" name="fields[{{ $field_key }}]" class="form-control mb-2" value="{{ $field['value'] ?? '' }}">
        @error('fields.' . $field_key)
            <div class="form-errors text-danger fs-7 mt-2">{{ $message }}</div>
        @enderror
    </div>
@endforeach
