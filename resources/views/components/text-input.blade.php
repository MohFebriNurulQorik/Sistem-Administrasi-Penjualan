@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-white-300 border-white-700 bg-white-900 text-gray-900 focus:border-indigo-500 focus:border-indigo-600 focus:ring-indigo-500 focus:ring-indigo-600 rounded-md shadow-sm']) }} style="color: #000000">
