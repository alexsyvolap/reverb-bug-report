<x-filament-panels::page>
    <div
        class="relative max-h-[45%]"
        x-init="
            window.Echo.private('{{ $channelName }}')
                .listen('.message', (e) => { @this.call('incomingMessage', e) })
            ">

        <div id="messages"
             class="relative h-[60vh] overflow-y-auto bg-white rounded-lg shadow-md p-6 scroll-smooth dark:bg-gray-900 dark:ring-white/10"
             x-data="{ scroll: () => { $el.scrollTo(0, $el.scrollHeight); }}"
             x-intersect="scroll()">

            @forelse($messages as $message)
                <div class="flex items-start gap-2.5 mb-5 @if($message->sender_id === Auth::id()) justify-end @endif">
                    <div class="flex flex-col gap-1 w-fit max-w-[320px]">
                        <div class="flex items-center gap-x-2 rtl:space-x-reverse">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $message->sender->name }}
                            </span>
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                {{ $message->created_at->format('d.m.Y H:i') }}
                            </span>
                        </div>
                        <div
                            class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-100 dark:bg-white/5 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                            <p class="text-sm font-normal text-gray-900 dark:text-white">
                                {{ $message->content }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-gray-600">
                    Empty...
                </div>
            @endforelse
        </div>

        <div
            class="flex flex-row justify-between gap-x-5 mt-6 p-6 bg-white rounded-lg shadow-md dark:bg-gray-900 dark:ring-white/10">
            <x-filament::input.wrapper class="w-full" :valid="! $errors->has('content')">
                <x-filament::input
                    type="text"
                    placeholder="Enter message..."
                    wire:model="content"
                    wire:keydown.enter="sendMessage"
                />
            </x-filament::input.wrapper>

            <x-filament::button wire:click="sendMessage">
                Send
            </x-filament::button>
        </div>

        @error('content')
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
            {{ $message }}
        </p>
        @enderror
    </div>
</x-filament-panels::page>
