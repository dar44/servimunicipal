@vite(['resources/js/image_preview.js'])

<div class="card">
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <strong>Ha ocurrido un error al crear o editar el curso:</strong>
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
          <label for="name" class="form-label">Nombre del curso</label>
          <input type="text" name="name" id="name" class="form-control"
            value="{{ old('name', $curso->name ?? '') }}" required>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Descripción</label>
          <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description', $curso->description ?? '') }}</textarea>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="begining_date" class="form-label">Fecha inicio</label>
              <input type="date" name="begining_date" id="begining_date" class="form-control"
                value="{{ old('begining_date', isset($curso->begining_date) ? $curso->begining_date->format('Y-m-d') : '') }}"
                required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label for="end_date" class="form-label">Fecha fin</label>
              <input type="date" name="end_date" id="end-date" class="form-control"
                value="{{ old('end_date', isset($curso->end_date) ? $curso->end_date->format('Y-m-d') : '') }}"
                required>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label d-block">Estado</label>
          <div class="form-check form-switch">
            <input type="hidden" name="state" value="No Disponible">
            <input type="checkbox" name="state" id="state" class="form-check-input" role="switch"
              value="Disponible" {{ old('state', $curso->state ?? '') === 'Disponible' ? 'checked' : '' }}>
            <label for="state" class="form-check-label">Disponible</label>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="mb-3">
          <label for="location" class="form-label">Ubicación</label>
          <textarea name="location" id="location" rows="3" class="form-control" required>{{ old('location', $curso->location ?? '') }}</textarea>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="capacity" class="form-label">Capacidad</label>
              <input type="number" name="capacity" id="capacity" class="form-control"
                value="{{ old('capacity', $curso->capacity ?? '') }}" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="price" class="form-label">Precio (€)</label>
              <div class="input-group">
                <input type="number" name="price" id="price" step="0.01" class="form-control"
                  value="{{ old('price', $curso->price ?? '') }}" required>
                <span class="input-group-text">€</span>
              </div>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="image" class="form-label">Imagen del curso</label>
          <input type="file" name="image" id="image" class="form-control" accept="image/*">

          <div id="imagePreviewContainer" class="mt-3">
            <div id="newImagePreview" class="d-none">
              <p class="text-muted mb-1">Vista previa:</p>
              <img id="previewImage" src="#" alt="Vista previa de la nueva imagen" class="img-thumbnail"
                style="max-width: 200px;">
            </div>

            @if (!empty($curso->image))
              <div id="existingImagePreview">
                <p class="text-muted mb-1">Imagen actual:</p>
                <img src="{{ asset('storage/' . $curso->image) }}" alt="Imagen actual del curso"
                  class="img-thumbnail" style="max-width: 200px;">
              </div>
            @endif
          </div>
        </div>

      </div>
    </div>

    <div class="d-grid gap-2 mt-4">
      <button type="submit" class="btn btn-primary btn-lg">
        {{ isset($curso) ? 'Actualizar curso' : 'Crear nuevo curso' }}
      </button>
    </div>
  </div>
</div>
