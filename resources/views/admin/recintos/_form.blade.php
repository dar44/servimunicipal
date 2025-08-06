@vite(['resources/js/image_preview.js'])

<div class="card">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ha ocurrido un error al crear o editar el recinto:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del recinto</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $recinto->name ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description', $recinto->description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="ubication" class="form-label">Ubicación</label>
                    <input type="text" name="ubication" id="ubication" class="form-control"
                        value="{{ old('ubication', $recinto->ubication ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="province" class="form-label">Provincia</label>
                    <input type="text" name="province" id="province" class="form-control"
                        value="{{ old('province', $recinto->province ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="postal_code" class="form-label">Código Postal</label>
                    <input type="text" name="postal_code" id="postal_code" class="form-control"
                        value="{{ old('postal_code', $recinto->postal_code ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Estado</label>
                    <div class="form-check form-switch">
                        <input type="hidden" name="state" value="0">
                        <input type="checkbox" name="state" id="state" class="form-check-input" role="switch"
                            value="1" {{ old('state', $recinto->state ?? 0) == 1 ? 'checked' : '' }}>
                        <label for="state" class="form-check-label">Activo</label>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="image" class="form-label">Imagen del recinto</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">

                    <div id="imagePreviewContainer" class="mt-3">
                        <div id="newImagePreview" class="d-none">
                            <p class="text-muted mb-1">Vista previa:</p>
                            <img id="previewImage" src="#" alt="Vista previa de la nueva imagen" class="img-thumbnail"
                                style="max-width: 200px;">
                        </div>

                        @if (!empty($recinto->image))
                        <div id="existingImagePreview">
                            <p class="text-muted mb-1">Imagen actual:</p>
                            <img src="{{ asset('storage/' . $recinto->image) }}" alt="Imagen actual del recinto"
                                class="img-thumbnail" style="max-width: 200px;">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            -->
        </div>
        

        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                {{ isset($recinto) ? 'Actualizar recinto' : 'Crear nuevo recinto' }}
            </button>
        </div>
    </div>
</div>
