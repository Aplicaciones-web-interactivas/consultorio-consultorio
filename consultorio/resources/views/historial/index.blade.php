@extends('layouts.app')

@section('content')
<div style="display: flex; height: calc(100vh - 120px); gap: 1.5rem; padding: 1.5rem; background: #f9fafb;">
    <!-- Panel Izquierdo - Lista de Pacientes (30%) -->
    <div style="width: 30%; border-right: 1px solid #e5e7eb; padding-right: 1.5rem; overflow-y: auto;">
        <h2 style="font-size: 1rem; font-weight: 600; color: #1f2937; margin: 0 0 1rem 0;">Pacientes</h2>

        @if($pacientes->count() > 0)
            <div style="display: grid; gap: 0.75rem;">
                @foreach($pacientes as $paciente)
                    <button onclick="selectPaciente({{ $paciente->id }}, this)"
                            style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 0.625rem; background: #fff; cursor: pointer; text-align: left; transition: all 0.2s ease; width: 100%;"
                            class="hover:border-blue-400 hover:bg-blue-50 hover:shadow-md"
                            onmouseover="this.style.boxShadow = '0 2px 8px rgba(59, 130, 246, 0.15)'"
                            onmouseout="this.style.boxShadow = 'none'">
                        <div style="display: flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border-radius: 50%; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; font-weight: 600; font-size: 0.85rem; flex-shrink: 0;">
                            {{ substr($paciente->nombre, 0, 1) }}{{ substr($paciente->apellido, 0, 1) }}
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <p style="font-weight: 600; font-size: 0.9rem; color: #1f2937; margin: 0;">
                                {{ $paciente->nombre }}
                            </p>
                            <p style="font-size: 0.75rem; color: #6b7280; margin: 0.25rem 0 0 0;">
                                {{ $paciente->apellido }}
                            </p>
                        </div>
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Panel Derecho - Detalles del Paciente (70%) -->
    <div style="flex: 1; overflow-y: auto;">
        @if($pacientes->count() > 0)
            @foreach($pacientes as $paciente)
                <div id="paciente-{{ $paciente->id }}" class="paciente-detail" style="display: {{ $loop->first ? 'block' : 'none' }};">
                    <div style="margin-bottom: 2rem;">
                        <h1 style="font-size: 1.875rem; font-weight: bold; color: #000; margin: 0 0 0.5rem 0;">
                            {{ $paciente->nombre }} {{ $paciente->apellido }}
                        </h1>
                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">
                            {{ $paciente->email }}
                        </p>
                    </div>

                    <div>
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #000; margin: 0 0 1rem 0;">Historial Médico</h2>

                        @php
                            $historiales = $paciente->historial()->orderBy('Fecha', 'desc')->get();
                        @endphp

                        @if($historiales->count() > 0)
                            <div style="display: grid; gap: 0.75rem;">
                                @foreach($historiales as $historial)
                                    <div id="historial-item-{{ $historial->id }}" style="border: 1px solid #e5e7eb; border-radius: 0.625rem; background: #fff; overflow: hidden;">
                                        <div onclick="selectHistorial({{ $historial->id }}, this, 'paciente-{{ $paciente->id }}')"
                                             style="padding: 1rem; cursor: pointer; text-align: left; transition: all 0.2s; display: flex; justify-content: space-between; align-items: center;">
                                            <div style="flex: 1;">
                                                <p id="historial-item-enfermedad-{{ $historial->id }}" style="font-weight: 600; font-size: 0.95rem; color: #1f2937; margin: 0;">
                                                    {{ $historial->Enfermedad ?? 'Sin especificar' }}
                                                </p>
                                                <p id="historial-item-fecha-{{ $historial->id }}" style="font-size: 0.875rem; color: #6b7280; margin: 0.25rem 0 0 0;">
                                                    {{ $historial->Fecha->format('d/m/Y') }}
                                                </p>
                                                @if($historial->Medicacion)
                                                    <p id="historial-item-medicacion-{{ $historial->id }}" style="font-size: 0.8rem; color: #6b7280; margin: 0.25rem 0 0 0;">
                                                        {{ substr($historial->Medicacion, 0, 50) }}{{ strlen($historial->Medicacion) > 50 ? '...' : '' }}
                                                    </p>
                                                @else
                                                    <p id="historial-item-medicacion-{{ $historial->id }}" style="font-size: 0.8rem; color: #6b7280; margin: 0.25rem 0 0 0; display: none;"></p>
                                                @endif
                                                <p id="historial-item-imagenes-{{ $historial->id }}" style="font-size: 0.8rem; color: #9ca3af; margin: 0.5rem 0 0 0;">
                                                    @php
                                                        $imageCount = 0;
                                                        if ($historial->imagen && is_array($historial->imagen)) {
                                                            $imageCount = count($historial->imagen);
                                                        }
                                                    @endphp
                                                    {{ $imageCount > 0 ? $imageCount . ' imagen' . ($imageCount > 1 ? 's' : '') : 'Sin imagen' }}
                                                </p>
                                            </div>
                                            <button onclick="toggleEdit({{ $historial->id }}, event)" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #6b7280; padding: 0.5rem; margin-left: 1rem; flex-shrink: 0;" title="Editar registro">
                                                ✎
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Detalles y edición del historial -->
                                    <div id="historial-{{ $historial->id }}" style="display: none; padding: 1.5rem; background: #f3f4f6; border-radius: 0.625rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                            <h3 style="font-size: 1.125rem; font-weight: 600; color: #000; margin: 0;">
                                                Registro Médico
                                            </h3>
                                            <button onclick="closeHistorial({{ $historial->id }})" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280;">
                                                ✕
                                            </button>
                                        </div>

                                        <div style="display: grid; gap: 1rem; margin-bottom: 1.5rem;">
                                            <div>
                                                <label style="font-size: 0.875rem; color: #6b7280; display: block; margin: 0 0 0.5rem 0; font-weight: 500;">Enfermedad</label>
                                                <input type="text" value="{{ $historial->Enfermedad ?? '' }}" id="enfermedad-{{ $historial->id }}" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-size: 0.875rem;">
                                            </div>
                                            <div>
                                                <label style="font-size: 0.875rem; color: #6b7280; display: block; margin: 0 0 0.5rem 0; font-weight: 500;">Medicación</label>
                                                <textarea id="medicacion-{{ $historial->id }}" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-size: 0.875rem; min-height: 80px;">{{ $historial->Medicacion ?? '' }}</textarea>
                                            </div>
                                            <div>
                                                <label style="font-size: 0.875rem; color: #6b7280; display: block; margin: 0 0 0.5rem 0; font-weight: 500;">Fecha</label>
                                                <input type="date" value="{{ $historial->Fecha->format('Y-m-d') }}" id="fecha-{{ $historial->id }}" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-size: 0.875rem;">
                                            </div>
                                        </div>

                                        <div style="margin-bottom: 1rem;">
                                            @if($historial->imagen && is_array($historial->imagen) && count($historial->imagen) > 0)
                                                <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 0.5rem 0; font-weight: 500;">Imágenes Actuales</p>
                                            @endif
                                            <div id="imagenes-container-{{ $historial->id }}" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 0.75rem;">
                                                @if($historial->imagen && is_array($historial->imagen) && count($historial->imagen) > 0)
                                                    @foreach($historial->imagen as $index => $img)
                                                        <div style="position: relative;">
                                                            <img src="{{ Storage::url($img) }}" alt="Historial image" style="width: 100%; height: 150px; object-fit: cover; border-radius: 0.375rem; border: 1px solid #e5e7eb;">
                                                            <button type="button" data-original-index="{{ $index }}" onclick="deleteImageFromArray({{ $historial->id }}, this, event)" style="position: absolute; top: 0.25rem; right: 0.25rem; background: #ef4444; color: white; border: none; border-radius: 50%; width: 1.5rem; height: 1.5rem; cursor: pointer; font-size: 0.75rem; padding: 0;">✕</button>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div style="margin-bottom: 1.5rem;">
                                            <label style="font-size: 0.875rem; color: #6b7280; display: block; margin: 0 0 0.5rem 0; font-weight: 500;">Cambiar Imagen</label>
                                            <label for="imagen-{{ $historial->id }}" style="display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; border: 2px dashed #d1d5db; border-radius: 0.625rem; background: #f9fafb; cursor: pointer; transition: all 0.2s;">
                                                <span id="label-text-{{ $historial->id }}" style="color: #6b7280; font-size: 0.875rem; font-weight: 500;">
                                                    📁 Selecciona una imagen
                                                </span>
                                            </label>
                                            <input type="file" id="imagen-{{ $historial->id }}" accept="image/*" style="display: none;" onchange="previewImage({{ $historial->id }})">
                                        </div>

                                        <div style="display: flex; gap: 0.75rem;">
                                            <button onclick="saveHistorial({{ $historial->id }}, {{ $paciente->id }})" style="padding: 0.75rem 1.5rem; background: #10b981; color: white; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; cursor: pointer;">
                                                Guardar Cambios
                                            </button>
                                            <button onclick="closeHistorial({{ $historial->id }})" style="padding: 0.75rem 1.5rem; background: #ef4444; color: white; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; cursor: pointer;">
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="padding: 2rem; background: #f3f4f6; border-radius: 0.625rem; text-align: center;">
                                <p style="color: #6b7280; margin: 0;">No hay historial médico registrado</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<script>
