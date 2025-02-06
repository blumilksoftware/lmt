@props(['targetDate'])

<div
    class="w-max-2xl flex flex-shrink divide-x divide-slate-100/25 rounded-[13px] bg-stone-900/75 px-10 py-6 md:rounded-[33px] md:px-4"
    x-data="timer('{{ $targetDate }}')"
>
  <div class="flex px-4">
    <span></span>
    <div class="text-5xl font-bold text-[#01FF6B] sm:text-8xl" x-text="days"></div>
    <div class="rotate-180 py-1 text-sm">
      <div class="rotate-90 px-1">dni</div>
    </div>
  </div>
  <div class="flex px-4">
    <div class="text-5xl font-bold sm:text-8xl" x-text="hours"></div>
    <div class="rotate-180 py-4 text-sm">
      <div class="rotate-90 px-1">godzin</div>
    </div>
  </div>
  <div class="flex px-4">
    <div class="text-8xl font-bold" x-text="minutes"></div>
    <div class="rotate-180 py-3 text-sm">
      <div class="rotate-90 px-1">minut</div>
    </div>
  </div>
  <div class="flex px-4">
    <div class="text-8xl font-bold" x-text="seconds"></div>
    <div class="rotate-180 py-5 text-sm">
      <div class="rotate-90 px-1">sekund</div>
    </div>
  </div>
</div>