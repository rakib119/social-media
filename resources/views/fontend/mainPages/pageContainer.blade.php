@extends('fontend.layout.layout')
@section('mainContent')
    <section class="about-one">
        <div class="auto-container">
            <div class="row clearfix">
                {!! $content !!}
            </div>
        </div>
    </section>
@endsection
