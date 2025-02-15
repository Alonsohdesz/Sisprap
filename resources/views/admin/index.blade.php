@extends('admin.layout.app')
@section('contenido')
<template v-if="menu==0">
 <div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="images/logo.png" class="img-fluid" alt="logo sisprap" style="width: 800px;">
                </div>
            </div>
        </div>
    </div>
</div>
@if (Auth::user()->rol_id == 1 and Auth::user()->id == 0)
<div class="col-lg-4 col-md-4">
    <div class="card">
        <img class="card-img-top"  src="images/atajos/GESTIONES.png" @click="menu=4" style="cursor: pointer" alt="Card image cap">
        <div class="card-img-overlay" style="height:90px;">
        </div>
        <div class="card-body weather-small">
            <div class="row">
                <div class="col-12 b-r align-self-center">
                    <div class="d-flex">
                        <div class="m-l-20 text-center" @click="menu=4"  style="display: block; cursor:pointer;margin-left: auto;margin-right: auto;">
                            <h6><strong>GESTION PROYECTOS</strong></h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-4">
    <div class="card">
        <img class="card-img-top"  src="images/atajos/PEINSCRIPCIONES.png" @click="menu=2" style="cursor: pointer" alt="Card image cap">
        <div class="card-img-overlay" style="height:90px;">
        </div>
        <div class="card-body weather-small">
            <div class="row">
                <div class="col-12 b-r align-self-center">
                    <div class="d-flex">
                        <div class="m-l-20 text-center" @click="menu=2"  style="display: block; cursor:pointer;margin-left: auto;margin-right: auto;">
                            <h6><strong>PREINSCRIPCIONES</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-4">
    <div class="card">
        <img class="card-img-top"  src="images/atajos/PUBLICACIONES.png" style="cursor: pointer" @click="menu=1"  alt="Card image cap">
        <div class="card-img-overlay" style="height:90px;">
        </div>
        <div class="card-body weather-small">
            <div class="row">
                <div class="col-12 b-r align-self-center">
                    <div class="d-flex">
                        <div class="m-l-20 text-center" @click="menu=1" style="display: block;  cursor:pointer;margin-left: auto;margin-right: auto;">
                            <h6><strong>PUBLICACIONES</strong></h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endif
</template>
@if (Auth::user()->rol_id == 1)
<template v-if="menu==1">
    <publiproject :user="{{Auth::user()}}"></publiproject>
</template>
@elseif(Auth::user()->rol_id == 2)
<template v-if="menu==1">
    <pagoarancel></pagoarancel>
</template>
@endif
<template v-if="menu==2">
    <preregister></preregister>
</template>
<template v-if="menu==3">
    <lineaproject></lineaproject>
</template>
<template v-if="menu==4">
    <gestproy></gestproy>
</template>
<template v-if="menu==5">
    <institucion :user="{{Auth::user()}}"></institucion>
</template>
<template v-if="menu==6">
    <hojasupervgeneral></hojasupervgeneral>
</template>
<template v-if="menu==7">
    <constancias></constancias>
</template>
<template v-if="menu==8">
    <pagoaranceladmin></pagoaranceladmin>
</template>
<template v-if="menu==9">
    <usuarios></usuarios>
</template>
<template v-if="menu==11">
    <general></general>
</template>
<template v-if="menu==12">
    <carrinst></carrinst>
</template>
<template v-if="menu==13">
   <supervision></supervision>
</template>
<template v-if="menu==14">
   <regsuperv></regsuperv>
</template>
<template v-if="menu==15">
   <configuracion></configuracion>
</template>
<template v-if="menu==16">
   <inicioproceso></inicioproceso>
</template>
<template v-if="menu==17">
   <pendientesinicio></pendientesinicio>
</template>
<template v-if="menu==18">
   <pendientefin></pendientefin>
</template>
<template v-if="menu==19">
   <culminados></culminados>
</template>
<template v-if="menu==20">
   <sectores></sectores>
</template>
<template v-if="menu==21">
 <pagoarancel></pagoarancel>
</template>
<template v-if="menu==22">
 <solicitudes_aprobadas></solicitudes_aprobadas>
</template>
<template v-if="menu==23">
 <proyectos_externos></proyectos_externos>
</template>
<template v-if="menu==24">
<chat :user="{{Auth::user()}}" v-on:updmessagesunread="getMessagesUnread"></chat>
</template>
@endsection