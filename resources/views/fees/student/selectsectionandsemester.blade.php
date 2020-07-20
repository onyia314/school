@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">
            
            @if( $studentSections->count() )
                @foreach ($studentSections as $sectionHistory)
        <div>
        <a href="{{route('view.fee' , ['section_id' => $sectionHistory->section_id , 'semester_id' => $sectionHistory->semester_id ])}}">
                {{
                 $sectionHistory->semester->semester_name .' '
                .$sectionHistory->semester->schoolSession->session_name .' ' 
                .$sectionHistory->section->schoolClass->class_name .' ' 
                .$sectionHistory->section->section_name
                }}
            </a>
        </div>
                @endforeach
            @else

            @endif
        
        </div>
    </div>
</div>
@endsection
