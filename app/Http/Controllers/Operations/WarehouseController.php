<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WarehouseTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class WarehouseController extends Controller
{
    //
    public function index(){
        /** @var User $user */
        $user = request()->user();
        // Get warehouse tasks assigned to the current user
        $tasks = WarehouseTask::where('assigned_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate statistics
        $totalTasks = $tasks->count();
        $pendingTasks = $tasks->where('status', 'Pending')->count();
        $inProgressTasks = $tasks->where('status', 'In Progress')->count();
        $completedTasks = $tasks->where('status', 'Completed')->count();
        
        // Calculate inventory metrics
        $totalQuantity = $tasks->sum('quantity');
        $pendingQuantity = $tasks->where('status', 'Pending')->sum('quantity');
        
        return view('operation.dashboard', [
            'tasks' => $tasks,
            'totalTasks' => $totalTasks,
            'pendingTasks' => $pendingTasks,
            'inProgressTasks' => $inProgressTasks,
            'completedTasks' => $completedTasks,
            'totalQuantity' => $totalQuantity,
            'pendingQuantity' => $pendingQuantity,
        ]);
    }
    public function create(){
        return view('operation.warehouse.create');
    }
    public function store(Request $request){
        $request->validate([
            'item_name' => 'required',
            'quantity' => 'required|integer',
        ]);
        WarehouseTask::create([
            'task_code' => 'WT-' . time(),
            'assigned_to' => request()->user()->id,
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'status' => 'Pending',
        ]);
        return redirect()->route('operation.dashboard')
        ->with('success', 'Task Created Successfully');
    }
}
