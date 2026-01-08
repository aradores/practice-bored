<div class="flex flex-col gap-2.5 w-full max-h-40 overflow-auto">
    @foreach ($this->logs as $log)
        <div class="flex flex-row gap-3 h-auto">
            <div class="flex flex-col items-center gap-1">
                @if ($loop->index === 0)
                    <x-icon.check fill="#7F56D9" />
                @else
                    <x-icon.outline-check />
                @endif

                @if ($loop->index + 1 !== $this->logs->count())
                    <div class="w-[2px] flex-1 bg-primary-600"></div>
                @endif
            </div>
            <div class="flex-col text-sm pb-6">
                <div class="flex flex-row items-center gap-1">
                    <x-icon.invoice />
                    <strong class="text-rp-neutral-700">{{ $log->type->log_title() }}</strong>
                </div>
                @if (in_array($log->type->slug(), ['scheduled', 'rejected']))
                    <div class="text-rp-neutral-500">
                        <span>By: {{ $this->processor_name }}</span>
                    </div>
                @elseif (in_array($log->type->slug(), ['processed', 'failed']))
                    <div class="text-rp-neutral-500">
                        <span>To: {{ $this->recipient_name }}</span>
                    </div>
                @elseif ($log->type->slug() == 'pending')
                    <div class="text-rp-neutral-500">
                        <span>By: {{ $this->creator_name }}</span>
                    </div>
                @endif
                {{-- <div class="text-rp-neutral-500">
                    <span>By: {{ $log->subject_name }}</span>
                </div> --}}
                <div class="text-rp-neutral-500">
                    <span>{{ $log->created_at->timezone('Asia/Manila')->format('F j, Y - h:i A') }}</span>
                </div>

                @if ($log->description)
                    <div class="text-rp-neutral-500">
                        <span>Reason: {{ $log->description }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
