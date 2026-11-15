@php($localizedBody = $tool->localizedBody())
@if ($localizedBody)
<section class="pb-4 sm:pb-6">
    <article class="rich-body py-4">
        {!! $localizedBody !!}
    </article>
</section>
@endif