const pendingFiles = {};
const originalValues = {};
const imagesToDelete = {};

function selectPaciente(id, btn) {
    document.querySelectorAll('.paciente-detail').forEach(el => {
        el.style.display = 'none';
    });

    document.getElementById('paciente-' + id).style.display = 'block';

    document.querySelectorAll('button[onclick*="selectPaciente"]').forEach(b => {
        b.style.borderColor = '#e5e7eb';
        b.style.backgroundColor = '#fff';
        b.style.boxShadow = 'none';
    });
    btn.style.borderColor = '#3b82f6';
    btn.style.backgroundColor = '#eff6ff';
    btn.style.boxShadow = '0 2px 8px rgba(59, 130, 246, 0.15)';
}

function selectHistorial(historialId, btn, pacienteId) {
    const historialDetail = document.getElementById('historial-' + historialId);
    const isVisible = historialDetail.style.display !== 'none';

    const pacienteDiv = document.getElementById(pacienteId);
    if (pacienteDiv) {
        const allDetailDivs = pacienteDiv.querySelectorAll('div[id^="historial-"]');
        allDetailDivs.forEach(el => {
            if (/^historial-\d+$/.test(el.id)) {
                el.style.display = 'none';
            }
        });
    }

    if (!isVisible) {
        historialDetail.style.display = 'block';
        btn.style.borderColor = '#3b82f6';
        btn.style.backgroundColor = '#eff6ff';

        saveOriginalValues(historialId);
    } else {
        btn.style.borderColor = '#e5e7eb';
        btn.style.backgroundColor = '#fff';
    }
}

