@props(["speakers" => []])
<section class="my-6">
    <div id="prelegenci" class="static mx-auto w-full text-white">
        <div class="my-16 p-4 text-center text-5xl font-bold 2xl:hidden">
            Prelegenci
        </div>
        <div class="-my-8 mx-auto hidden! max-w-7xl text-center text-[18em] font-bold text-white opacity-5 2xl:block!">
            Lineup
        </div>
        <div class="w-full 2xl:-mt-48 2xl:h-[750px]" x-data="carousel({{ count($speakers) }})">

            <div class="hidden! h-full w-full 2xl:flex!">
                <div class="z-10 hidden! h-full w-fit overflow-hidden rounded-r-2xl 2xl:flex!">
                    <div class="flex h-full w-full max-h-[750px] overflow-hidden">
                        @foreach($speakers as $speaker)
                            <div
                                    x-bind:class="{ 'w-full': {{ count($speakers) }} === 1, 'w-[45%] order-last': current === {{ $loop->index }} && {{ count($speakers) }} > 1, 'w-[27.5%]': current !== {{ $loop->index }} && {{ count($speakers) }} > 1 }"
                                    class="h-full overflow-hidden"
                            >
                                <img
                                        class="h-full w-full max-h-[750px] cursor-pointer object-cover object-center"
                                        src="{{ $speaker->photo->getUrl('webp') }}"
                                        alt="{{ $speaker->full_name }}"
                                >
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="hidden! h-full w-[40%] flex-col pl-[3%] pt-[70px] 2xl:flex!">
                    <div class="w-[111px] rounded-md bg-violet-700 text-center text-base text-white">
                        Prelegenci
                    </div>
                    @foreach($speakers as $speaker)
                        <div x-bind:class="{ 'hidden!': current !== {{ $loop->index }}}">
                            <div class="pt-6 font-bold">
                                <div class="text-4xl">{{ $speaker->first_name }}</div>
                                <div class="text-4xl">{{ $speaker->last_name }}</div>
                            </div>
                            <div class="pt-4 text-base text-gray-300">
                                @foreach($speaker->companies as $company)
                                    <a target="_blank" href="{{ $company['url'] }}" class="font-bold text-violet-700">
                                        {{ $company['name'] }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="flex flex-col w-3/4 pt-6 text-base text-gray-300">
                                <p class="mb-4 2xl:mb-8">{{ $speaker->description }}</p>
                                @if ($speaker->slides)
                                    <a class="mb-4 2xl:mb-6" target="_blank" href="{{ $speaker->slides->getUrl() }}">
                                        <div class="flex items-center">
                                            <x-icons.slides class="mr-2 size-5" aria-label="Przejdź do slajdów z prezentacji" />
                                            <p class="font-semibold">{{ $speaker->presentation }}</p>
                                        </div>
                                    </a>
                                @endif
                                @if ($speaker->video_url)
                                    <a target="_blank" class="mb-4 2xl:mb-6" href="{{ $speaker->video_url }}">
                                        <div class="flex items-center">
                                            <x-icons.presentation class="mr-2 size-5" aria-label="Przejdź do nagrania z prezentacji" />
                                            <p class="font-semibold">Obejrzyj na YouTube</p>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if(count($speakers) > 1)
                        <div class="flex h-full flex-row items-end gap-2 pb-14 pt-4">
                            <button
                                    @click="previous()"
                                    class="flex h-[68px] w-[68px] cursor-pointer items-center justify-center rounded-[5px] border border-violet-700"
                            >
                                <x-icons.arrow class="rotate-180" />
                            </button>
                            <button
                                    @click="next()"
                                    class="flex h-[68px] w-[68px] cursor-pointer items-center justify-center rounded-[5px] bg-violet-700"
                            >
                                <x-icons.arrow />
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hidden! md:block! 2xl:hidden!">
                <div class="space-y-10 px-6 py-4">
                    @foreach($speakers as $speaker)
                        <div class="flex flex-row overflow-hidden rounded-2xl">
                            <div class="w-[40%] shrink-0 overflow-hidden">
                                <img
                                        class="h-full w-full object-cover object-center"
                                        src="{{ $speaker->photo->getUrl('webp') }}"
                                        alt="{{ $speaker->full_name }}"
                                >
                            </div>
                            <div class="w-[60%] flex flex-col justify-center space-y-3 px-8 py-8">
                                <div class="font-bold">
                                    <div class="text-3xl">{{ $speaker->first_name }}</div>
                                    <div class="text-3xl">{{ $speaker->last_name }}</div>
                                </div>
                                <div class="text-base">
                                    @foreach($speaker->companies as $company)
                                        <a target="_blank" href="{{ $company['url'] }}" class="font-bold text-violet-700">
                                            {{ $company['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                                <div class="text-base text-neutral-300">
                                    <p>{{ $speaker->description }}</p>
                                </div>
                                @if ($speaker->slides)
                                    <a target="_blank" href="{{ $speaker->slides->getUrl() }}">
                                        <div class="flex items-center">
                                            <x-icons.slides class="mr-2 size-5" aria-label="Przejdź do slajdów z prezentacji" />
                                            <p class="font-semibold">{{ $speaker->presentation }}</p>
                                        </div>
                                    </a>
                                @endif
                                @if ($speaker->video_url)
                                    <a target="_blank" href="{{ $speaker->video_url }}">
                                        <div class="flex items-center">
                                            <x-icons.presentation class="mr-2 size-5" aria-label="Przejdź do nagrania z prezentacji" />
                                            <p class="font-semibold">Obejrzyj na YouTube</p>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="md:hidden!">
                @foreach($speakers as $speaker)
                    <div class="flex w-full flex-col mb-10">
                        <div class="overflow-hidden max-h-[500px]">
                            <img
                                    class="w-full max-h-[500px] object-cover object-center"
                                    src="{{ $speaker->photo->getUrl('webp') }}"
                                    alt="{{ $speaker->full_name }}"
                            >
                        </div>
                        <div class="px-8 pt-8 pb-8 space-y-4">
                            <div class="font-bold">
                                <div class="text-4xl">{{ $speaker->first_name }}</div>
                                <div class="text-4xl">{{ $speaker->last_name }}</div>
                            </div>
                            <div class="text-base">
                                @foreach($speaker->companies as $company)
                                    <a target="_blank" href="{{ $company['url'] }}" class="font-bold text-violet-700">
                                        {{ $company['name'] }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="text-base text-neutral-200">
                                <p>{{ $speaker->description }}</p>
                            </div>
                            @if ($speaker->slides)
                                <a target="_blank" href="{{ $speaker->slides->getUrl() }}">
                                    <div class="flex items-center">
                                        <x-icons.slides class="mr-2 size-5" aria-label="Przejdź do slajdów z prezentacji" />
                                        <p class="font-semibold">{{ $speaker->presentation }}</p>
                                    </div>
                                </a>
                            @endif
                            @if ($speaker->video_url)
                                <a target="_blank" href="{{ $speaker->video_url }}">
                                    <div class="flex items-center">
                                        <x-icons.presentation class="mr-2 size-5" aria-label="Przejdź do nagrania z prezentacji" />
                                        <p class="font-semibold">Obejrzyj na YouTube</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
