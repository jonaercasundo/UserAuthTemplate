<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Account Registration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">

                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                    <form method="POST" action="{{ route('employee.store') }}">
                        @csrf

                        <!-- Employee ID -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">
                                Employee ID
                            </label>

                            <input type="text"
                                name="employee_id"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                required>
                        </div>

                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">
                                Full Name
                            </label>

                            <input type="text"
                                name="name"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">
                                Email
                            </label>

                            <input type="email"
                                name="email"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                required>
                        </div>

                        <!-- Department -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">
                                Department
                            </label>

                            <select name="department_id"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                required>

                                <option value="">Select Department</option>

                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">
                                        {{ $department->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <!-- Position -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">
                                Position
                            </label>

                            <select name="position_id"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                required>

                                <option value="">Select Position</option>

                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}">
                                        {{ $position->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">
                                Password
                            </label>

                            <input type="password"
                                name="password"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">
                                Confirm Password
                            </label>

                            <input type="password"
                                name="password_confirmation"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                required>
                        </div>

                        <div class="flex justify-between items-center">
                            <!-- View Employees Button -->
                            <a href="{{ route('employee.index') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                View Employees
                            </a>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Create Employee Account
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>