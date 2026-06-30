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
    <form action="{{ route('usuario.store') }}" method="POST">
        @csrf 
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label for="fk_id_personal">Persona</label>
                <select class="form-control @error('fk_id_personal') is-invalid @enderror" id="fk_id_personal" name="fk_id_personal">
                    <option value="">Seleccione un empleado</option>
                    @foreach($personas as $persona)
                        <option value="{{ $persona->id }}" {{ $persona->id==old('fk_id_personal') ? 'selected' : '' }}>{{ $persona->Codigo_Documento }} - {{ $persona->Nombre_1 }} {{ $persona->Apellido_1 }}</option>
                    @endforeach
                </select>
                @error('fk_id_personal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="Email" class="form-label">Email</label>
                <input type="text" class="form-control @error('Email') is-invalid @enderror" id="Email" name="Email" placeholder="diego@gmail.com" value="{{ old('Email') }}">
                @error('Email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label for="Username" class="form-label">Nombre de Usuario</label>
                <input type="text" step="0.01" class="form-control @error('Username') is-invalid @enderror" id="Username" name="Username" placeholder="Pepex" value="{{ old('Username') }}">
                @error('Username') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-12">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control @error('Password') is-invalid @enderror" id="Password" name="Password" rows="3" placeholder="Password">{{ old('Password') }}</input>
                @error('Password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-12">
                <label for="Password_confirmation" class="form-label">Confirmar password</label>
                <input type="password" class="form-control @error('Password_confirmation') is-invalid @enderror" id="Password_confirmation" name="Password_confirmation" rows="3" placeholder="Confirmar password">{{ old('confirmar_password') }}</input>
                @error('Password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                <li class="item" data-id="{{ $rol->id }}">
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

        // Toggle del menú
        selectBtn.addEventListener("click", () => {
            selectBtn.classList.toggle("open");
        });

        // Manejo de la selección de items
        items.forEach(item => {
            item.addEventListener("click", () => {
                item.classList.toggle("checked");
                
                const roleId = item.getAttribute("data-id");

                if (item.classList.contains("checked")) {
                    // Si se selecciona, creamos el input oculto para este ID
                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "roles[]"; // Array para Laravel
                    input.value = roleId;
                    input.id = `input-role-${roleId}`; // ID único para borrarlo luego si se desmarca
                    inputsContainer.appendChild(input);
                } else {
                    // Si se desmarca, buscamos el input por su ID y lo eliminamos
                    const inputToDelete = document.getElementById(`input-role-${roleId}`);
                    if (inputToDelete) {
                        inputToDelete.remove();
                    }
                }

                // Actualizar el texto del botón superior
                let checked = document.querySelectorAll(".checked");
                let btnText = document.querySelector(".btn-text");
                
                if (checked && checked.length > 0) {
                    btnText.innerText = `${checked.length} Seleccionado(s)`;
                } else {
                    btnText.innerText = "Seleccionar Rol(es)";
                }
            });
        });
    </script>
@endsection