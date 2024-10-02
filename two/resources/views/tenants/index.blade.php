<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tenants') }}
            <x-btn-link class="ml-4 float-right" href="{{ route('tenants.create') }}">Add Tenants</x-btn-link>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Number</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Domain</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tenants as $tenant)
                            <tr class="bg-white border-b dark:bg-gray-600 dark:border-gray-900">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $tenant->name }}</td>
                                <td class="px-6 py-4">{{ $tenant->email }}</td>
                                <td class="px-6 py-4">
                                    @foreach($tenant->domains as $domain)
                                    {{ $domain->domain }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
