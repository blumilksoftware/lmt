@props(["items" => []])

<section class="relative mt-20 lg:mb-0 lg:mt-32">
  <div class="relative mx-auto max-w-screen-2xl text-white">
    <div class="flex-1" id="agenda">
      <div class="ml-4 flex flex-col gap-3 text-left lg:ml-4 lg:w-full lg:gap-6">
        <div class="text-5xl font-bold">Agenda</div>
        <div class="text-md w-3/4 lg:w-full lg:text-base">
          Każda prezentacja trwa 30 min + 15 min sesja Q&amp;A
        </div>
      </div>
      <ul class="w-max-2xl flex shrink flex-col divide-y divide-slate-100/25 rounded-2xl px-4 py-6">
        @foreach($items as $item)
          <x-agenda>
            <x-slot:start>{{ $item->start }}</x-slot:start>
            <x-slot:title>{{ $item->title }}</x-slot:title>
            @if ($item->speaker)
              <x-slot:speaker>{{ $item->speaker }}</x-slot:speaker>
            @endif
            @if($item->description)
              <x-slot:description>{{ $item->description }}</x-slot:description>
            @endif
          </x-agenda>
        @endforeach
      </ul>
    </div>
  </div>
</section>
