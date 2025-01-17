@php
    use Filament\Support\Enums\Alignment;
@endphp

@props([
    'actions',
    'alignment' => Alignment::End,
    'record' => null,
    'wrap' => false,
])

@php
    $actions = array_filter(
        $actions,
        function ($action) use ($record): bool {
            if (! $action instanceof \Filament\Tables\Actions\BulkAction) {
                $action->record($record);
            }

            return $action->isVisible();
        },
    );

    if (! $alignment instanceof Alignment) {
        $alignment = Alignment::tryFrom($alignment) ?? $alignment;
    }
@endphp

<div
    {{
        $attributes->class([
            'fi-ta-actions flex shrink-0 items-center gap-3',
            'flex-wrap' => $wrap,
            'sm:flex-nowrap' => $wrap === '-sm',
            match ($alignment) {
                Alignment::Center => 'justify-center',
                Alignment::Start, Alignment::Left => 'justify-start',
                Alignment::End, Alignment::Right => 'justify-end',
                'start md:end' => 'justify-start md:justify-end',
                default => $alignment,
            },
        ])
    }}
>
    @foreach ($actions as $action)
        @php
            $labeledFromBreakpoint = $action->getLabeledFromBreakpoint();
        @endphp

        <span
            @class([
                'inline-flex',
                '-mx-2' => $action->isIconButton() || $labeledFromBreakpoint,
                match ($labeledFromBreakpoint) {
                    'sm' => 'sm:mx-0',
                    'md' => 'md:mx-0',
                    'lg' => 'lg:mx-0',
                    'xl' => 'xl:mx-0',
                    '2xl' => '2xl:mx-0',
                    default => null,
                },
            ])
        >
            {{ $action }}
        </span>
    @endforeach
</div>
