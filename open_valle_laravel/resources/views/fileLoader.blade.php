@extends('layouts.app')

@section('content')
<div class="container">
    <h1>File Uploader</h1>
    <form method="POST" action="{{route('fileLoader')}}">
        @csrf
        <div id="excel_input"></div>
    </form>
    <h3>Valid Table Headers</h3>
    <ul>
        <li>ITEM</li>
        <li>COD_DANE_DEPARTAMENTO</li>
        <li>DEPARTAMENTO</li>
        <li>COD_SECRETARIA</li>
        <li>SECRETARIA</li>
        <li>COD_DANE_MUNICIPIO</li>
        <li>MUNICIPIO</li>
        <li>EST_ID</li>
        <li>CODIGO_DANE_EE</li>
        <li>NOMBRE_EE</li>
        <li>SEDE_ID	CODIGO_DANE_SEDE</li>
        <li>NOMBRE_SEDE	DIRECCION_SEDE</li>
        <li>ZONA</li>
        <li>MATRICULA</li>
        <li>PRIORIZADA</li>
    </ul>
</div>
@endsection
