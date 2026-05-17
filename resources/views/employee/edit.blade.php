<x-app-layout>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm border border-gray-200 sm:rounded-xl">

                <div class="p-6">

                    {{-- Header --}}
                    <div class="mb-6 border-b border-gray-200 pb-5">
                        <span class="text-xs font-semibold tracking-wider text-indigo-600 uppercase block mb-1">
                            MCI Management System
                        </span>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Edit Employee
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Update employee account information.
                        </p>
                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-5 rounded-lg bg-red-50 border border-red-200 p-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST"
                        action="{{ route('employee.update', $employee->id) }}">

                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Employee ID --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Employee ID
                                </label>

                                <input type="text"
                                    value="{{ $employee->employee_id }}"
                                    disabled
                                    class="w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm">
                            </div>

                            {{-- Full Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name
                                </label>

                                <input type="text"
                                    name="name"
                                    value="{{ old('name', $employee->name) }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address
                                </label>

                                <input type="email"
                                    name="email"
                                    value="{{ old('email', $employee->email) }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                            </div>

                            {{-- Department --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Department
                                </label>

                                <select name="department_id"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                                    <option value="">Select Department</option>

                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- Position --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Position
                                </label>

                                <select name="position_id"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                                    <option value="">Select Position</option>

                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}"
                                            {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                                            {{ $position->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status
                                </label>

                                <input type="text"
                                    value="{{ $employee->status }}"
                                    disabled
                                    class="w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm">
                            </div>

                        </div>

                        {{-- Buttons --}}
                        <div class="mt-8 flex items-center justify-end gap-3">

                            <a href="{{ route('employee.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition">
                                Cancel
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                                Update Employee
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>