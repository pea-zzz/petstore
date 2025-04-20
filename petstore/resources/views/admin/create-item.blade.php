@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Add New Item</h1>

    <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" maxlength="255"><br>
        @error('name')
            <div style="color: red;">Please fill in this field</div>
        @enderror
        <br>

        <label>Price (RM):</label>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}" min="0"><br>
        @error('price')
            <div style="color: red;">Please fill in this field</div>
        @enderror
        <br>

        <label>Stock:</label>
        <input type="number" name="stock" value="{{ old('stock') }}" min="1"><br>
        @error('stock')
            <div style="color: red;">Please fill in this field</div>
        @enderror
        <br>

        <label>Category:</label>
        <select name="category_id">
            <option value="">-- Select --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select><br>
        @error('category_id')
            <div style="color: red;">Please select a category</div>
        @enderror
        <br>

        <label>Description:</label>
        <textarea name="description" rows="5" maxlength="5000">{{ old('description') }}</textarea><br>
        @error('description')
            <div style="color: red;">Please fill in this field</div>
        @enderror
        <br>

        <label>Item Image (Main):</label>
        <input type="file" name="image" accept="image/*"><br>
        @error('image')
            <div style="color: red;">Please upload an image</div>
        @enderror
        <br>

        <label>Additional Images:</label>
        <input type="file" name="images[]" multiple accept="image/*"><br>
        @error('images')
            <div style="color: red;">Please upload additional images if required</div>
        @enderror
        <br>

        <label>Selections (optional):</label>
        <div id="selections">
            <div class="selection-row">
                <input type="text" name="selections[0][option]" placeholder="Option name" value="{{ old('selections.0.option') }}"><br>
                <input type="file" name="selections[0][image_url]" accept="image/*"><br>
            </div>
        </div>
        @error('selections')
            <div style="color: red;">Please fill in valid selections</div>
        @enderror
        @error('selections.*.option')
            <div style="color: red;">Please provide an option name</div>
        @enderror
        @error('selections.*.image_url')
            <div style="color: red;">Please upload an image for the selection</div>
        @enderror

        <button type="button" onclick="addSelection()">+ Add Option</button><br><br>
        <br>

        <button type="submit">Add Item</button>
    </form>
</div>

<script>
let selectionIndex = 1;
function addSelection() {
    const container = document.getElementById('selections');
    const row = document.createElement('div');
    row.className = 'selection-row';
    row.innerHTML = `
        <input type="text" name="selections[${selectionIndex}][option]" placeholder="Option name"><br>
        <input type="file" name="selections[${selectionIndex}][image_url]" accept="image/*"><br>
    `;
    container.appendChild(row);
    selectionIndex++;
}
</script>
@endsection
