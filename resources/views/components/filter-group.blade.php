@props(['title', 'class' => ''])

<section {{ $attributes->class(['filter-group', $class]) }}>
    <h3 class="filter-section-title">
        {{ $title }}
    </h3>

    <div class="filter-group-content">
        {{ $slot }}
    </div>
</section>
