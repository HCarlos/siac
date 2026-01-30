/**
 * Función para verificar ortografía en campos de texto
 * @param {string} selector - Selector jQuery para los campos a verificar
 * @param {object} options - Opciones de configuración
 */
function checkSpellSelector(selector = 'input[type="text"], textarea', options = {}) {
    const defaults = {
        apiRoute: '/api/spell-check',
        highlightClass: 'spell-error',
        suggestionsClass: 'spell-suggestions',
        debounceTime: 500,
        lang: 'es',
        csrfToken: $('meta[name="csrf-token"]').attr('content')
    };

    const config = $.extend({}, defaults, options);
    
    // Crear contenedor para sugerencias
    if (!$('#spell-suggestions-container').length) {
        $('body').append(`
            <div id="spell-suggestions-container" 
                 class="spell-suggestions-container" 
                 style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 9999; max-height: 200px; overflow-y: auto;"></div>
        `);
    }
    
    const $suggestionsContainer = $('#spell-suggestions-container');
    
    // Aplicar a todos los elementos que coincidan con el selector
    $(selector).each(function() {
        const $input = $(this);
        
        // Agregar clase para identificar
        $input.addClass('spell-check-enabled');
        
        // Agregar indicador visual
        if (!$input.next('.spell-status').length) {
            $input.after('<span class="spell-status" style="margin-left: 5px; font-size: 12px; color: #666;"></span>');
        }
        
        // Manejar eventos
        setupSpellEvents($input, config, $suggestionsContainer);
    });
}

/**
 * Configura los eventos para un campo específico
 */
function setupSpellEvents($input, config, $suggestionsContainer) {
    let debounceTimer;
    let currentWord = '';
    let currentPosition = 0;
    
    // Evento de entrada con debounce
    $input.on('input keyup', function(e) {
        clearTimeout(debounceTimer);
        
        // No verificar en cada tecla, solo después de pausa
        debounceTimer = setTimeout(() => {
            checkText($(this), config);
        }, config.debounceTime);
        
        // Capturar posición del cursor para sugerencias
        if (this.selectionStart || this.selectionStart === 0) {
            currentPosition = this.selectionStart;
            currentWord = getWordAtPosition(this.value, currentPosition);
        }
    });
    
    // Evento para mostrar sugerencias al hacer clic en palabra subrayada
    $input.on('click', function(e) {
        const position = getCursorPosition(this);
        const word = getWordAtPosition(this.value, position);
        
        if (word && hasSpellError($(this), word)) {
            showSuggestions($(this), word, position, config, $suggestionsContainer);
        } else {
            $suggestionsContainer.hide();
        }
    });
    
    // Evento al perder foco
    $input.on('blur', function() {
        $suggestionsContainer.hide();
        removeHighlights($(this), config);
    });
    
    // Evento al obtener foco
    $input.on('focus', function() {
        checkText($(this), config);
    });
    
    // Evento especial para Ctrl+Espacio
    $input.on('keydown', function(e) {
        if (e.ctrlKey && e.keyCode === 32) { // Ctrl + Espacio
            e.preventDefault();
            manualSpellCheck($(this), config);
        }
    });
}

/**
 * Verifica el texto del campo
 */
function checkText($input, config) {
    const text = $input.val();
    
    if (!text.trim()) {
        updateStatus($input, 'ready');
        return;
    }
    
    updateStatus($input, 'checking');
    
    // Enviar al backend Laravel
    $.ajax({
        url: config.apiRoute,
        method: 'POST',
        data: {
            text: text,
            lang: config.lang,
            _token: config.csrfToken
        },
        success: function(response) {
            if (response.success) {
                highlightErrors($input, response.errors, config);
                updateStatus($input, 'checked', response.errors.length);
            }
        },
        error: function(xhr) {
            console.error('Error en verificación ortográfica:', xhr.responseText);
            updateStatus($input, 'error');
        }
    });
}

/**
 * Resaltar errores ortográficos
 */
