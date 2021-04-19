<div class="accordion" id="{{$id}}">
    @foreach ($developers as $dev)
    <div class="accordion-item">
        <h3 class="accordion-header" id="task{{ $dev->id }}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $dev->id }}" aria-expanded="true" aria-controls="collapse{{ $dev->id }}">
                {{ $dev->developer }}
            </button>
        </h3>
        <div id="collapse{{ $dev->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $dev->id }}" data-bs-parent="#{{$id}}">
            <div class="accordion-body">
                <div class="accordion" id="weekly{{$dev->id}}">
                    @foreach ($dev->getWeeklyPlan() as $week => $taskList)
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="week{{ $week }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#weeklist{{ $week }}" aria-expanded="true" aria-controls="weeklist{{ $week }}">
                                Week {{ $week }}
                            </button>
                        </h4>
                        <div id="weeklist{{ $week }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $week }}" data-bs-parent="#weekly{{$dev->id}}">
                            <ul class="list-group list-group-flush">
                                @foreach ($taskList as $task)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{{ $task->name }}</div>
                                        Level {{ $task->level }}
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $task->time }}h</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
