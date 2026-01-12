@props(["photographers" => "", "photos" => []])

@php
  [$row1, $row2, $row3, $row4] = collect($photos)->chunk(3)
@endphp

<section id="galeria" x-data="gallery({{ count($photos) }})" class="mt-16">
  <div class="relative mx-auto flex flex-col text-white">
    <div class="relative flex max-w-screen-2xl flex-row justify-between px-4 text-white 2xl:mx-auto 2xl:min-w-[1536px]">
      <div class="flex-col">
        <h2 class="text-5xl font-bold">Galeria</h2>
        <div class="pt-4 text-base text-neutral-200">
          Autorzy zdjęć: {{ $photographers }}
        </div>
      </div>
      <div class="hidden! flex-row justify-end gap-10 lg:flex!">
        <x-icons.circle class="size-7" />
        <x-icons.circle class="size-7" />
        <x-icons.circle class="size-7" />
        <x-icons.circle class="size-7" />
        <x-icons.circle class="size-7" />
        <x-icons.circle class="size-7" />
        <x-icons.circle class="size-7" />
      </div>
    </div>
    <div class="mt-5 grid grid-cols-1 gap-4 px-4 md:grid-cols-2 lg:mt-20 lg:grid-cols-4">
      <div class="grid gap-4 grid-rows-[40fr_25fr_35fr]">
        @foreach($row1 as $photo)
          <div class="overflow-hidden rounded-md" @click="select({{ $loop->index }})">
            <img
                class="h-full w-full cursor-pointer rounded-md object-cover transition-transform duration-300 hover:scale-105 aspect-[4/3]"
                src="{{ $photo->getUrl("webp") }}"
                alt="">
          </div>
        @endforeach
      </div>
      <div class="grid gap-4 grid-rows-[30fr_45fr_25fr]">
        @foreach($row2 as $photo)
          <div class="overflow-hidden rounded-md" @click="select({{ $loop->index + 3 }})">
            <img
                class="h-full w-full cursor-pointer rounded-md object-cover transition-transform duration-300 hover:scale-105 aspect-[4/3]"
                src="{{ $photo->getUrl("webp") }}"
                alt="">
          </div>
        @endforeach
      </div>
      <div class="grid gap-4 grid-rows-[45fr_25fr_30fr]">
        @foreach($row3 as $photo)
          <div class="overflow-hidden rounded-md" @click="select({{ $loop->index + 6 }})">
            <img
                class="h-full w-full cursor-pointer rounded-md object-cover transition-transform duration-300 hover:scale-105 aspect-[4/3]"
                src="{{ $photo->getUrl("webp") }}"
                alt="">
          </div>
        @endforeach
      </div>
      <div class="grid gap-4 grid-rows-[25fr_55fr_20fr]">
        @foreach($row4 as $photo)
          <div class="overflow-hidden rounded-md" @click="select({{ $loop->index + 9 }})">
            <img
                class="h-full w-full cursor-pointer rounded-md object-cover transition-transform duration-300 hover:scale-105 aspect-[4/3]"
                src="{{ $photo->getUrl("webp") }}"
                alt="">
          </div>
        @endforeach
      </div>
    </div>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70" x-show="active">
      <button class="absolute right-4 top-4 z-20 text-5xl text-white" @click="exit()">
        ×
      </button>
      <button class="absolute left-4 top-1/2 z-10 -translate-y-1/2 transform text-5xl text-white" @click="previous()">
        &lt;
      </button>
      <button class="absolute right-4 top-1/2 z-10 -translate-y-1/2 transform text-5xl text-white" @click="next()">
        &gt;
      </button>
      <div class="relative flex h-full w-full max-w-screen-2xl items-center justify-center">
        @foreach($photos as $photo)
          <img class="max-h-full max-w-full object-contain"
               x-show="current === {{ $loop->index }}"
               src="{{ $photo->getUrl("webp") }}"
               alt="">
        @endforeach
      </div>
    </div>
  </div>
</section>
