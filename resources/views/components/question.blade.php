<div class="rounded-3xl border border-violetb p-8">
    <div class="flex! flex-col lg:hidden!">
        <div class="flex flex-row items-center">
            <img
                src="{{ asset('images/icons/question.svg') }}"
                class="size-9 self-start"
                alt="Znak zapytania"
            />
            <h2 class="pl-4 text-2xl font-bold">
                {{ $question }}
            </h2>
        </div>
        <div class="flex-col pt-4 md:pl-8">
            <p class="text-sm font-normal leading-5 tracking-tight">
                {{ $answer }}
            </p>
        </div>
    </div>
    <div class="hidden! flex-row lg:flex!">
        <img
            src="{{ asset('images/icons/question.svg') }}"
            class="size-9 self-start"
            alt="Znak zapytania"
        />
        <div class="flex-col pl-8">
            <h2 class="text-2xl font-bold">
                {{ $question }}
            </h2>
            <p class="mt-5 text-base leading-5 tracking-tight">
                {{ $answer }}
            </p>
        </div>
    </div>
</div>