<x-app-layout>
    <x-slot name="header">
        {{ __('System Overview') }}
    </x-slot>

    <div class="space-y-8">
        <!-- 1. Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Revenue -->
            <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Revenue</p>
                <div class="flex items-end justify-between mt-2">
                    <h3 class="text-3xl font-black text-gray-900">PHP 128.4k</h3>
                    <span class="text-emerald-500 text-xs font-bold bg-emerald-50 px-2 py-1 rounded-lg">+12%</span>
                </div>
            </div>

            <!-- Active Shipments (Logistics) -->
            <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Active Fleet</p>
                <div class="flex items-end justify-between mt-2">
                    <h3 class="text-3xl font-black text-gray-900">42</h3>
                    <span class="text-blue-500 text-xs font-bold bg-blue-50 px-2 py-1 rounded-lg">Live</span>
                </div>
            </div>

            <!-- Inventory Alerts (Warehouse) -->
            <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Low Stock Items</p>
                <div class="flex items-end justify-between mt-2">
                    <h3 class="text-3xl font-black text-gray-900">08</h3>
                    <span class="text-amber-500 text-xs font-bold bg-amber-50 px-2 py-1 rounded-lg">Critical</span>
                </div>
            </div>

            <!-- AI Efficiency -->
            <div class="bg-black p-6 rounded-[2rem] shadow-xl">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest italic">MCI AI Core</p>
                <div class="flex items-end justify-between mt-2">
                    <h3 class="text-3xl font-black text-white">94%</h3>
                    <div class="flex gap-1 mb-2">
                        <div class="w-1 h-3 bg-blue-500 animate-pulse"></div>
                        <div class="w-1 h-3 bg-blue-400 animate-pulse delay-75"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Charts & Monitoring Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Performance Chart -->
            <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-bold text-lg text-gray-900">Operational Trends</h3>
                    <select class="text-xs font-bold border-none bg-gray-50 rounded-xl focus:ring-0">
                        <option>Last 30 Days</option>
                        <option>Last 6 Months</option>
                    </select>
                </div>
                <!-- Chart Placeholder -->
                <div class="h-64 w-full bg-gray-50 rounded-3xl border border-dashed border-gray-200 flex items-center justify-center text-gray-400 text-sm italic">
                    [ Revenue vs Logistics Chart Area ]
                </div>
            </div>

            <!-- System Monitoring -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <h3 class="font-bold text-lg text-gray-900 mb-6">Live Monitoring</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Database Load</span>
                        <span class="text-sm font-bold text-gray-900">24%</span>
                    </div>
                    <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full w-[24%]"></div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Warehouse API</span>
                        <span class="text-xs font-bold text-emerald-500 uppercase tracking-widest">Healthy</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Active CRM Users</span>
                        <span class="text-sm font-bold text-gray-900">112</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Audit Log Section -->
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-bold text-lg text-gray-900">System Audit Log</h3>
                <button class="text-xs font-bold text-blue-600 hover:underline">Export CSV</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Action</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">User</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Module</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Timestamp</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <!-- Sample Row 1 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-4 text-sm font-bold text-gray-900">Stock Reorder Issued</td>
                            <td class="px-8 py-4 text-sm text-gray-500">System AI</td>
                            <td class="px-8 py-4 text-xs font-bold text-blue-600 uppercase tracking-tighter italic">Warehouse</td>
                            <td class="px-8 py-4 text-xs text-gray-400 font-mono">14:22:10 UTC</td>
                            <td class="px-8 py-4"><span class="px-2 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg">SUCCESS</span></td>
                        </tr>
                        <!-- Sample Row 2 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-4 text-sm font-bold text-gray-900">Payroll Finalized</td>
                            <td class="px-8 py-4 text-sm text-gray-500">{{ Auth::user()->name }}</td>
                            <td class="px-8 py-4 text-xs font-bold text-purple-600 uppercase tracking-tighter italic">HR</td>
                            <td class="px-8 py-4 text-xs text-gray-400 font-mono">12:05:44 UTC</td>
                            <td class="px-8 py-4"><span class="px-2 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg">SUCCESS</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>