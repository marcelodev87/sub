<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minha Assinatura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Preço</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                               <tr>
                                    <th>{{ $invoice->date()->toFormattedDateString() }}</th>
                                    <th>{{ $invoice->total() }}</th>
                                    <th><a href="{{ route('subscriptions.invoice.download', $invoice->id)}}">Baixar</a></th>
                                </tr
                            @endforeach
                            >
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
