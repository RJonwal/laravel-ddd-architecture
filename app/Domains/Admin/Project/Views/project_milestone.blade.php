@extends('Layouts::app')
@section('title', __('global.view').' '.__('cruds.project.title').' '.__('cruds.milestone.title'))

@section('custom_css')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<style>
    .no-select() {
        -moz-user-select: none;
        -ms-user-select: none;
        -webkit-user-select: none;
        user-select: none;
    }

    .no-wrap() {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    #dragRoot {
        .no-select();
        cursor: default;
        border: 1px solid black;
        margin: 10px;
        padding: 10px;
        overflow-y: scroll;
        white-space: nowrap;

        ul {
            display: block;
            margin: 0;
        }

        li {
            
            display: block;
            margin: 2px;
            padding: 2px 2px 2px 0;
        
            [class*="node"] {
                display: inline-block;            
            }

            .node-facility {
                font-weight: bold;
            }
            
            .node-cpe {
            cursor: pointer;
            }

        }

        li[data-type="sprint"]::before, li li {
            &::before {
                font-weight: 300;
                content: "— ";
            }
        } 
    }
</style>
@endsection

@section('main-content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    @if($project)
                        <div class="card-block bg-c-blue">
                            <div class="counter text-center">
                                <h3 class="text-white m-0">{{ $project->name ?? '' }}'s @lang('cruds.milestone.title')</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if($project->milestones->isNotEmpty())
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <section style="padding: 10px;">
                            <ul id="dragRoot">
                            @foreach($project->milestones as $milestone)
                                <li data-milestone-id="{{ $milestone->id }}" data-project-id="{{ $milestone->project_id }}"  data-type="milestone" data-id="{{ $milestone->id }}">
                                    <i class="icon-building"></i>
                                    <span class="node-facility" data-milestone-id="{{ $milestone->id }}" data-id="{{ $milestone->id }}" data-type="milestone">
                                        {{ $milestone->name }}
                                    </span>
                                    <button class="btn btn-sm btn-link text-danger delete-item" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    @php 
                                        $milestoneStatusKey = $milestone->status;
                                        $milestoneStatusLabel = config('constant.milestone_status')[$milestoneStatusKey] ?? 'Unknown';
                                        $milestoneBadgeClass = match($milestoneStatusKey) {
                                            'initial' => 'badge bg-danger',
                                            'in_progress' => 'badge bg-warning text-dark',
                                            'completed' => 'badge bg-success',
                                            'not_started' => 'badge bg-secondary',
                                            'hold'        => 'badge bg-primary',
                                        };
                                    @endphp
                                    <span class="ms-2 badge {{ $milestoneBadgeClass }}">{{ $milestoneStatusLabel }}</span>
                                    <br>
                                    <small>
                                        Start: {{ $milestone->start_date->format(config('constant.date_format.date')) }} <br>
                                        End: {{ $milestone->end_date->format(config('constant.date_format.date')) }}
                                    </small>

                                    <ul class="sprint-list">
                                        @foreach($milestone->sprints as $sprint) 
                                        <li data-sprint-id="{{ $sprint->id }}" data-type="sprint" data-id="{{ $sprint->id }}">
                                            <i class="icon-flag"></i>
                                            <span class="node-cpe" data-sprint-id="{{ $sprint->id }}" data-type="sprint" data-id="{{ $sprint->id }}">{{ $sprint->name }}</span>
                                            <button class="btn btn-sm btn-link text-danger delete-item" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <small>
                                                ({{ $sprint->start_date->format(config('constant.date_format.date')) }} - 
                                                {{ $sprint->end_date->format(config('constant.date_format.date')) }})
                                            </small>

                                            <ul class="task-list">
                                                @foreach ($sprint->tasks as $task)
                                                    <li data-task-id="{{ $task->id }}" data-id="{{ $task->id }}" data-type="{{ $task->parent_task_id ? 'subtask' : 'task' }}" data-sprint-id="{{ $task->sprint_id }}" data-milestone-id="{{ $task->milestone_id }}" class="{{ $task->parent_task_id ? 'is-subtask' : '' }}">
                                                        <i class="icon-hdd"></i>
                                                        <span class="node-cpe" data-task-id="{{ $task->id }}"  data-sprint-id="{{ $task->sprint_id }}" data-milestone-id="{{ $task->milestone_id }}" data-id="{{ $task->id }}" data-type="{{ $task->parent_task_id ? 'subtask' : 'task' }}">
                                                            {{ $task->name ?? '' }} 
                                                        </span>
                                                        <button class="btn btn-sm btn-link text-danger delete-item" title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        <span>
                                                            {{ $task->user->name ?? 'Unassigned' }},
                                                            {{ $task->estimated_time ?? '-' }},
                                                            {{ config('constant.task_priority')[$task->priority] ?? 'N/A' }}
                                                            @php
                                                                $taskStatusKey = $task->status;
                                                                $taskStatusLabel = config('constant.task_status')[$taskStatusKey] ?? 'Unknown';
                                                                $taskBadgeClass = match($taskStatusKey) {
                                                                    'initial' => 'badge bg-danger',
                                                                    'in_progress' => 'badge bg-warning text-dark',
                                                                    'completed' => 'badge bg-success',
                                                                    'not_started' => 'badge bg-secondary',
                                                                    'hold'        => 'badge bg-primary',
                                                                };
                                                            @endphp
                                                        </span>
                                                        <span class="badge {{ $taskBadgeClass }}">{{ $taskStatusLabel }}</span>
                                                        @if ($task->children->isNotEmpty())
                                                            <ul class="sub-task-list">
                                                                @foreach ($task->children as $subtask)
                                                                    <li data-type="{{ $subtask->parent_task_id ? 'subtask' : 'task' }}" data-id="{{ $subtask->id }}"  data-task-id="{{ $subtask->id }}" data-milestone-id="{{ $subtask->milestone_id }}" data-sprint-id="{{ $subtask->sprint_id }}" class="{{ $subtask->parent_task_id ? 'is-subtask' : '' }}">
                                                                        <i class="icon-hdd"></i>
                                                                        <span class="node-cpe" data-task-id="{{ $subtask->id }}" data-milestone-id="{{ $subtask->milestone_id }}" data-sprint-id="{{ $subtask->sprint_id }}" data-type="{{ $subtask->parent_task_id ? 'subtask' : 'task' }}" data-id="{{ $subtask->id }}">
                                                                            {{ $subtask->name ?? '' }} 
                                                                        </span>  
                                                                        <button class="btn btn-sm btn-link text-danger delete-item" title="Delete">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                        <span>—
                                                                            {{ $subtask->user->name ?? 'Unassigned' }},
                                                                            {{ $subtask->estimated_time ?? '-' }},
                                                                            {{ config('constant.task_priority')[$subtask->priority] ?? 'N/A' }} </span>
                                                                            @php
                                                                                $subStatusKey = $subtask->status;
                                                                                $subStatusLabel = config('constant.task_status')[$subStatusKey] ?? 'Unknown';
                                                                                $subBadgeClass = match($subStatusKey) {
                                                                                    'initial' => 'badge bg-danger',
                                                                                    'in_progress' => 'badge bg-warning text-dark',
                                                                                    'completed' => 'badge bg-success',
                                                                                    'not_started' => 'badge bg-secondary',
                                                                                    'hold'        => 'badge bg-primary',
                                                                                };
                                                                            @endphp
                                                                        <span class="badge {{ $subBadgeClass }}">{{ $subStatusLabel }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                        
                                                    </li>
                                                @endforeach
                                                @if ($sprint->tasks->count() === 0)
                                                    <li class="no-tasks" data-sprint-id="{{ $sprint->id }}" data-milestone-id="{{ $sprint->milestone_id }}"><em>No tasks under this sprint.</em></li>
                                                @endif
                                            </ul>
                                        </li>
                                        @endforeach                                            
                                        @if ($milestone->sprints->count() === 0)
                                            <li class="no-tasks" data-milestone-id="{{ $milestone->id }}"><em>No sprints under this milestone.</em></li>
                                        @endif
                                    </ul>
                                </li>
                            @endforeach
                            </ul>
                        </section>
                    </div>
                </div>
            </div>
        @endif                                                      
    </div>
</div>

@endsection

@section('custom_js')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    var DragAndDrop = (function (DragAndDrop) {

    function shouldAcceptDrop(item) {

        var $target = $(this).closest("li");
        var $item = item.closest("li");

        if ($.contains($item[0], $target[0])) {
            return false;
        }

        // if ($target.hasClass("is-subtask")) {
        //     return false;
        // }

        const draggedType = $item.data('type');   // task/subtask
        const targetType = $target.data('type');  // milestone/task/subtask

        const isDraggedTask = draggedType === 'task';
        const hasSubtasks = $item.find('ul > li').length > 0;
        const isTargetTask = targetType === 'task';

        // if (isDraggedTask && hasSubtasks && isTargetTask) {
        //     return false;
        // }

        // if (isDraggedTask && targetType === 'milestone') {
        //     return false;
        // }
        
        return true;
    }

    function itemOver(event, ui) {
    }

    function itemOut(event, ui) {
    }

    function itemDropped(event, ui) {
        const $target = $(this).closest("li");
        const $item = ui.draggable.closest("li");

        const itemId = $item.data('id');
        const draggedType = $item.data('type'); // task or subtask or sprint
        const targetId = $target.data('id');
        const targetType = $target.data('type'); // milestone, sprint, task

        // Determine new position
        const newMilestoneId = $target.closest('li[data-milestone-id]').data('milestone-id') || null;
        const newSprintId = $target.closest('li[data-sprint-id]').data('sprint-id') || null;

        // Validation rules
        const isSubtask = draggedType === 'subtask';
        const isTask = draggedType === 'task';
        const isSprint = draggedType === 'sprint';

        const targetIsTask = targetType === 'task';
        const targetIsSprint = targetType === 'sprint';
        const targetIsMilestone = targetType === 'milestone';

        // Milestones are not draggable at all
        if (draggedType === 'milestone') {
            alert("Milestones cannot be moved.");
            return;
        }

        // Validate if a task with subtasks is being dropped into another task
        if (isTask && targetIsTask && $item.find('ul > li').length > 0) {
            alert("Cannot move a task with subtasks into another task.");
            return;
        }

        // Apply drag rules
        let parentTaskId = null;

        if (isSprint) {
            // Moving sprint under a milestone
            if (!targetIsMilestone) {
                // alert("Sprints can only be moved under milestones.");
                return;
            }
        } else if (isTask || isSubtask) {
            if (targetIsSprint) {
                parentTaskId = null; // becomes parent task
            } else if (targetIsTask) {
                parentTaskId = targetId; // becomes subtask
            } else {
                // alert("Tasks/Subtasks must be placed inside sprints or tasks.");
                return;
            }
        }

        // DOM rearrangement
        const $srcUL = $item.parent("ul");
        let $dstUL = $target.children("ul").first();

        if ($dstUL.length === 0) {
            $dstUL = $("<ul></ul>");
            $target.append($dstUL);
        }

        $item.slideUp(50, function () {
            $dstUL.append($item);

            if ($srcUL.children("li").length === 0) {
                $srcUL.remove();
            }

            $(`li.no-tasks[data-milestone-id="${newMilestoneId}"]`).remove();
            $(`li.no-tasks[data-sprint-id="${newSprintId}"]`).remove();

            $item.slideDown(50, function () {
                $item.css('display', '');

                // Send AJAX update
                let postData = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    item_id: itemId,
                    parent_task_id: parentTaskId,
                    new_milestone_id: newMilestoneId,
                    new_sprint_id: newSprintId,
                    item_type: draggedType,
                };

                let url = (draggedType === 'sprint') ? '/sprints/reorder' : '/tasks/reorder';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: postData,
                    success: function (res) {
                        console.log(`${draggedType} position updated:`, res);
                    },
                    error: function (err) {
                        console.error(err);
                        alert(`Failed to update ${draggedType} position.`);
                    }
                });
            });
        });
    }

    DragAndDrop.enable = function (selector) {

        $(selector).find(".node-cpe").draggable({
            helper: "clone"
        });

        $(selector).find(".node-cpe, .node-facility").droppable({
            activeClass: "active",
            hoverClass: "hover",
            accept: shouldAcceptDrop,
            over: itemOver,
            out: itemOut,
            drop: itemDropped,
            greedy: true,
            tolerance: "pointer"
        });

    };

    return DragAndDrop;

})(DragAndDrop || {});

