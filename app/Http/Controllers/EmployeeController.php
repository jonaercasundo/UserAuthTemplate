<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    //
    public function create(){
        $departments = Department::all();
        $positions = Position::all();
        return view('employee.register', compact('departments', 'positions'));
    }
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'employee_id'   => 'required|unique:users,employee_id',
                'name'          => 'required|string|max:255',
                'email'         => 'required|email|unique:users,email',
                'department_id' => 'required|exists:departments,id',
                'position_id'   => 'required|exists:positions,id',
                'password'      => 'required|min:6|confirmed',
            ]);

            // CREATE USER
            $user = User::create([
                'employee_id'   => $validated['employee_id'],
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'department_id' => $validated['department_id'],
                'position_id'   => $validated['position_id'],
                'password'      => Hash::make($validated['password']),
            ]);

            // LOAD RELATION (IMPORTANT)
            $user->load('department');

            // ROLE LOGIC (PUT HERE)
            $dept = $user->department?->name ?? '';

            $role = match (true) {

                str_contains($dept, 'Human Resources') => 'HR',
                str_contains($dept, 'Finance & Accounting') => 'Finance',
                str_contains($dept, 'Information Technology') => 'Admin',
                str_contains($dept, 'Sales & Marketing') => 'Sales',
                str_contains($dept, 'Operations') => 'Operations',
                str_contains($dept, 'Customer Service') => 'Customer Service',
                str_contains($dept, 'Procurement') => 'Procurement',
                str_contains($dept, 'Logistics') => 'Logistics',

                default => 'Staff',
            };
                $user->syncRoles($role);

            return redirect()
                ->route('employee.index')
                ->with('success', 'Employee Account Created Successfully!');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function index(Request $request)
    {
        $query = User::with(['department', 'position']);

        // SEARCH LOGIC
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('employee_id', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $employees = $query->latest()->paginate(10);

        return view('employee.index', compact('employees'));
    }
    public function toggleStatus($id)
    {
        try {

            $employee = User::findOrFail($id);

            $employee->status = $employee->status === 'Active'
                ? 'Inactive'
                : 'Active';

            $employee->save();

            return redirect()
                ->route('employee.index')
                ->with('success', 'Employee status updated successfully!');

        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }
    public function edit($id){
        $employee = User::findOrFail($id);
        $departments = Department::all();
        $positions = Position::all();

        return view('employee.edit', compact('employee', 'departments', 'positions'));
    }
    public function update(Request $request, $id){
        $employee = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
        ]);
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
        ]);
        return redirect()->route('employee.index')
            ->with('success', 'Employee updated successfully.');
    }
    public function exportCsv()
    {
        $fileName = 'employees.csv';

        $employees = User::with([
            'department',
            'position'
        ])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        $callback = function () use ($employees) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Employee ID',
                'Name',
                'Email',
                'Department',
                'Position',
                'Status',
            ]);

            foreach ($employees as $employee) {

                fputcsv($file, [
                    $employee->employee_id,
                    $employee->name,
                    $employee->email,
                    optional($employee->department)->name,
                    optional($employee->position)->name,
                    $employee->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
