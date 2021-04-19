<ul class="list-group">
    @foreach ($developers as $dev)
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <div class="fw-bold">{{ $dev->developer }}</div>
            Level {{ $dev->level }}
        </div>
        <span class="badge bg-primary rounded-pill">{{ $dev->task_count }} tasks</span>
    </li>
    @endforeach
    <li class="list-group-item list-group-item-success">
        Estimated time of completion: In <strong>{{ $completionWeek }}</strong> weeks ({{ $completionTime }} hours)
    </li>
</ul>
