<button 
    {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary font-weight-bold text-uppercase']) }}>
    {{ $slot }}
</button>
