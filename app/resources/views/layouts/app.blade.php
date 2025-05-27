<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- jQuery (Necessário para Select2) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Scripts do Laravel -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Livewire Styles -->
        @livewireStyles

        <!-- CSS Personalizado para Select2 -->
        <style>
            .select2-container--default .select2-selection--single {
                border: 1px solid #d1d5db; /* border-gray-300 */
                border-radius: 0.375rem; /* rounded-md */
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* shadow-sm */
                background-color: #f9fafb; /* bg-gray-50 */
                padding: 0.5rem 0.75rem; /* p-2 */
                height: 42px; /* Altura para alinhar com inputs */
                display: flex;
                align-items: center;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #1f2937; /* text-gray-800 */
                line-height: 1.5rem;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 100%;
                display: flex;
                align-items: center;
            }

            .select2-container--default .select2-selection--single .select2-selection__clear {
                margin-right: 10px;
            }

            /* Estilo do dropdown */
            .select2-dropdown {
                border: 1px solid #d1d5db; /* border-gray-300 */
                border-radius: 0.375rem; /* rounded-md */
                background-color: #ffffff; /* bg-white */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* shadow-md */
            }

            .select2-results__option {
                padding: 0.5rem 0.75rem; /* p-2 */
                color: #1f2937; /* text-gray-800 */
            }

            .select2-results__option--highlighted {
                background-color: #e5e7eb; /* bg-gray-200 */
                color: #1f2937; /* text-gray-800 */
            }

            /* Modo escuro */
            @media (prefers-color-scheme: dark) {
                .select2-container--default .select2-selection--single {
                    border-color: #4b5563; /* border-gray-700 */
                    background-color: #1f2937; /* bg-gray-900 */
                    color: #d1d5db; /* text-gray-200 */
                }

                .select2-container--default .select2-selection--single .select2-selection__rendered {
                    color: #d1d5db; /* text-gray-200 */
                }

                .select2-dropdown {
                    border-color: #4b5563; /* border-gray-700 */
                    background-color: #1f2937; /* bg-gray-900 */
                }

                .select2-results__option {
                    color: #d1d5db; /* text-gray-200 */
                }

                .select2-results__option--highlighted {
                    background-color: #374151; /* bg-gray-700 */
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        <!-- Livewire Scripts -->
        @livewireScripts

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

        <!-- Inicialização do Select2 -->
        <script>
            document.addEventListener('livewire:init', () => {
                $('.select2').each(function () {
                    const $select = $(this);
                    const componentId = $select.closest('[wire\\:id]').attr('wire:id');

                    $select.select2({
                        width: '100%',
                        placeholder: "Selecione ou digite para filtrar...",
                        allowClear: true,
                        minimumResultsForSearch: 0, // Mostra a barra de busca mesmo com poucas opções
                        matcher: function (params, data) {
                            // Filtra as opções localmente
                            if (!params.term || params.term.trim() === '') {
                                return data; // Mostra todas as opções se nada for digitado
                            }

                            const term = params.term.toLowerCase();
                            const text = data.text.toLowerCase();

                            return text.includes(term) ? data : null;
                        }
                    });

                    // Sincroniza o Select2 com o Livewire ao selecionar
                    $select.on('change', function () {
                        let livewireComponent = Livewire.find(componentId);
                        if (livewireComponent) {
                            livewireComponent.set('selected', this.value);
                        }
                    });
                });
            });

            // Re inicializa o Select2 após atualizações do Livewire
            Livewire.on('update', () => {
                $('.select2').each(function () {
                    if (!$(this).hasClass('select2-hidden-accessible')) {
                        const $select = $(this);
                        const componentId = $select.closest('[wire\\:id]').attr('wire:id');

                        $select.select2({
                            width: '100%',
                            placeholder: "Selecione ou digite para filtrar...",
                            allowClear: true,
                            minimumResultsForSearch: 0, // Mostra a barra de busca mesmo com poucas opções
                            matcher: function (params, data) {
                                if (!params.term || params.term.trim() === '') {
                                    return data;
                                }

                                const term = params.term.toLowerCase();
                                const text = data.text.toLowerCase();

                                return text.includes(term) ? data : null;
                            }
                        });

                        // Sincroniza novamente após reinicialização
                        $select.on('change', function () {
                            let livewireComponent = Livewire.find(componentId);
                            if (livewireComponent) {
                                livewireComponent.set('selected', this.value);
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>