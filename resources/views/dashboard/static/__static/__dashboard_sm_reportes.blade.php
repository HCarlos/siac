<div class="container">
    <aside class="sidebar">
        <div class="logo">
            <a href="/listDenunciasAmbito2"  >
                <img src="{{asset('images/web/logo-0.png')}}" alt="" >
            </a>
        </div>
        <nav class="menu">
            @include('shared.ui_kit.__menu_dashboard_static')
        </nav>
    </aside>
    <!-- Main Content -->
    <main id="contenedor">
{{--        <div class="title-wrapper">--}}
{{--            <h2 class="main-title--">Reportes Servicios Municipales Monitoreados</h2>--}}
{{--            <p class="subtitle">Selecciona un filtro de tiempo para ver los datos detallados</p>--}}
{{--        </div>--}}

        <div class="dashboard-container">
            <div class="section">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="map-container" id="map-container">
                            <!-- Formulario moderno -->
{{--                            <form id="formFilter" class="form-modern">--}}
                                @csrf <!-- Token de seguridad -->

                                <!-- Título de la sección -->
{{--                                <div class="section-header">--}}
{{--                                    <h3 class="section-title">Generador de Reportes</h3>--}}
{{--                                    <p class="section-subtitle">Configura los parámetros para generar tu reporte personalizado</p>--}}
{{--                                </div>--}}

                                <!-- Sección de fechas -->
                                <div class="date-section">
                                    <h4 class="date-section-title">Rango de Fechas</h4>
                                    <p class="date-section-subtitle">Selecciona el período para el reporte</p>

                                    <div class="date-range-container">
                                        <div class="date-picker-wrapper">
                                            <div class="date-picker">
                                                <label for="start_date" class="date-label">
                                                    <svg class="date-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                                    </svg>
                                                    <span>Fecha Inicial</span>
                                                </label>
                                                <div class="date-input-wrapper">
                                                    <input type="date"
                                                           id="start_date"
                                                           name="start_date"
                                                           value="{{ $start_date ?? date('Y-m-01') }}"
                                                           class="date-input"
                                                           required>
                                                    <div class="date-input-focus"></div>
                                                </div>
                                            </div>

                                            <div class="date-separator">
                                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M5 12h14"></path>
                                                    <path d="m12 5 7 7-7 7"></path>
                                                </svg>
                                            </div>

                                            <div class="date-picker">
                                                <label for="end_date" class="date-label">
                                                    <svg class="date-icon w-24 h-24" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                                        <path d="m9 16 2 2 4-4"></path>
                                                    </svg>
                                                    <span>Fecha Final</span>
                                                </label>
                                                <div class="date-input-wrapper">
                                                    <input type="date"
                                                           id="end_date"
                                                           name="end_date"
                                                           value="{{ $end_date ?? date('Y-m-t') }}"
                                                           class="date-input"
                                                           required>
                                                    <div class="date-input-focus"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Indicador de rango seleccionado -->
                                        <div class="date-range-display bg-gray-dark">
                                            <span class="range-text">Período seleccionado:</span>
                                            <span class="range-dates" id="rangeDates">
                                        {{ date('d M, Y', strtotime($start_date ?? date('Y-m-01'))) }} -
                                        {{ date('d M, Y', strtotime($end_date ?? date('Y-m-t'))) }}
                                    </span>
                                            <button type="button" class="btn-reset-range" id="resetDates">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                                    <path d="M3 3v5h5"></path>
                                                </svg>
                                                Reiniciar
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenedor moderno de radio buttons -->
                                <div class="radio-card-container">
                                    <!-- Opción 1 -->
                                    <label class="radio-card" for="tipo_reporte1">
                                        <input type="radio" name="tipo_reporte" id="tipo_reporte1" value="0" class="radio-input" checked>
                                        <div class="radio-content">
                                            <div class="radio-info">
                                                <h4 class="radio-title">Reporte Ciudadano</h4>
                                                <p class="radio-description">Información completa con análisis y gráficos interactivos</p>
                                                <ul class="radio-features">
                                                    <li>📊 Gráficos estadísticos</li>
                                                    <li>📈 Desde el 19 de Noviembre de 2025</li>
                                                    <li>🔍 Solo reportes ciudadanos</li>
                                                </ul>
                                            </div>
                                            <div class="radio-selector">
                                                <div class="radio-dot"></div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Opción 2 -->
                                    <label class="radio-card" for="tipo_reporte2">
                                        <input type="radio" name="tipo_reporte" id="tipo_reporte2" value="1" class="radio-input">
                                        <div class="radio-content">
                                            <div class="radio-icon">
{{--                                                <svg class="radio-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">--}}
{{--                                                    <path d="M12 20v-6M6 20v-3M18 20v-9"></path>--}}
{{--                                                    <rect x="4" y="4" width="16" height="4" rx="1"></rect>--}}
{{--                                                </svg>--}}
                                            </div>
                                            <div class="radio-info">
                                                <h4 class="radio-title">Reporte por Rangos de Fecha</h4>
                                                <p class="radio-description">Solo los datos esenciales en formato compacto</p>
                                                <ul class="radio-features">
                                                    <li>📋 Consulta por rango de fechas</li>
                                                    <li>⚡ Rápida generación</li>
                                                    <li>📄 Formato simplificado</li>
                                                </ul>
                                            </div>
                                            <div class="radio-selector">
                                                <div class="radio-dot"></div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Botones de acción -->
                                <div class="form-actions">