function saveOriginalValues(historialId) {
    const enfermedad = document.getElementById('enfermedad-' + historialId);
    const medicacion = document.getElementById('medicacion-' + historialId);
    const fecha = document.getElementById('fecha-' + historialId);
    const imagenesContainer = document.getElementById('imagenes-container-' + historialId);

    const currentImages = Array.from(imagenesContainer?.querySelectorAll('img') || [])
        .filter(img => !img.parentElement.classList.contains('pending-image'))
        .map(img => ({
            src: img.src,
            alt: img.alt
        }));

    originalValues[historialId] = {
        enfermedad: enfermedad.value,
        medicacion: medicacion.value,
        fecha: fecha.value,
        imagenes: currentImages
    };
}

function toggleEdit(historialId, event) {
    event.stopPropagation();
    const historialDetail = document.getElementById('historial-' + historialId);
    if (historialDetail.style.display === 'none') {
        historialDetail.style.display = 'block';
        saveOriginalValues(historialId);
    } else {
        historialDetail.style.display = 'none';
    }
}

function closeHistorial(historialId) {
    const historialDetail = document.getElementById('historial-' + historialId);
    historialDetail.style.display = 'none';

    if (originalValues[historialId]) {
        document.getElementById('enfermedad-' + historialId).value = originalValues[historialId].enfermedad;
        document.getElementById('medicacion-' + historialId).value = originalValues[historialId].medicacion;
        document.getElementById('fecha-' + historialId).value = originalValues[historialId].fecha;

        const imagenesContainer = document.getElementById('imagenes-container-' + historialId);
        const containerWrapper = imagenesContainer?.parentElement;

        imagenesContainer.innerHTML = '';

        if (originalValues[historialId].imagenes.length > 0) {
            const label = containerWrapper?.querySelector('p');
            if (label) {
                label.style.display = 'block';
            }

            originalValues[historialId].imagenes.forEach((imagen, index) => {
                const imageDiv = document.createElement('div');
                imageDiv.style.cssText = 'position: relative;';

                const img = document.createElement('img');
                img.src = imagen.src;
                img.alt = imagen.alt;
                img.style.cssText = 'width: 100%; height: 150px; object-fit: cover; border-radius: 0.375rem; border: 1px solid #e5e7eb;';

                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.innerHTML = '✕';
                deleteBtn.style.cssText = 'position: absolute; top: 0.25rem; right: 0.25rem; background: #ef4444; color: white; border: none; border-radius: 50%; width: 1.5rem; height: 1.5rem; cursor: pointer; font-size: 0.75rem; padding: 0;';
                deleteBtn.dataset.originalIndex = index;
                deleteBtn.onclick = function(e) {
                    deleteImageFromArray(historialId, this, e);
                };

                imageDiv.appendChild(img);
                imageDiv.appendChild(deleteBtn);
                imagenesContainer.appendChild(imageDiv);
            });
        } else {
            const label = containerWrapper?.querySelector('p');
            if (label) {
                label.style.display = 'none';
            }
        }
    }

    const pendingImages = document.querySelectorAll('.pending-image[data-historial-id="' + historialId + '"]');
    pendingImages.forEach(img => img.remove());

    pendingFiles[historialId] = [];
    imagesToDelete[historialId] = [];
}

