@extends('layouts.admin')

@section('title', 'Editar categoría')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-white">Editar categoría</h3>
        <p class="mt-1 text-sm text-white/60">Actualiza la información de la categoría.</p>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="rounded-3xl border border-white/10 bg-[#151515] p-6">
        @csrf
        @method('PUT')
        @include('admin.categories._form')
    </form>
</div>
@endsection