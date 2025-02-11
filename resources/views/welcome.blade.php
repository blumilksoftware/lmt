@props(["previousMeetups" => []])

<x-layout>

  <div class="flex flex-col">
    <div class="flex-1">
      <x-partials.navigation />
      <x-partials.header />

      <x-partials.cta />

      @if (empty($previousMeetups))
        <x-partials.meetups :meetups="$previousMeetups" />
      @endif
    </div>
    <x-partials.footer />
  </div>
</x-layout>

