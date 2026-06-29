@extends('layouts.create')

@section('page-title', 'Nuevo Usuario')
@section('back-url', route('usuario.index'))

@section('form-content')
    <style>
        /* Google Fonts - Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body{
            background-color: #e3f2fd;
        }
        .container{
            position: relative;
            max-width: 320px;
            width: 100%;
            margin: 80px auto 30px;
        }
        .select-btn{
            display: flex;
            height: 50px;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            border-radius: 8px;
            cursor: pointer;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }
        .select-btn .btn-text{
            font-size: 17px;
            font-weight: 400;
            color: #333;
        }
        .select-btn .arrow-dwn{
            display: flex;
            height: 21px;
            width: 21px;
            color: #fff;
            font-size: 14px;
            border-radius: 50%;
            background: #6e93f7;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }
        .select-btn.open .arrow-dwn{
            transform: rotate(-180deg);
        }
        .list-items{
            position: relative;
            margin-top: 15px;
            border-radius: 8px;
            padding: 16px;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            display: none;
        }
        .select-btn.open ~ .list-items{
            display: block;
        }
        .list-items .item{
            display: flex;
            align-items: center;
            list-style: none;
            height: 50px;
            cursor: pointer;
            transition: 0.3s;
            padding: 0 15px;
            border-radius: 8px;
        }
        .list-items .item:hover{
            background-color: #e7edfe;
        }
        .item .item-text{
            font-size: 16px;
            font-weight: 400;
            color: #333;
        }
        .item .checkbox{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 16px;
            width: 16px;
            border-radius: 4px;
            margin-right: 12px;
            border: 1.5px solid #c0c0c0;
            transition: all 0.3s ease-in-out;
        }
        .item.checked .checkbox{
            background-color: #4070f4;
            border-color: #4070f4;
        }
        .checkbox .check-icon{
            color: #fff;
            font-size: 11px;
            transform: scale(0);
            transition: all 0.2s ease-in-out;
        }
        .item.checked .check-icon{
            transform: scale(1);
        }
    </style>
    <form id="form-usuario" action="{{ route('usuario.update', $usuario->id) }}" method="POST">
        @method('PUT')
        @csrf 
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label>Persona</label>
                <input type="text" class="form-control" value="{{ $usuario->persona->Nombre_1 . $usuario->persona->Apellido_1}}" readonly>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" value="{{ $usuario->Email }}" readonly>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label for="Username" class="form-label">Nombre de Usuario</label>
                <input type="text" step="0.01" class="form-control @error('Username') is-invalid @enderror" id="Username" name="Username" placeholder="Pepex" value="{{ old('Username') ?? $usuario->Username }}">
                @error('Username') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-12">
                <label for="Cambiar_Password" class="form-label">Cambiar Password</label>
                <input type="checkbox" name="check_cambiar_password" id="check_cambiar_password">
                <input type="text" class="form-control @error('Cambiar_Password') is-invalid @enderror" id="Cambiar_Password" name="Cambiar_Password"></input>
                @error('Cambiar_Password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-12">
                <label for="Cambiar_Password_confirmation" class="form-label">Confirmar nueva password</label>
                <input type="text" class="form-control @error('Cambiar_Password_confirmation') is-invalid @enderror" id="Cambiar_Password_confirmation" name="Cambiar_Password_confirmation"></input>
                @error('Cambiar_Password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="container">
            Roles
            <div class="select-btn">
                <span class="btn-text">Seleccionar</span>
                <span class="arrow-dwn">
                    <i class="fa-solid fa-chevron-down"></i>
                </span>
            </div>

            <ul class="list-items">
                @foreach($roles as $rol)
                @php
                    $hasRole = $roles_asignados->contains('id', $rol->id);
                @endphp
                
                <li class="item {{ $hasRole ? 'checked' : '' }}" data-id="{{ $rol->id }}">
                    <span class="checkbox">
                        <i class="fa-solid fa-check check-icon"></i>
                    </span>
                    <span class="item-text">{{ $rol->Rol }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <div id="hidden-inputs-container"></div>
        <div>
            <label for="Habilitado" class="form-label">Habilitado?</label>
            <input type="checkbox" id="Habilitado" name="Habilitado" checked>{{ old('Habilitado') }}</input>
        </div>


        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-guardar rounded-1 mt-2 w-100 w-sm-auto">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
            </div>
        </div>
    </form>
    <script>
        const selectBtn = document.querySelector(".select-btn"),
            items = document.querySelectorAll(".item"),
            inputsContainer = document.getElementById("hidden-inputs-container");

        // --- NUEVA FUNCIÓN: Inicializar roles precargados ---
        function initPreselectedRoles() {
            const checkedItems = document.querySelectorAll(".item.checked");
            
            checkedItems.forEach(item => {
                const roleId = item.getAttribute("data-id");
                
                // Crear el input oculto para los roles que ya vienen marcados
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "roles[]";
                input.value = roleId;
                input.id = `input-role-${roleId}`;
                inputsContainer.appendChild(input);
            });

            actualizarTextoBoton();
        }

        // --- NUEVA FUNCIÓN: Actualizar el texto del botón ---
        function actualizarTextoBoton() {
            let checked = document.querySelectorAll(".item.checked");
            let btnText = document.querySelector(".btn-text");
            
            if (checked && checked.length > 0) {
                btnText.innerText = `${checked.length} Seleccionado(s)`;
            } else {
                btnText.innerText = "Seleccionar Rol(es)";
            }
        }

        // Toggle del menú
        selectBtn.addEventListener("click", () => {
            selectBtn.classList.toggle("open");
        });

        // Manejo de la selección de items al hacer click
        items.forEach(item => {
            item.addEventListener("click", () => {
                item.classList.toggle("checked");
                
                const roleId = item.getAttribute("data-id");

                if (item.classList.contains("checked")) {
                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "roles[]";
                    input.value = roleId;
                    input.id = `input-role-${roleId}`;
                    inputsContainer.appendChild(input);
                } else {
                    const inputToDelete = document.getElementById(`input-role-${roleId}`);
                    if (inputToDelete) {
                        inputToDelete.remove();
                    }
                }

                actualizarTextoBoton();
            });
        });
        // --- LÓGICA PARA CAMBIAR CONTRASEÑA ---

        const checkCambiarPassword = document.getElementById("check_cambiar_password"),
            inputPassword = document.getElementById("Cambiar_Password"),
            inputConfirmar = document.getElementById("Cambiar_Password_confirmation"),
            formUsuario = document.getElementById("form-usuario");

        function gestionarEstadoPasswords() {
            // Si el checkbox está marcado, habilitamos los inputs; si no, los deshabilitamos
            const estaActivo = checkCambiarPassword.checked;
            
            inputPassword.disabled = !estaActivo;
            inputConfirmar.disabled = !estaActivo;

            // Opcional: Limpiar los campos si se desmarca el checkbox
            if (!estaActivo) {
                inputPassword.value = "";
                inputConfirmar.value = "";
                inputConfirmar.classList.remove("is-invalid");
            }
        }

        // Escuchar los cambios del checkbox para activar/desactivar
        checkCambiarPassword.addEventListener("change", gestionarEstadoPasswords);

        // Inicializar el estado de las contraseñas al cargar la página
        gestionarEstadoPasswords();

        // Ejecutar la inicialización en cuanto cargue el script
        initPreselectedRoles();
    </script>
@endsection