@props(["speakers" => []])

<section class="my-6">
  <div id="prelegenci" class="static mx-auto w-full text-white">
    <div class="my-16 p-4 text-center text-5xl font-bold lg:hidden">
      Prelegenci
    </div>
    <div class="-my-8 mx-auto hidden! max-w-7xl text-center text-[18em] font-bold text-white opacity-5 lg:block!">
      Lineup
    </div>
    <div class="w-full lg:-mt-48 lg:h-[650px] 2xl:h-[750px]" x-data="carousel({{ count($speakers) }})">
      <div class="hidden! h-full w-full lg:flex!">
        <div class="z-10 hidden! h-full w-fit overflow-hidden rounded-r-2xl bg-black bg-opacity-50 lg:flex!">
          <div class="flex h-full w-full overflow-hidden">
            @foreach($speakers as $speaker)
              <div
                  x-bind:class="{'w-[45%] order-last': current === {{ $loop->index }}, 'w-[27.5%]': current !== {{ $loop->index }}}"
                  class="h-full overflow-hidden"
              >
                <img class="h-full w-full cursor-pointer object-cover object-center"
                     src="{{ $speaker->photo->getUrl("webp") }}"
                     alt="{{ $speaker->full_name }}"
                >
              </div>
            @endforeach
          </div>
        </div>
        <div class="hidden! h-full w-[40%] flex-col pl-[3%] pt-[70px] lg:flex!">
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
                <p class="mb-4 lg:mb-8">
                  {{ $speaker->description }}
                </p>
                @if ($speaker->slides)
                  <a class="mb-4 lg:mb-6" target="_blank"
                     href="{{ $speaker->slides }}">
                    <div class="flex items-center">
                      <x-icons.slides class="mr-2 size-5" aria-label="Przejdź do slajdów z prezentacji" />
                      <p class="font-semibold">{{ $speaker->presentation }}</p>
                    </div>
                  </a>
                @endif
                @if ($speaker->video_url)
                  <a target="_blank" class="mb-4 lg:mb-6" href="{{ $speaker->video_url }}">
                    <div class="flex items-center">
                      <x-icons.presentation class="mr-2 size-5" aria-label="Przejdź do nagrania z prezentacji" />
                      <p class="font-semibold">Obejrzyj na YouTube</p>
                    </div>
                  </a>
                @endif
              </div>
            </div>
          @endforeach
          <div class="flex h-full flex-row items-end gap-2 pb-14 pt-4">
            <button
                @click="previous()"
                class="flex h-[68px] w-[68px] cursor-pointer items-center justify-center rounded-[5px] border border-violet-700"
            >
              <x-icons.arrow class="rotate-180" />
            </button>
            <button
                @click="next()"
                class="flex h-[68px] w-[68px] cursor-pointer items-center justify-center rounded-[5px] bg-violet-700">
              <x-icons.arrow />
            </button>
          </div>
        </div>
      </div>
      <div class="lg:hidden">
        @foreach($speakers as $speaker)
          <div class="flex w-full flex-col">
            <div>
              <img class="h-full w-full"
                   src="{{ $speaker->photo->getUrl("webp") }}"
                   alt="{{ $speaker->full_name }}"
              >
            </div>
            <div class="px-14 pt-12 font-bold">
              <div class="text-4xl">{{ $speaker->first_name }}</div>
              <div class="text-4xl">{{ $speaker->last_name }}</div>
            </div>
            <div class="px-14 pt-4 text-base">
              @foreach($speaker->companies as $company)
                <a target="_blank" href="{{ $company['url'] }}"
                   class="font-bold text-violet-700">{{ $company['name'] }}</a>
              @endforeach
            </div>
            <div class="flex px-14 pb-14 pt-4 text-base text-neutral-200">
              <p>
                {{ $speaker->description }}
              </p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>