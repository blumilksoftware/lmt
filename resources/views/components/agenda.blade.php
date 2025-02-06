<li class="flex flex-col" x-data="disclosure()">
  <div class="flex items-center py-8">
    <div class="w-[100px] text-4xl font-bold">{{ $start }}</div>
    <div class="flex flex-col gap-2">
      <div class="px-8">{{ $title }}</div>
      <div class="px-8 text-sm">{{ $speaker ?? '' }}</div>
    </div>
    @if (isset($description))
      <div class="flex flex-grow cursor-pointer justify-end" @click="toggle()">
        <x-icons.chevron-up class="size-6" x-bind:class="{ 'hidden': !expanded }" />
        <x-icons.chevron-down class="size-6" x-bind:class="{ 'hidden': expanded }" />
      </div>
    @endif
  </div>
  @if(isset($description))
    <div x-show="expanded" class="-mt-12 flex items-center py-8">
      <p>{{ $description }}</p>
    </div>
  @endif
</li>