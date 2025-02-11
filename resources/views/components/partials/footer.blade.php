@props(['meetup' => null])

<section class="relative mt-[110px] lg:mt-48">
  @if ($meetup?->isCurrent())
    <livewire:contact-form :meetup="$meetup" />
  @endif
  <div class="bg-white px-2 py-4 xs:px-4 lg:mt-[74px] lg:p-8">
    <div class="relative z-20 mx-auto flex! max-w-7xl items-center opacity-50">
      <div class="flex! flex-grow flex-col text-xs lg:flex-row lg:gap-2 lg:text-base">
        <div>
          2025 Legnicki Meetup Technologiczny powered by
          <a href="https://blumilk.pl/"
             class="font-bold"
             target="_blank"
             aria-label="Przejdź do strony firmowej Blumilk"
          >
            Blumilk
          </a>
        </div>
        <div>
          @if ($meetup?->isCurrent() && $meetup?->regulations)
            <a href="{{ $meetup->regulations->getUrl() }}" target="_blank">
              <p>| Regulamin</p>
            </a>
          @endif
        </div>
      </div>
      <div class="flex gap-3 sm:gap-4">
        <a href="https://github.com/blumilksoftware/"
           target="_blank"
           aria-label="Przejdź do GitHub Blumilk"
        >
          <x-icons.github class="size-6" />
        </a>
        <a
            href="https://www.facebook.com/groups/legnickimeetuptechnologiczny/"
            target="”_blank”"
            aria-label="Przejdź do grupy Legnicki Meetup Technologiczny na Facebooku"
        >
          <x-icons.facebook class="size-6" />
        </a>
        <a
            href="https://www.linkedin.com/showcase/legnicki-meetup-technologiczny/posts"
            target="_blank"
            aria-label="Zobacz posty na LinkedIn dotyczące Legnickiego Meetup Technologicznego"
        >
          <x-icons.linkedin class="size-6" />
        </a>
      </div>
    </div>
    <div class="absolute bottom-0 right-0 z-10 -mr-[15em] hidden! h-[16em] overflow-hidden lg:block! 3xl:-mr-[10em] 4xl:-mr-[5em]">
      <div class="size-[56em] rounded-full border-[86px] border-violet-700 4xl:size-[74em]"></div>
    </div>
  </div>
</section>
