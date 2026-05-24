@props([
    'modalId' => 'global-delete-modal',
    'formId' => 'global-delete-form',
    'title' => 'Confirmar acción',
    'message' => '¿Seguro que deseas continuar?',
    'buttonText' => 'Confirmar',
])

<div class="modal-overlay" id="{{ $modalId }}" onclick="if(event.target===this) cerrarModal('{{ $modalId }}')">
    <div class="modal-box">
        <button type="button" class="modal-close" onclick="cerrarModal('{{ $modalId }}')"> × </button>
        <div class="modal-handle"></div>
        <h3 class="modal-title">
            {{ $title }}
        </h3>
        <p class="modal-sub"
           id="{{ $modalId }}-message">
            {{ $message }}
        </p>

        <form id="{{ $formId }}" method="POST">
            @csrf
            <div id="{{ $modalId }}-method"></div>
            <button type="submit" class="btn-danger">
                <span class="material-symbols-outlined" style="font-size:16px;">
                    delete
                </span>
                {{ $buttonText }}
            </button>
        </form>
    </div>
</div>