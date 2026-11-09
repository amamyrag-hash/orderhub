@csrf

<div>
    <label>نام</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}">
    @error('name') <small style="color:red">{{ $message }}</small> @enderror
</div>

<div>
    <label>SKU</label>
    <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}">
    @error('sku') <small style="color:red">{{ $message }}</small> @enderror
</div>

<div>
    <label>قیمت</label>
    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}">
    @error('price') <small style="color:red">{{ $message }}</small> @enderror
</div>

<div>
    <label>توضیحات</label>
    <textarea name="description">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<button type="submit">ذخیره</button>