(function ($) {
  
  $.fn.beginEditing = function(whenDone) {
    
    if (!whenDone) { whenDone = function() { }; }
    
    var $node = this;
    var $editor = $("<input type='text' style='width:auto; min-width: 50px;'></input>");
    var currentValue = $node.text().trim();

    var id = $node.data('id');
    var type = $node.data('type');
    function commit() {
        const newValue = $editor.val().trim();
        $editor.remove();
        $node.text($editor.val());
        $.ajax({
            url: '/inline-update',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                type: type,
                name: newValue
            },
            success: function () {
                whenDone($node);
            },
            error: function () {
                alert("Update failed.");
                $node.text(currentValue); // rollback
                whenDone($node);
            }
      });
    }
    
    function cancel() {
      $editor.remove();
      $node.text(currentValue);
      whenDone($node);
    }
    
    $editor.val(currentValue);
    $editor.blur(function() { commit(); });
    $editor.keydown(function(event) {
      if (event.which == 27) { cancel(); return false; }
      else if (event.which == 13) { commit(); return false; }
    });

    $node.empty();
    $node.append($editor);
    $editor.focus();
    $editor.select();
    
  };
  
})(jQuery);

$(function () {
  DragAndDrop.enable("#dragRoot");
  
  $(document).on("dblclick", "#dragRoot *[class*=node]", function() {
    $(this).beginEditing();
  });
  
});


