<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TaskList extends Component
{
    #[Validate('required|min:5')]
    public $name = '';

    public $user_id;

    public $editTaskID;

    #[Validate('required|min:5')]
    public $editTaskName;

    protected $messages = [
        'name.required' => 'Task name is required',
        'name.min' => 'Task must be long enough',
    ];

    public function createTask() {
        
       $this->validateOnly('name'); 

        Task::create([
                'name' => $this->name,
                'user_id' => auth()->user()->id
            ]);

        session()->flash('success', 'Task created successfully');
        
        $this->reset('name');
    }

    public function toggle(Task $task) {
        $task->completed =! $task->completed;
        $task->save();
        
        if($task->completed) {
            session()->flash('success', 'Task completed successfully');
        } else {
            session()->flash('success', 'Task active');
        }
    }

    public function editTask(Task $task) {
        $this->editTaskID = $task->id;
        $this->editTaskName = $task->name;
    }

    public function update() {
        $this->validateOnly('editTaskName');

        Task::find($this->editTaskID)->update([
            'name' => $this->editTaskName
        ]);

        session()->flash('success', 'Task updated successfully');
        
        $this->cancelEdit();
    }

    public function cancelEdit() {
        $this->reset('editTaskID', 'editTaskName');
    }

    public function deleteTask(Task $task) {
        $task->delete();

        session()->flash('success', 'Task deleted successfully');
    }

    

    
    public function render()
    {
        $user = Auth::user();
        
        return view('livewire.task-list', [
            'tasks' => Task::where('user_id', $user->id)->orderBy('created_at')->get()
        ]);
    }
}