function highlightErrors($input, errors, config) {
    // Limpiar resaltados anteriores
    removeHighlights($input, config);
    
    let text = $input.val();
    let offset = 0;
    
    errors.forEach(error => {
        const start = error.position + offset;
        const end = start + error.word.length;
        
        // Crear span para palabra errónea
        const before = text.substring(0, start);
        const word = text.substring(start, end);
        const after = text.substring(end);
        
        text = before + 
               `<span class="${config.highlightClass}" 
                      data-word="${word}" 
                      data-start="${start}"
                      data-suggestions="${error.suggestions.join(',')}">${word}</span>` + 
               after;
        
        offset += `<span class="${config.highlightClass}" data-word="${word}" data-start="${start}" data-suggestions="${error.suggestions.join(',')}">${word}</span>`.length - word.length;
    });
    
    // Reemplazar contenido manteniendo cursor
    const cursorPos = getCursorPosition($input[0]);
    $input.val(text.replace(/<[^>]*>/g, '')); // Mantener texto plano en value
    
    // Usar un div editable para mostrar resaltados
    if (!$input.data('highlight-container')) {
        createHighlightContainer($input, config);
    }
    
    updateHighlightContainer($input, text);
    restoreCursor($input[0], cursorPos);
}

/**
 * Crear contenedor para resaltados
 */
function createHighlightContainer($input, config) {
    const $container = $(`
        <div class="spell-highlight-container" 
             style="position: relative; display: none;">
            <div class="spell-highlight-content" 
                 contenteditable="true"
                 style="min-height: ${$input.outerHeight()}px; 
                        padding: ${$input.css('padding')};
                        border: 1px solid ${$input.css('border-color')};
                        font: ${$input.css('font')};
                        line-height: ${$input.css('line-height')};">
            </div>
        </div>
    `);
    
    $input.after($container);
    $input.hide();
    $container.show();
    
    // Sincronizar contenido
    $container.find('.spell-highlight-content').on('input', function() {
        $input.val($(this).text());
    });
    
    $input.data('highlight-container', $container);
}

/**
 * Actualizar contenedor de resaltados
 */
function updateHighlightContainer($input, htmlContent) {
    const $container = $input.data('highlight-container');
    if ($container) {
        $container.find('.spell-highlight-content').html(htmlContent);
    }
}

/**
 * Mostrar sugerencias para una palabra
 */
function showSuggestions($input, word, position, config, $container) {
    const $errorSpan = $input.siblings('.spell-highlight-container')
                            .find(`span[data-word="${word}"]`);
    
    if (!$errorSpan.length) return;
    
    const suggestions = $errorSpan.data('suggestions').split(',');
    
    if (suggestions.length === 0) {
        $container.hide();
        return;
    }
    
    // Posicionar el contenedor
    const inputOffset = $input.offset();
    const $highlightContainer = $input.data('highlight-container');
    const spanOffset = $errorSpan.offset();
    
    $container.html('')
              .css({
                  left: (spanOffset.left - inputOffset.left) + 'px',
                  top: (spanOffset.top - inputOffset.top + $errorSpan.outerHeight()) + 'px',
                  width: $errorSpan.outerWidth() + 'px'
              });
    
    // Agregar sugerencias
    suggestions.forEach(suggestion => {
        if (suggestion.trim()) {
            $container.append(`
                <div class="spell-suggestion-item" 
                     data-word="${word}"
                     data-suggestion="${suggestion}"
                     style="padding: 5px 10px; cursor: pointer; border-bottom: 1px solid #eee;">
                    ${suggestion}
                </div>
            `);
        }
    });
    
    // Agregar opción "Ignorar"
    $container.append(`
        <div class="spell-suggestion-ignore" 
             data-word="${word}"
             style="padding: 5px 10px; cursor: pointer; color: #999; font-style: italic;">
            Ignorar
        </div>
    `);
    
    $container.show();
    
    // Manejar clic en sugerencia
    $container.find('.spell-suggestion-item').on('click', function() {
        replaceWord($input, 
                   $(this).data('word'), 
                   $(this).data('suggestion'));
        $container.hide();
    });
    
    // Manejar ignorar
    $container.find('.spell-suggestion-ignore').on('click', function() {
        ignoreWord($input, $(this).data('word'));
        $container.hide();
    });
    
    // Cerrar al hacer clic fuera
    $(document).on('click.spellSuggestions', function(e) {
        if (!$(e.target).closest($container).length) {
            $container.hide();
            $(document).off('click.spellSuggestions');
        }
    });
}

