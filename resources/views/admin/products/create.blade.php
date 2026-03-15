@extends('layouts.admin')

@section('title', 'Nuevo producto')

@section('content')
<div class="mx-auto max-w-5xl">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-white">Nuevo producto</h3>
        <p class="mt-1 text-sm text-white/60">Registra un producto para el catálogo.</p>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="rounded-3xl border border-white/10 bg-[#151515] p-6">
        @csrf
        @php($product = null)
        @include('admin.products._form')
    </form>
</div>
@endsection