function previewImage(historialId) {
    const fileInput = document.getElementById('imagen-' + historialId);
    const imagenesContainer = document.getElementById('imagenes-container-' + historialId);
    const containerWrapper = imagenesContainer?.parentElement;

    if (fileInput.files && fileInput.files[0]) {
        const file = fileInput.files[0];

        if (!pendingFiles[historialId]) {
            pendingFiles[historialId] = [];
        }

        pendingFiles[historialId].push(file);

        const reader = new FileReader();

        reader.onload = function(e) {
            const label = containerWrapper?.querySelector('p');
            if (!label && containerWrapper) {
                const newLabel = document.createElement('p');
                newLabel.textContent = 'Imágenes Actuales';
                newLabel.style.cssText = 'font-size: 0.875rem; color: #6b7280; margin: 0 0 0.5rem 0; font-weight: 500;';
                containerWrapper.insertBefore(newLabel, imagenesContainer);
            }

            const imageDiv = document.createElement('div');
            imageDiv.style.cssText = 'position: relative;';
            imageDiv.className = 'pending-image';
            imageDiv.dataset.historialId = historialId;

            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Historial image';
            img.style.cssText = 'width: 100%; height: 150px; object-fit: cover; border-radius: 0.375rem; border: 1px solid #e5e7eb; opacity: 0.7;';

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.innerHTML = '✕';
            deleteBtn.style.cssText = 'position: absolute; top: 0.25rem; right: 0.25rem; background: #ef4444; color: white; border: none; border-radius: 50%; width: 1.5rem; height: 1.5rem; cursor: pointer; font-size: 0.75rem; padding: 0;';
            deleteBtn.onclick = function(evt) {
                evt.preventDefault();
                imageDiv.remove();
                const fileIndex = pendingFiles[historialId].indexOf(file);
                if (fileIndex > -1) {
                    pendingFiles[historialId].splice(fileIndex, 1);
                }
                fileInput.value = '';
            };

            imageDiv.appendChild(img);
            imageDiv.appendChild(deleteBtn);
            imagenesContainer.appendChild(imageDiv);
        };
        reader.readAsDataURL(file);

        fileInput.value = '';
    }
}

function deleteImageFromArray(historialId, btn, event) {
    event.preventDefault();
    event.stopPropagation();

    const index = parseInt(btn.dataset.originalIndex);

    if (!imagesToDelete[historialId]) {
        imagesToDelete[historialId] = [];
    }

    imagesToDelete[historialId].push(index);

    btn.parentElement.remove();
}

