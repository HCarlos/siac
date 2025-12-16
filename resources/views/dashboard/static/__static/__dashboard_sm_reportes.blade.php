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
        <div class="dashboard-container">
            <div class="section">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="map-container" id="map-container">
                            <!-- Sección de fechas -->
                            <div class="date-section">
                                <h4 class="date-section-title">Rango de Fechas</h4>
                                <p class="date-section-subtitle">
                                    Selecciona el período para el reporte
                                </p>

                                <div class="date-range-container">
                                    <div class="date-picker-wrapper">
                                        <!-- Fecha inicial -->
{{--                                        <div class="date-picker">--}}
{{--                                            <label for="start_date" class="date-label">--}}
{{--                                                <svg class="date-icon" viewBox="0 0 24 24" fill="none"--}}
{{--                                                     stroke="currentColor" stroke-width="2">--}}
{{--                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>--}}
{{--                                                    <line x1="16" y1="2" x2="16" y2="6"></line>--}}
{{--                                                    <line x1="8" y1="2" x2="8" y2="6"></line>--}}
{{--                                                    <line x1="3" y1="10" x2="21" y2="10"></line>--}}
{{--                                                </svg>--}}
{{--                                                <span>Fecha Inicial</span>--}}
{{--                                            </label>--}}
{{--                                            <div class="date-input-wrapper">--}}
{{--                                                <input--}}
{{--                                                    type="date"--}}
{{--                                                    id="start_date"--}}
{{--                                                    name="start_date"--}}
{{--                                                    value="{{ $start_date ?? date('Y-m-01') }}"--}}
{{--                                                    class="date-input"--}}
{{--                                                    required--}}
{{--                                                >--}}
{{--                                                <div class="date-input-focus"></div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <!-- Separador -->
{{--                                        <div class="date-separator">--}}
{{--                                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none"--}}
{{--                                                 stroke="currentColor" stroke-width="2">--}}
{{--                                                <path d="M5 12h14"></path>--}}
{{--                                                <path d="m12 5 7 7-7 7"></path>--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}

                                        <!-- Fecha final -->
                                        <div class="date-picker">
                                            <label for="end_date" class="date-label">
                                                <svg class="date-icon" viewBox="0 0 24 24" fill="none"
                                                     stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                    <path d="m9 16 2 2 4-4"></path>
                                                </svg>
                                                <span>Fecha Final</span>
                                            </label>
                                            <div class="date-input-wrapper">
                                                <input
                                                    type="date"
                                                    id="end_date"
                                                    name="end_date"
                                                    value="{{ $end_date ?? date('Y-m-t') }}"
                                                    class="date-input"
                                                    required
                                                >
                                                <div class="date-input-focus"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Contenedor moderno de radio buttons -->
                            <div class="radio-card-container">
                                <!-- Opción 1 -->
                                <label class="radio-card" for="tipo_reporte1">
                                    <input
                                        type="radio"
                                        name="tipo_reporte"
                                        id="tipo_reporte1"
                                        value="0"
                                        class="radio-input"
                                        checked
                                    >
                                    <div class="radio-content">
                                        <div class="radio-info">
                                            <h4 class="radio-title">Reporte Ciudadano</h4>
                                            <p class="radio-description">
                                                Información completa con análisis y gráficos interactivos
                                            </p>
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
                                    <input
                                        type="radio"
                                        name="tipo_reporte"
                                        id="tipo_reporte2"
                                        value="1"
                                        class="radio-input"
                                    >
                                    <div class="radio-content">
                                        <div class="radio-info">
                                            <h4 class="radio-title">Reporte por Rangos de Fecha</h4>
                                            <p class="radio-description">
                                                Solo los datos esenciales en formato compacto
                                            </p>
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
                                <button type="button" class="btn-generate" id="frmReporteDiarioNov">
                                    <span class="btn-text">Generar Reporte</span>
                                    <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>

                        </div> <!-- /map-container -->
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@section("scripts")
<script>

    document.addEventListener('DOMContentLoaded', () => {


        // Elementos del DOM
        // const startDateInput = document.getElementById('end_date');
        // const endDateInput = document.getElementById('end_date');
        // const rangeDatesDisplay = document.getElementById('rangeDates');
        // const resetDatesBtn = document.getElementById('resetDates');
        const form = document.getElementById('formFilter');
        // const previewBtn = document.getElementById('previewReport');
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
        // function updateRangeDisplay() {
        //     const startDate = startDateInput.value;
        //     const endDate = endDateInput.value;
        //
        //     if (startDate && endDate) {
        //         rangeDatesDisplay.textContent = `${formatDate(startDate)} - ${formatDate(endDate)}`;
        //     }
        // }

        // Validar rango de fechas
        function validateDateRange() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate > endDate) {
                alert('La fecha inicial no puede ser mayor a la fecha final');
                startDateInput.value = '';
                endDateInput.value = '';
                // updateRangeDisplay();
                return false;
            }

            // Limitar a máximo 1 año
            const oneYearAgo = new Date(startDate);
            oneYearAgo.setFullYear(oneYearAgo.getFullYear() + 1);

            if (endDate > oneYearAgo) {
                alert('El rango máximo permitido es de 1 año');
                endDateInput.value = oneYearAgo.toISOString().split('T')[0];
            }

            // updateRangeDisplay();
            return true;
        }

        // Reiniciar fechas al mes actual
        // function resetDates() {
        //     const today = new Date();
        //     const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        //     const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        //
        //     startDateInput.value = firstDay.toISOString().split('T')[0];
        //     endDateInput.value = lastDay.toISOString().split('T')[0];
        //
        //     updateRangeDisplay();
        //
        //     // Efecto visual
        //     resetDatesBtn.style.transform = 'scale(0.95)';
        //     setTimeout(() => {
        //         resetDatesBtn.style.transform = '';
        //     }, 150);
        // }

        // Generar reporte
        // function generateReport() {
        //     if (!validateDateRange()) return;
        //
        //     const selectedReport = document.querySelector('input[name="tipo_reporte"]:checked');
        //
        //     if (!selectedReport) {
        //         alert('Por favor, selecciona un tipo de reporte');
        //         return;
        //     }
        //
        //     // Efecto de carga
        //     const originalText = generateBtn.querySelector('.btn-text').textContent;
        //     generateBtn.querySelector('.btn-text').textContent = 'Generando...';
        //     generateBtn.disabled = true;
        //
        //     // Enviar formulario después de breve delay para efecto visual
        //     setTimeout(() => {
        //         // Aquí el formulario se envía automáticamente
        //         // Pero simulamos éxito primero
        //         generateBtn.querySelector('.btn-text').textContent = '¡Éxito!';
        //
        //         showNotification('Reporte generado exitosamente', 'success');
        //
        //         // Restaurar después de 1 segundo
        //         setTimeout(() => {
        //             generateBtn.querySelector('.btn-text').textContent = originalText;
        //             generateBtn.disabled = false;
        //
        //             // Enviar formulario real
        //             form.submit();
        //         }, 1000);
        //     }, 2000);
        // }

        // Notificación
        // function showNotification(message, type = 'success') {
        //     const notification = document.createElement('div');
        //     const bgColor = type === 'success' ? '#10b981' : type === 'info' ? '#3b82f6' : '#f59e0b';
        //
        //     notification.className = 'notification';
        //     notification.innerHTML = `
        //     <div style="
        //         position: fixed;
        //         top: 20px;
        //         right: 20px;
        //         background: ${bgColor};
        //         color: white;
        //         padding: 1rem 1.5rem;
        //         border-radius: 8px;
        //         box-shadow: var(--shadow-lg);
        //         animation: slideIn 0.3s ease-out;
        //         z-index: 1000;
        //         display: flex;
        //         align-items: center;
        //         gap: 0.75rem;
        //         max-width: 400px;
        //     ">
        //         <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        //             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        //                 d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'}"></path>
        //         </svg>
        //         <span>${message}</span>
        //     </div>
        // `;
        //
        //     document.body.appendChild(notification);
        //
        //     setTimeout(() => {
        //         notification.style.animation = 'slideOut 0.3s ease-out';
        //         setTimeout(() => notification.remove(), 300);
        //     }, 3000);
        // }

        // Event Listeners

        // startDateInput.addEventListener('change', validateDateRange);
        // endDateInput.addEventListener('change', validateDateRange);

        // resetDatesBtn.addEventListener('click', resetDates);
        // previewBtn.addEventListener('click', previewReport);
        // generateBtn.addEventListener('click', generateReport);

        // Inicializar display
        // updateRangeDisplay();

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


            // if ( !validateDateRange() ) {
            //     return false;
            // }

            const _start_date = document.getElementById('end_date').value;
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
@endsection

@section("styles")

    <style>

    /* Contenedor general de la tarjeta */
    .dashboard-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    }

    .section {
    margin-bottom: 1rem;
    }

    .card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card:hover {
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    transform: translateY(-2px);
    }

    .card-body {
    padding: 2.5rem;
    }

    .map-container {
    width: 100%;
    }

    /* Sección de fechas */
    .date-section {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2em;
    border: 1px solid #e5e7eb;
    }

    .date-section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    }

    .date-section-subtitle {
    font-size: 0.95rem;
    color: #6b7280;
    margin-bottom: 1.5rem;
    }

    .date-range-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    }

    /* Fila de datepickers */
    .date-picker-wrapper {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex-wrap: wrap;
    }

    .date-picker {
    flex: 1;
    min-width: 260px;
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
    color: #4f46e5;
    }

    /* Wrapper del input para soporte Chrome + Firefox */
    .date-input-wrapper {
    position: relative;
    }

    /* Icono de calendario cross-browser */
    .date-input-wrapper::before {
    content: "📅";
    position: absolute;
    left: 0.9rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.1rem;
    pointer-events: none;
    z-index: 1;
    }

    /* Estilo del input date */
    .date-input {
    width: 100%;
    padding: 0.9rem 1rem 0.9rem 2.7rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 1rem;
    color: #111827;
    background: #ffffff;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
    z-index: 2;
    box-sizing: border-box;
    }

    /* Ocultamos el icono nativo en Chromium, Firefox lo ignora sin romper nada */
    /*.date-input::-webkit-calendar-picker-indicator {*/
    /*opacity: 0;*/
    /*cursor: pointer;*/
    /*}*/

    /* Focus */
    .date-input:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    .date-input-focus {
    position: absolute;
    inset: 0;
    border-radius: 10px;
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    /*opacity: 0;*/
    transition: all 0.2s ease;
    z-index: 0;
    }

    .date-input:focus + .date-input-focus {
    opacity: 0.06;
    transform: scale(1.02);
    }

    /* Separador de fechas */
    .date-separator {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 0.75rem;
    }

    .date-separator svg {
    width: 24px;
    height: 24px;
    color: #6b7280;
    }

    /* Display del rango seleccionado */
    .date-range-display {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background: #111827;
    border-radius: 10px;
    border: 1px solid #374151;
    }

    .range-text {
    font-size: 0.95rem;
    color: #d1d5db;
    font-weight: 500;
    }

    .range-dates {
    font-size: 1rem;
    color: #111827;
    font-weight: 600;
    padding: 0.25rem 1rem;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-radius: 999px;
    border: 1px solid #bae6fd;
    white-space: nowrap;
    }

    /* Botón Reiniciar */
    .btn-reset-range {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: transparent;
    border: 1px solid #4b5563;
    border-radius: 8px;
    color: #e5e7eb;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    }

    .btn-reset-range:hover {
    background: #1f2937;
    border-color: #60a5fa;
    color: #f9fafb;
    }

    .btn-reset-range svg {
    width: 16px;
    height: 16px;
    }

    /* Radio cards */
    .radio-card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    }

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
    padding: 1.5rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: #ffffff;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
    }

    .radio-card:hover .radio-content {
    border-color: #4f46e5;
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgb(0 0 0 / 0.08);
    }

    .radio-input:checked + .radio-content {
    border-color: #4f46e5;
    background: linear-gradient(135deg, #f5f3ff 0%, #eef2ff 100%);
    box-shadow: 0 10px 20px -10px rgba(79, 70, 229, 0.6);
    }

    .radio-input:checked + .radio-content::before {
    content: "";
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at top left, rgba(79, 70, 229, 0.18), transparent 60%);
    pointer-events: none;
    }

    .radio-info {
    color: #111827;
    }

    .radio-title {
    font-size: 1.05rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    }

    .radio-description {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 0.75rem;
    }

    .radio-features {
    list-style: none;
    padding-left: 0;
    margin: 0.5rem 0 0;
    }

    .radio-features li {
    font-size: 0.9rem;
    line-height: 1.8;
    }

    /* Pildorita de selección */
    .radio-selector {
    margin-top: 1.25rem;
    display: flex;
    justify-content: flex-end;
    }

    .radio-dot {
    width: 16px;
    height: 16px;
    border-radius: 999px;
    border: 2px solid #9ca3af;
    background: #f9fafb;
    transition: all 0.2s ease;
    }

    .radio-input:checked + .radio-content .radio-dot {
    border-color: #4f46e5;
    background: #4f46e5;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.35);
    }

    /* Botones de acción */
    .form-actions {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
    }

    .btn-generate {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 0.9rem 2.4rem;
    border-radius: 999px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    color: #ffffff;
    box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.45);
    position: relative;
    overflow: hidden;
    transition: all 0.25s ease;
    }

    .btn-generate::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transform: translateX(-100%);
    transition: transform 0.55s ease;
    }

    .btn-generate:hover::before {
    transform: translateX(100%);
    }

    .btn-generate:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 25px -10px rgba(79, 70, 229, 0.7);
    }

    .btn-icon {
    width: 20px;
    height: 20px;
    transition: transform 0.25s ease;
    }

    .btn-generate:hover .btn-icon {
    transform: translateX(4px);
    }

    /* Responsive (mobile) */
    @media (max-width: 768px) {
    .dashboard-container {
    padding: 1rem;
    }

    .card-body {
    padding: 1.5rem;
    }

    .date-picker-wrapper {
    flex-direction: column;
    align-items: stretch;
    }

    .date-separator {
    transform: rotate(90deg);
    padding: 0.5rem 0;
    }

    .date-range-display {
    flex-direction: column;
    align-items: stretch;
    text-align: center;
    }

    .range-dates {
    white-space: normal;
    }

    .form-actions {
    flex-direction: column;
    }

    .btn-generate {
    width: 100%;
    }
    }

    /* Dark mode (opcional, se ve bien en Firefox/Chrome) */
    @media (prefers-color-scheme: dark) {
    .card {
    background: #111827;
    border-color: #374151;
    }

    .card-body {
    color: #e5e7eb;
    }

    .date-section {
    background: linear-gradient(135deg, #020617 0%, #020617 100%);
    border-color: #374151;
    }

    .date-section-title,
    .date-section-subtitle {
    color: #e5e7eb;
    }

    .date-input {
    background: #020617;
    border-color: #4b5563;
    color: #f9fafb;
    }

    .range-dates {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    border-color: #3b82f6;
    color: #f9fafb;
    }

    .radio-content {
    background: #020617;
    border-color: #374151;
    }

    .radio-input:checked + .radio-content {
    background: linear-gradient(135deg, #020617 0%, #020617 100%);
    }

    .radio-info {
    color: #f9fafb;
    }
    }
</style>
@endsection

