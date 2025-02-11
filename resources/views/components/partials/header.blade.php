@props(['meetup' => null, 'previousMeetups' => []])

<section>
  <div class="relative mx-auto flex! max-w-7xl flex-col items-start px-4 pt-[74px] text-white md:pt-36 lg:px-8">
    <div class="absolute right-10 top-0 hidden! lg:right-40 lg:block! 2xl:right-0">
      <x-icons.xmark class="mt-12 size-24" />
    </div>
    <div class="absolute right-0 top-10 hidden! h-24 w-24 lg:block! 2xl:right-10">
      <x-icons.xmark-white class="mt-36 size-12 2xl:ml-40" />
    </div>
    <div id="wydarzenie"
         class="px-4 text-left text-[42px] font-bold leading-none sm:pl-0 sm:text-7xl lg:w-full lg:text-9xl">
      Nowoczesne technologie
    </div>
    <div class="flex items-center pt-6 text-2xl md:pt-9 md:text-[40px]">
      <span class="flex-grow px-4 md:px-2">
        Inteligentne rozwiązania, lokalne podejście
      </span>
    </div>
    @if ($meetup?->isCurrent())
      <div class="mt-8 flex h-[35px] flex-col pl-3 md:mt-12 md:flex-row md:divide-x md:divide-slate-100/25">
        <div class="flex flex-row items-center pl-2 md:pr-8 lg:pl-0">
          <x-icons.calendar class="size-6 self-center lg:size-4" />
          <span class="pl-3 text-xl">
          {{ $meetup->date->translatedFormat("d F Y, H:i") }}
        </span>
        </div>
        <div class="flex! flex-row items-center pl-2 pt-4 md:pl-8 md:pt-0">
          <x-icons.location class="size-6 self-center lg:size-4" />
          <a href="httpss://www.google.com" target="_blank" class="pl-3 text-xl hover:underline">
            {{ $meetup->place }}
          </a>
        </div>
      </div>
      <div class="mx-0 mt-10 hidden! lg:flex!">
        <x-timer target-date="{{ $meetup->date->toDateTimeString() }}" />
      </div>
    @endif
  </div>
  <div
      class="mx-9 mb-32 mt-[90px] grid max-w-screen-2xl grid-cols-1 gap-7 text-white md:mt-44 lg:mx-3 lg:grid-cols-3 xl:px-14 2xl:mx-auto 2xl:px-0">
    <x-question>
      <x-slot:question>O co chodzi?</x-slot:question>
      <x-slot:answer>
        Organizujemy cykliczne spotkania w Legnicy, na których chętne
        osoby prezentują w dowolnej formie swoje doświadczenia i
        przemyślenia w dziedzinie programowania aplikacji internetowych.
      </x-slot:answer>
    </x-question>
    <x-question>
      <x-slot:question>Dla kogo?</x-slot:question>
      <x-slot:answer>
        Spotkania są dostępne dla każdego, bez względu na stopień
        doświadczenia zawodowego czy wykorzystywaną technologię.
        Zapraszamy programistów, grafików, administratorów, devopsów
        oraz pasjonatów i hobbystów.
      </x-slot:answer>
    </x-question>
    <x-question>
      <x-slot:question>O czym?</x-slot:question>
      <x-slot:answer>
        Od programowania backendu i projektowania frontendu, przez
        testowanie aplikacji, ciekawostki technologiczne czy szeroko
        rozumiany devops, a na sprawach okołoprogramistycznych i
        umiejętnościach miękkich skończywszy.
      </x-slot:answer>
    </x-question>
  </div>
</section>