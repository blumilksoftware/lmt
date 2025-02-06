@props(["partners" => []])

@php
  $rows = [];
  $row = 0;

  foreach ($partners as $partner) {
      if ($partner->type->isDivision()) {
          $row++;
          continue;
      }

      $rows[$row][] = $partner;
  }
@endphp
<section>
  <div id="partnerzy" class="flex w-full flex-col items-center justify-center space-y-16 bg-slate-950 px-6 py-10 lg:gap-0 lg:bg-[#6C1DF2]">
    @foreach($rows as $row)
      <div class="flex flex-col flex-wrap justify-center gap-16 lg:flex-row">
        @foreach($row as $partner)
          @if (!$partner->type->isDivision())
            <div class="flex flex-col lg:flex-col-reverse">
              <div class="flex justify-start pb-5 pt-0 lg:justify-center lg:pb-0 lg:pt-6">
                <p class="rounded-md bg-violet-700 px-5 py-1 text-center text-white lg:w-[140px] lg:bg-slate-900 lg:py-0">
                  {{ $partner->type->getLabel() }}
                </p>
              </div>
              <div class="flex h-[120px] w-[215px] items-center lg:w-[238px] lg:flex-1">
                <a href="{{ $partner->url }}" target="_blank" class="mx-auto">
                  <img
                      src="{{ $partner->logo->getUrl() }}"
                      :alt="{{ $partner->name }}"
                      class="max-h-[80px]"
                  />
                </a>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    @endforeach
  </div>
</section>