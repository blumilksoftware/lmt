@props(["previousMeetups" => []])

<x-layout>

  <x-partials.navigation />
  <x-partials.header />

  <x-partials.cta />

  <x-partials.meetups :meetups="$previousMeetups" />

  <x-partials.footer />
</x-layout>

