@extends('layouts.admin')

@section('title', 'Nueva categoría')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-white">Nueva categoría</h3>
        <p class="mt-1 text-sm text-white/60">Registra una nueva categoría para el catálogo.</p>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="rounded-3xl border border-white/10 bg-[#151515] p-6">
        @csrf
        @include('admin.categories._form')
    </form>
</div>
@endsection