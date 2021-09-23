@section('title', 'Larasocket Demo')

<div
    class="p-6 mt-4 bg-white rounded-lg shadow-md"
    x-data="{{ json_encode(['messages' => $messages, 'messageBody' => '']) }}"
    x-init="
            Echo.join('demo')
                .listen('MessageSentEvent', (e) => {
                    @this.call('incomingMessage', e)
                })
            ">

    <div class="flex flex-row flex-wrap border-b">
        <div class="w-full mb-4 text-gray-600">Members:</div>

        @forelse($here as $authData)
            <div class="px-2 py-1 mb-4 mr-4 text-white bg-blue-700 rounded">
                {{ $authData['name'] }}
            </div>
        @empty
            <div class="py-4 text-gray-600">
                It's quiet in here...
            </div>
        @endforelse
    </div>

    <template x-if="messages.length > 0">
        <template
            x-for="message in messages"
            :key="message.id"
        >
            <div class="my-8">
                <div class="flex flex-row justify-between border-b border-gray-200">
                    <span class="text-gray-600" x-text="message.user.name"></span>
                    <span class="text-xs text-gray-500" x-text="message.created_at"></span>
                </div>
                <div class="my-4 text-gray-800" x-text="message.body"></div>
            </div>
        </template>
    </template>

    <template x-if="messages.length == 0">
        <div class="py-4 text-gray-600">
            It's quiet in here...
        </div>
    </template>

    <div
        class="flex flex-row justify-between"
    >
        <input
            @keydown.enter="
                @this.call('sendMessage', messageBody)
                messageBody = ''
            "
            x-model="messageBody"
            class="w-full px-3 py-2 mr-4 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            type="text"
            placeholder="Hello World!">

        <button
            @click="
                @this.call('sendMessage', messageBody)
                messageBody = ''
            "
            class="self-stretch btn btn-primary"
        >
            Send
        </button>
    </div>
    @error('messageBody') <div class="mt-2 error">{{ $message }}</div> @enderror
</div>