$(document).on("click", ".delete-item", function (e) {
    e.stopPropagation(); 

    const $node = $(this).siblings("[class*=node]");
    const id = $node.data("id");
    const type = $node.data("type");
    // if (!confirm(`Are you sure you want to delete this ${type}?`)) return;
    Swal.fire({
        title: "{{ trans('global.areYouSure') }}",
        text: "{{ trans('global.onceClickedRecordDeleted') }}",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "{{ trans('global.swl_confirm_button_text') }}",
        denyButtonText: "{{ trans('global.swl_deny_button_text') }}"
    }).then(function (result) {
        if (result.isConfirmed) {
            pageLoader('show');
            $.ajax({
                type: 'DELETE',
                url: '/inline-delete',
                dataType: 'json',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    type: type
                },
                success: function (response) {
                    $node.closest("li").remove(); // remove the parent <li>

                    if (response.success) {
                        $('li[data-milestone-id="' + response.deleted_id + '"]').remove();
                        toasterAlert('success', response.message);
                    } else {
                        toasterAlert('error', response.error);
                    }
                },
                error: function () {
                   toasterAlert('error', res.responseJSON?.error || 'Something went wrong.');
                },
                complete: function () {
                    pageLoader('hide');
                }
            });
        }
    });
});

</script>

@parent

@endsection