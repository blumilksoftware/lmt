@props(["meetups" => []])

<section id="poprzednieMeetupy">
  <div class="relative max-w-screen-2xl flex-col text-white lg:mx-auto">
    <div class="flex flex-col">
      <div class="flex flex-col px-4 text-left lg:w-full">
        <div class="text-3xl font-bold lg:mt-8 lg:text-5xl">
          Poprzednie edycje
        </div>
        <div class="text-md w-3/4 pt-6 lg:mx-auto lg:w-full lg:px-0 lg:text-base">
          Sprawdź, czy nic Cię nie ominęło
        </div>
      </div>
      <ul class="w-max-2xl flex shrink flex-col divide-y divide-y divide-slate-100/25 rounded-2xl px-4 pt-2">
        @foreach($meetups as $meetup)
          <x-meetup>
            <x-slot:url>{{ route("meetups.show", $meetup->slug) }}</x-slot:url>
            <x-slot:date>{{ $meetup->date->format('d/m/y') }}</x-slot:date>
            <x-slot:title>{{ $meetup->title }}</x-slot:title>
          </x-meetup>
        @endforeach
        <li></li>
      </ul>
    </div>
  </div>
</section>