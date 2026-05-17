<x-app-layout>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm border border-gray-200 sm:rounded-xl">
                <div class="p-6 text-left"> <div class="flex flex-row items-start justify-between w-full pb-6 mb-6 border-b border-gray-200 text-left">
                        
                        <div class="text-left flex-1">
                            <span class="text-xs font-semibold tracking-wider text-indigo-600 uppercase block mb-1 text-left">
                                MCI Management System
                            </span>
                            <h2 class="font-bold text-2xl text-gray-900 tracking-tight text-left">
                                Employee List
                            </h2>
                            <p class="text-sm text-gray-500 mt-1 text-left">
                                Manage and view all registered employee accounts.
                            </p>
                        </div>

                        <div class="flex-shrink-0 ml-4">
                            <a href="{{ route('employee.register') }}"
                                class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm px-4 py-2.5 rounded-lg shadow-sm transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5 mr-1.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Employee Account
                            </a>
                        </div>

                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 w-full block">
                        <form method="GET" action="{{ route('employee.index') }}" class="mb-4 flex gap-2">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search employee ID, name, or email..."
                                class="w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2">

                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                                Search
                            </button>
                            <a href="{{ route('employee.export.csv') }}"
                                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                                Export CSV
                            </a>
                            @if(request('search'))
                                <a href="{{ route('employee.index') }}"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                                    Reset
                                </a>
                            @endif

                        </form>
                        @if(session('success'))
                            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="w-full min-w-full divide-y divide-gray-200 table-fixed text-left">
                            
                            <thead class="bg-gray-50 text-left">
                                <tr>
                                    <th scope="col" class="w-[10%] px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Employee ID
                                    </th>
                                    <th scope="col" class="w-[15%] px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="w-[20%] px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="w-[20%] px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Department
                                    </th>
                                    <th scope="col" class="w-[15%] px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Position
                                    </th>
                                    <th scope="col" class="w-[15%] px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 text-left">
                                @forelse($employees as $employee)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 text-left">
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600 text-left">
                                            {{ $employee->employee_id ?? '—' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-left">
                                            {{ $employee->name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-left">
                                            {{ $employee->email }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-left">
                                            @if($employee->department)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                    {{ $employee->department->name }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 italic">N/A</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-left">
                                            @if($employee->position)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                                    {{ $employee->position->name }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 italic">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center gap-2">
                                                {{-- Edit Button --}}
                                                <a href="{{ route('employee.edit',$employee->id) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                                Edit
                                                </a>
                                                <form action="{{ route('employee.toggleStatus', $employee->id) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('PATCH')

                                                    @if($employee->status === 'Active')
                                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                                            Deactivate
                                                        </button>
                                                    @else
                                                        <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                                            Activate
                                                        </button>
                                                    @endif

                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No employees found</h3>
                                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new employee account.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    @if($employees instanceof \Illuminate\Pagination\LengthAwarePaginator && $employees->hasPages())
                        <div class="mt-4 text-left">
                            {{ $employees->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

</x-app-layout>