{{--                                    <button type="submit" class="btn-generate" id="generateReport">--}}
                                    <button type="button" class="btn-generate" id="frmReporteDiarioNov">
                                        <span class="btn-text">Generar Reporte</span>
                                        <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {


        // Elementos del DOM
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const rangeDatesDisplay = document.getElementById('rangeDates');
        const resetDatesBtn = document.getElementById('resetDates');
        const form = document.getElementById('formFilter');
        const previewBtn = document.getElementById('previewReport');
        const generateBtn = document.getElementById('generateReport');

        // Formatear fecha a texto legible
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }).replace(/ de /g, ' ');
        }

        // Actualizar display del rango
        function updateRangeDisplay() {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            if (startDate && endDate) {
                rangeDatesDisplay.textContent = `${formatDate(startDate)} - ${formatDate(endDate)}`;
            }
        }

        // Validar rango de fechas
        function validateDateRange() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate > endDate) {
                alert('La fecha inicial no puede ser mayor a la fecha final');
                startDateInput.value = '';
                endDateInput.value = '';
                updateRangeDisplay();
                return false;
            }

            // Limitar a máximo 1 año
            const oneYearAgo = new Date(startDate);
            oneYearAgo.setFullYear(oneYearAgo.getFullYear() + 1);

            if (endDate > oneYearAgo) {
                alert('El rango máximo permitido es de 1 año');
                endDateInput.value = oneYearAgo.toISOString().split('T')[0];
            }

            updateRangeDisplay();
            return true;
        }

        // Reiniciar fechas al mes actual
        function resetDates() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

            startDateInput.value = firstDay.toISOString().split('T')[0];
            endDateInput.value = lastDay.toISOString().split('T')[0];

            updateRangeDisplay();

            // Efecto visual
            resetDatesBtn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                resetDatesBtn.style.transform = '';
            }, 150);
        }

        // Generar reporte
        function generateReport() {
            if (!validateDateRange()) return;

            const selectedReport = document.querySelector('input[name="tipo_reporte"]:checked');

            if (!selectedReport) {
                alert('Por favor, selecciona un tipo de reporte');
                return;
            }

            // Efecto de carga
            const originalText = generateBtn.querySelector('.btn-text').textContent;
            generateBtn.querySelector('.btn-text').textContent = 'Generando...';
            generateBtn.disabled = true;

            // Enviar formulario después de breve delay para efecto visual
            setTimeout(() => {
                // Aquí el formulario se envía automáticamente
                // Pero simulamos éxito primero
                generateBtn.querySelector('.btn-text').textContent = '¡Éxito!';

                showNotification('Reporte generado exitosamente', 'success');

                // Restaurar después de 1 segundo
                setTimeout(() => {
                    generateBtn.querySelector('.btn-text').textContent = originalText;
                    generateBtn.disabled = false;

                    // Enviar formulario real
                    form.submit();
                }, 1000);
            }, 2000);
        }

        // Notificación
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? '#10b981' : type === 'info' ? '#3b82f6' : '#f59e0b';

            notification.className = 'notification';
            notification.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${bgColor};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: var(--shadow-lg);
                animation: slideIn 0.3s ease-out;
                z-index: 1000;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                max-width: 400px;
            ">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'}"></path>
                </svg>
                <span>${message}</span>
            </div>
        `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Event Listeners
        startDateInput.addEventListener('change', validateDateRange);
        endDateInput.addEventListener('change', validateDateRange);
        resetDatesBtn.addEventListener('click', resetDates);
        // previewBtn.addEventListener('click', previewReport);
        // generateBtn.addEventListener('click', generateReport);

        // Inicializar display
        updateRangeDisplay();

        // Añadir estilos para animaciones de notificación
        const style = document.createElement('style');
        style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
        document.head.appendChild(style);


        const btnReporteDiario = document.getElementById('frmReporteDiarioNov');
        btnReporteDiario.addEventListener('click', function () {

            const _start_date = document.getElementById('start_date').value;
            const _end_date = document.getElementById('end_date').value;

            const radioButtons = document.getElementsByName('tipo_reporte');
            const _tipo_reporte = document.querySelector('input[name="tipo_reporte"]:checked');

            var arrReports = ['reporteDiarioExcelNov1','reporteDiarioExcelNov2']

            // alert(_tipo_reporte.value);
            // return false;

            // btnReporteDiario.disabled = true;
            var PARAMS = {
                search : "",
                start_date : _start_date,
                end_date : _end_date,
                tipo_reporte: _tipo_reporte.value,
                _token : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            var temp=document.createElement("form");
            temp.action=arrReports[_tipo_reporte.value];
            temp.method="POST";
            temp.target="_blank";
            temp.style.display="none";
            for(var x in PARAMS) {
                var opt=document.createElement("textarea");
                opt.name=x;
                opt.value=PARAMS[x];
                temp.appendChild(opt);
            }
            document.body.appendChild(temp);
            temp.submit();
            // btnReporteDiario.disabled = false;
            // btnReporteSemanal.disabled = false;
            return temp;

        });

    });

</script>

<style>
    /* Variables de diseño */
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --card-bg: #ffffff;
        --border-color: #e5e7eb;
        --text-primary: #111827;
        --text-secondary: #6b7280;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-container {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .section {
        margin-bottom: 1rem;
    }

    .card {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .card-body {
        padding: 2.5rem;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .section-subtitle {
        font-size: 1rem;
        color: var(--text-secondary);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Sección de fechas */
    .date-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 3rem;
        border: 1px solid var(--border-color);
    }

    .date-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .date-section-subtitle {
        font-size: 0.95rem;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }

    .date-range-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .date-picker-wrapper {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .date-picker {
        flex: 1;
        min-width: 250px;
    }

    .date-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .date-icon {
        width: 20px;
        height: 20px;
        color: var(--primary-color);
    }

    .date-input-wrapper {
        position: relative;
    }

    .date-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 1rem;
        color: var(--text-primary);
        background: white;
        transition: var(--transition);
        cursor: pointer;
        position: relative;
        z-index: 1;
    }

    .date-input::before {
        content: '📅';
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.25rem;
    }

    .date-input::-webkit-calendar-picker-indicator {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .date-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .date-input-focus {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #6366f1 100%);
        opacity: 0;
        transition: var(--transition);
        z-index: 0;
    }

    .date-input:focus + .date-input-focus {
        opacity: 0.05;
        transform: scale(1.02);
    }

    .date-separator {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 1rem;
    }

    .date-separator svg {
        width: 24px;
        height: 24px;
        color: var(--text-secondary);
    }

    .date-range-display {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 1rem 1.5rem;
        background: #374151;
        border-radius: 10px;
        border: 1px solid var(--border-color);
    }

    .range-text {
        font-size: 0.95rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .range-dates {
        font-size: 1rem;
        color: var(--text-primary);
        font-weight: 600;
        padding: 0.25rem 1rem;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: 20px;
        border: 1px solid #bae6fd;
    }

    .btn-reset-range {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: transparent;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-reset-range:hover {
        background: #f3f4f6;
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .btn-reset-range svg {
        width: 16px;
        height: 16px;
    }

    /* Contenedor de radio cards */
    .radio-card-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    /* Radio Card - Mantenemos los estilos anteriores */
    .radio-card {
        position: relative;
        cursor: pointer;
    }

    .radio-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .radio-content {
        display: flex;
        flex-direction: column;
        padding: 1.75rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        background: var(--card-bg);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .radio-card:hover .radio-content {
        border-color: var(--primary-color);
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .radio-input:checked + .radio-content {
        border-color: var(--primary-color);
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        box-shadow: var(--shadow-lg);
    }

    .radio-input:checked + .radio-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--success-color));
    }

    /* Botones de acción */
    .form-actions {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-preview, .btn-generate {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-preview {
        background: white;
        color: var(--text-primary);
        border: 2px solid var(--border-color);
    }

    .btn-preview:hover {
        background: #f9fafb;
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-generate {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6366f1 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn-generate::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }

    .btn-generate:hover::before {
        left: 100%;
    }

    .btn-generate:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-hover) 0%, #4f46e5 100%);
    }

    .btn-icon {
        width: 20px;
        height: 20px;
        transition: var(--transition);
    }

    .btn-preview:hover .btn-icon,
    .btn-generate:hover .btn-icon {
        transform: translateX(4px);
    }

    /* Efecto de pulso para la opción seleccionada */
    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(79, 70, 229, 0);
        }
    }

    .radio-input:checked + .radio-content {
        animation: pulse 2s infinite;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .date-picker-wrapper {
            flex-direction: column;
        }

        .date-separator {
            transform: rotate(90deg);
            padding: 1rem 0;
        }

        .date-range-display {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }

        .radio-card-container {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-preview, .btn-generate {
            width: 100%;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        :root {
            --card-bg: #1f2937;
            --border-color: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
        }

        .date-section {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
        }

        .date-input {
            background: #374151;
            color: var(--text-primary);
            border-color: #4b5563;
        }

        .range-dates {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            border-color: #3b82f6;
        }

        .radio-input:checked + .radio-content {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
        }

        .btn-preview {
            background: #374151;
            color: var(--text-primary);
            border-color: #4b5563;
        }

        .btn-preview:hover {
            background: #4b5563;
        }

        .radio-info{
            color: white;
        }

        .radio-info > ul{
            list-style-type: none;
            text-align: left;
            margin: 1em;
        }

        .radio-info > ul > li, .radio-info > p{
            line-height: 2em;
        }

    }
</style>


