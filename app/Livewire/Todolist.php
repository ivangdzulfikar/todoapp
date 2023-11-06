<?php

namespace App\Livewire;

use App\Models\TodoList as ModelsTodoList;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Todolist extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:50')]
    public $name;
    
    public $search;
    
    public $editingTodoId;

    #[Rule('required|min:3|max:50')]
    public $editingTodoName;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createTodo()
    {
        //validate
        $validated = $this->validate();
        
        //create the todo
        ModelsTodoList::create($validated);
        //clear input
        $this->reset('name');
        //send flash
        session()->flash('success', 'Created.');
    }

    public function delete($todoId)
    {
        try {
            $todoId = ModelsTodoList::findOrFail($todoId)->delete();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete Todo.');
            $this->resetPage();
        }
    }

    public function toggle($todoId)
    {
        $todo = ModelsTodoList::find($todoId);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function edit($todoId)
    {
        $this->editingTodoId = $todoId;
        $this->editingTodoName = ModelsTodoList::find($todoId)->name;
    }

    public function cancelEdit()
    {
        $this->reset('editingTodoId','editingTodoName');
    }

    public function updateTodo()
    {
        $this->validateOnly('editingTodoName');
        
        ModelsTodoList::find($this->editingTodoId)->update(
            [
                'name' => $this->editingTodoName
            ]
        );

        $this->cancelEdit();
    }

    public function render()
    {
        return view('livewire.todolist', [
            'todos' => ModelsTodoList::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)
        ]);
    }
}