/**
 * Reemplazar palabra con sugerencia
 */
function replaceWord($input, oldWord, newWord) {
    let text = $input.val();
    const regex = new RegExp(`\\b${oldWord}\\b`, 'g');
    text = text.replace(regex, newWord);
    $input.val(text);
    
    // Actualizar contenedor de resaltados
    if ($input.data('highlight-container')) {
        updateHighlightContainer($input, text.replace(new RegExp(`\\b${newWord}\\b`, 'g'), 
            `<span style="background-color: #d4edda;">${newWord}</span>`));
    }
    
    // Re-verificar texto
    checkText($input, window.spellCheckConfig || {});
}

/**
 * Ignorar palabra (agregar a diccionario temporal)
 */
function ignoreWord($input, word) {
    // Agregar a localStorage o enviar al backend
    const ignoredWords = JSON.parse(localStorage.getItem('ignoredSpellWords') || '[]');
    if (!ignoredWords.includes(word)) {
        ignoredWords.push(word);
        localStorage.setItem('ignoredSpellWords', JSON.stringify(ignoredWords));
    }
    
    // Quitar resaltado
    const $container = $input.data('highlight-container');
    if ($container) {
        $container.find(`span[data-word="${word}"]`).removeClass('spell-error');
    }
}

/**
 * Verificación manual
 */
function manualSpellCheck($input, config) {
    updateStatus($input, 'checking');
    checkText($input, config);
}

/**
 * Actualizar estado visual
 */
function updateStatus($input, status, errorCount = 0) {
    const $status = $input.next('.spell-status');
    
    const statusConfig = {
        'ready': { text: '✓', color: '#28a745', title: 'Listo' },
        'checking': { text: '⌛', color: '#ffc107', title: 'Verificando...' },
        'checked': { text: errorCount > 0 ? `✗ ${errorCount}` : '✓', 
                    color: errorCount > 0 ? '#dc3545' : '#28a745', 
                    title: errorCount > 0 ? `${errorCount} error(es) encontrado(s)` : 'Sin errores' },
        'error': { text: '!', color: '#dc3545', title: 'Error en verificación' }
    };
    
    const config = statusConfig[status] || statusConfig.ready;
    
    $status.text(config.text)
           .css('color', config.color)
           .attr('title', config.title);
}

/**
 * Helper: Obtener palabra en posición específica
 */
function getWordAtPosition(text, position) {
    const left = text.substring(0, position).match(/\b\w+$/);
    const right = text.substring(position).match(/^\w+/);
    
    if (!left && !right) return '';
    
    return (left ? left[0] : '') + (right ? right[0] : '');
}

/**
 * Helper: Obtener posición del cursor
 */
function getCursorPosition(input) {
    return input.selectionStart;
}

/**
 * Helper: Restaurar posición del cursor
 */
function restoreCursor(input, position) {
    input.setSelectionRange(position, position);
}

/**
 * Helper: Verificar si palabra tiene error
 */
function hasSpellError($input, word) {
    const $container = $input.data('highlight-container');
    if ($container) {
        return $container.find(`span[data-word="${word}"]`).hasClass('spell-error');
    }
    return false;
}

/**
 * Helper: Remover resaltados
 */
function removeHighlights($input, config) {
    const $container = $input.data('highlight-container');
    if ($container) {
        $container.find(`.${config.highlightClass}`).contents().unwrap();
    }
}

// Inicialización automática para campos con data-spellcheck
$(document).ready(function() {
    // Configuración global
    window.spellCheckConfig = {
        apiRoute: '{{ route("spell.check") }}',
        csrfToken: '{{ csrf_token() }}'
    };
    
    // Inicializar para elementos con atributo data-spellcheck
    $('[data-spellcheck="true"]').each(function() {
        checkSpellSelector($(this).selector || `#${$(this).attr('id')}`, window.spellCheckConfig);
    });
});

// Exponer función globalmente
window.checkSpellSelector = checkSpellSelector;
window.manualSpellCheck = manualSpellCheck;