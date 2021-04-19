<x-layout>
    <div class="container">
        <div class="accordion" id="mainAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Developers Summary
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#mainAccordion">
                    <div class="accordion-body">
                        <x-developer-summary
                            :developers="$devs"
                            :completionWeek="$completionWeek"
                            :completionTime="$completionTime"
                            />
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Developers Task List
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#mainAccordion">
                    <div class="accordion-body">
                        <x-developer-tasks id="accordionTaskList" :developers="$devs" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
