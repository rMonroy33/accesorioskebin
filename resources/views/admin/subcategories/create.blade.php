@extends('layouts.admin')

@section('title', 'Nueva subcategoría')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-white">Nueva subcategoría</h3>
        <p class="mt-1 text-sm text-white/60">Registra una nueva subcategoría para el catálogo.</p>
    </div>

    <form action="{{ route('admin.subcategories.store') }}" method="POST" class="rounded-3xl border border-white/10 bg-[#151515] p-6">
        @csrf
        @php($subcategory = null)
        @include('admin.subcategories._form')
    </form>
</div>
@endsection