@vite(['resources/js/image_preview.js'])
@vite(['resources/js/password.js'])

<div class="card">
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <strong>Ha ocurrido un error en el registro:</strong>
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
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}" required>
          @error('name')
            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="surname" class="form-label">Apellidos</label>
          <input type="text" name="surname" id="surname" class="form-control @error('surname') is-invalid @enderror"
            value="{{ old('surname', $user->surname ?? '') }}" required>
          @error('surname')
            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="dni" class="form-label">DNI</label>
          <input type="text" name="dni" id="dni" class="form-control @error('dni') is-invalid @enderror"
            value="{{ old('dni', $user->dni ?? '') }}" required>
          @error('dni')
            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Teléfono</label>
          <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $user->phone ?? '') }}" required>
          @error('phone')
            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
          @enderror
        </div>
      </div>

      <div class="col-md-6">
        <div class="mb-3">
          <label for="email" class="form-label">Correo electrónico</label>
          <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email ?? '') }}" required>
          @error('email')
            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <div class="input-group">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="bi bi-eye" id="togglePasswordIcon"></i>
            </button>
          </div>
          @error('password')
            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="role" class="form-label">Rol</label>
          <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
            <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>Usuario normal</option>
            <option value="worker" {{ old('role', $user->role ?? '') === 'worker' ? 'selected' : '' }}>Trabajador municipal</option>
          </select>
          @error('role')
            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="image" class="form-label">Imagen de perfil (opcional)</label>
          <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror"
            accept="image/*">
          @error('image')
            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
          @enderror

          <div id="imagePreviewContainer" class="mt-3">
            <div id="newImagePreview" class="d-none">
              <p class="text-muted mb-1">Vista previa:</p>
              <img id="previewImage" src="#" alt="Vista previa de la imagen" class="img-thumbnail"
                style="max-width: 200px;">
            </div>

            @if (!empty($user->image))
              <div id="existingImagePreview">
                <p class="text-muted mb-1">Imagen actual:</p>
                <img src="{{ asset('storage/' . $user->image) }}" alt="Imagen actual del usuario"
                  class="img-thumbnail" style="max-width: 200px;">
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="d-grid gap-2 mt-4">
      <button type="submit" class="btn btn-primary btn-lg">
        {{ isset($user) ? 'Actualizar usuario' : 'Registrar usuario' }}
      </button>
    </div>
  </div>
</div>
