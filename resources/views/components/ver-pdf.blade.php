<a {{ $attributes->merge([ 'class' => 'relative inline-flex items-center px-2 leading-5 font-semibold rounded-full bg-red-500 text-xs text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300'
]) }}>
    {{ $slot }}