<div>
    @if (session('success'))
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 mb-3">
            <div class="alert alert-success  bg-slate-500 overflow-hidden shadow-sm sm:rounded-lg px-6 py-1 text-white">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 flex justify-center w-full">

                <form wire:submit="createTask">
                    <x-text-input wire:model="name" placeholder="Add Task" class="flex-auto w-96 p-1" />

                    <button type="submit"
                        class="bg-blue-700 hover:bg-blue-600 rounded text-white text-xl font-bold flex-auto w-14 h-8">+</button>

                    @error('name')
                        <div class="w-full flex flex-row mt-1">
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        </div>
                    @enderror

                </form>

            </div>
        </div>
    </div>

    {{-- Task List --}}
    @foreach ($tasks as $key => $task)
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 mt-1 ">
            <div class="bg-white hover:bg-slate-300 overflow-hidden shadow-sm sm:rounded-lg group">
                <div class="p-6 text-gray-900 flex gap-2">
                    <div class="flex-1 w-14">
                        @if ($task->completed)
                            <input wire:click="toggle({{ $task->id }})" type="checkbox"
                                class="rounded border-blue-600" checked>
                        @else
                            <input wire:click="toggle({{ $task->id }})" type="checkbox"
                                class="rounded border-blue-600">
                        @endif
                    </div>
                    <div class="flex-auto w-64">
                        @if ($editTaskID == $task->id)
                            <x-text-input class="flex-1 w-64" wire:model="editTaskName" placeholder="" />
                            <div class=" w-44 grid grid-cols-2 gap-2 pt-4 mx-auto">
                                <button wire:click="update({{ $editTaskID }})"
                                    class="p-1 bg-blue-600 text-white rounded">Save</button>
                                <button wire:click="cancelEdit()"
                                    class="p-1 bg-gray-600 text-white rounded">Cancel</button>
                            </div>
                            @error('editTaskName')
                                <div class="flex flex-row mt-1">
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                </div>
                            @enderror
                        @else
                            <div class="{{ $task->completed ? ' line-through font-bold text-slate-600' : '' }}">
                                {{ $task->name }}</div>
                        @endif
                    </div>

                    <div class="flex-auto w-14 flex justify-center gap-2">
                        <div>{{-- Edit --}}
                            <a href="#" wire:click="editTask({{ $task->id }})">
                                <svg class="w-6 h-6 text-blue-600 hover:text-blue-700 dark:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>

                            </a>
                        </div>

                        <div>{{-- Delete --}}
                            <a href="#" wire:click="deleteTask({{ $task->id }})" wire:confirm="Are you sure?">
                                <svg class="w-6 h-6 text-red-600 hover:text-red-700 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>