function saveHistorial(historialId, pacienteId) {
    const enfermedad = document.getElementById('enfermedad-' + historialId).value;
    const medicacion = document.getElementById('medicacion-' + historialId).value;
    const fecha = document.getElementById('fecha-' + historialId).value;
    const imagenInput = document.getElementById('imagen-' + historialId);
    const pendingImages = document.querySelectorAll('.pending-image[data-historial-id="' + historialId + '"]');

    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('Enfermedad', enfermedad);
    formData.append('Medicacion', medicacion);
    formData.append('Fecha', fecha);

    if (pendingFiles[historialId] && pendingFiles[historialId].length > 0) {
        pendingFiles[historialId].forEach((file, index) => {
            formData.append('imagenes[]', file);
        });
    }

    if (imagesToDelete[historialId] && imagesToDelete[historialId].length > 0) {
        imagesToDelete[historialId].forEach((index) => {
            formData.append('imagenes_eliminar[]', index);
        });
    }

    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    fetch('/historial/' + historialId, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            pendingImages.forEach(img => {
                const imgElement = img.querySelector('img');
                if (imgElement) {
                    imgElement.style.opacity = '1';
                }
                img.classList.remove('pending-image');
            });

            imagenInput.value = '';
            pendingFiles[historialId] = [];
            imagesToDelete[historialId] = [];

            const imagenesWithStorage = (data.imagenes || []).map(img => ({
                src: '/storage/' + img,
                alt: 'Historial image'
            }));

            originalValues[historialId] = {
                enfermedad: enfermedad,
                medicacion: medicacion,
                fecha: fecha,
                imagenes: imagenesWithStorage
            };

            const fechaObj = new Date(fecha + 'T00:00:00');
            const fechaFormato = fechaObj.toLocaleDateString('es-ES', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace(/\//g, '/');

            document.getElementById('historial-item-enfermedad-' + historialId).textContent = enfermedad || 'Sin especificar';
            document.getElementById('historial-item-fecha-' + historialId).textContent = fechaFormato;

            const medicacionElem = document.getElementById('historial-item-medicacion-' + historialId);
            if (medicacion) {
                medicacionElem.textContent = medicacion.substring(0, 50) + (medicacion.length > 50 ? '...' : '');
                medicacionElem.style.display = 'block';
            } else {
                medicacionElem.style.display = 'none';
            }

            const imageCount = (data.imagenes || []).length;
            document.getElementById('historial-item-imagenes-' + historialId).textContent =
                imageCount > 0 ? imageCount + ' imagen' + (imageCount > 1 ? 's' : '') : 'Sin imagen';

            updateImagesInDOM(historialId, data.imagenes);

            alert('Cambios guardados correctamente');
        } else {
            alert(data.message || 'Error al guardar los cambios');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar los cambios: ' + error.message);
    });
}

function updateImagesInDOM(historialId, imagenes) {
    const imagenesContainer = document.getElementById('imagenes-container-' + historialId);
    const containerWrapper = imagenesContainer?.parentElement;

    if (!imagenesContainer) {
        return;
    }

    imagenesContainer.innerHTML = '';

    if (!imagenes || imagenes.length === 0) {
        return;
    }

    const label = containerWrapper?.querySelector('p');
    if (label && label.style.display === 'none') {
        label.style.display = 'block';
    } else if (!label && containerWrapper) {
        const newLabel = document.createElement('p');
        newLabel.textContent = 'Imágenes Actuales';
        newLabel.style.cssText = 'font-size: 0.875rem; color: #6b7280; margin: 0 0 0.5rem 0; font-weight: 500;';
        containerWrapper.insertBefore(newLabel, imagenesContainer);
    }

    imagenes.forEach((imagen, index) => {
        const originalIndex = originalValues[historialId] ? originalValues[historialId].imagenes.findIndex(orig =>
            orig.src === '/storage/' + imagen
        ) : index;

        const imageDiv = document.createElement('div');
        imageDiv.style.cssText = 'position: relative;';

        const img = document.createElement('img');
        img.src = '/storage/' + imagen;
        img.alt = 'Historial image';
        img.style.cssText = 'width: 100%; height: 150px; object-fit: cover; border-radius: 0.375rem; border: 1px solid #e5e7eb;';

        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.innerHTML = '✕';
        deleteBtn.style.cssText = 'position: absolute; top: 0.25rem; right: 0.25rem; background: #ef4444; color: white; border: none; border-radius: 50%; width: 1.5rem; height: 1.5rem; cursor: pointer; font-size: 0.75rem; padding: 0;';
        deleteBtn.dataset.originalIndex = originalIndex;
        deleteBtn.onclick = function(e) {
            deleteImageFromArray(historialId, this, e);
        };

        imageDiv.appendChild(img);
        imageDiv.appendChild(deleteBtn);
        imagenesContainer.appendChild(imageDiv);
    });
}
</script>

@endsection
