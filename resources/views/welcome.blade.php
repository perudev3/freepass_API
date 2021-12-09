@extends('layouts.app_front')

@section('content')

    <section class="banner-section" >
        <div class="banner-bg bg-fixed" style="background: url('images/banner.jpg') repeat-y fixed;"></div> <!--Imagen del banner-->
            <div class="container">
                <div class="banner-content">
                    <h1 class="title  cd-headline clip title-Welcome" style="color: #fff;">
                        <span class="d-block">WE GOT OUT.</span>
                        <p style="font-size: 18px;font-family: monospace;">
                            <i class="fa fa-search"></i> Haz click en cualquier sitio para tu próxima experiencia inolvidable 
                        </p>
                    </h1>
                </div>
            </div>
    </section>

    <router-view></router-view>

@endsection
