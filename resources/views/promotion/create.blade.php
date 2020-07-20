@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">

        @include('include.left-menu')

        <div class="col-md-8">

            @if (session()->exists('studentsPromoted'))
            <div class="alert alert-success text-center">selected students promoted</div>
            @endif

            @if ( $students->count() )

                <div class = "table-responsive">
                <form method="POST" action="{{route('promote.students')}}">

                        @csrf

                        <div>
                            @error('students')
                                <div>{{$message}}</div>
                            @enderror
                            @error('students.*')
                                <div>{{$message}}</div>
                            @enderror
                            @error('status')
                                <div>{{$message}}</div>
                            @enderror
                            @error('semester_id')
                                <div>{{$message}}</div>
                            @enderror
                            @error('section_id')
                                <div>{{$message}}</div>
                            @enderror
                        </div>

                        <div>
                            <table>
                                <thead>
                                    <tr>
                                    <th scope="col">promote</th>
                                    <th scope="col">demote</th>
                                    <th scope="col">repeat</th>
                                    <th scope="col">left</th>
                                    <th scope="col">graduated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><input type="radio" name="status" value="promoted"></th>
                                        <th><input type="radio" name="status" value="demoted"></th>
                                        <th><input type="radio" name="status" value="repeat"></th>
                                        <th><input type="radio" name="status" value="left"></th>
                                        <th><input type="radio" name="status" value="graduated"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>

                            @if ( $schoolClasses->count() )
    
                                {{-- current_section_id is used to keep track of the current section 
                                    we are trying to remove students (promote) from
                                --}}
                             <input type="hidden" name="current_section_id" value="{{$currentSectionId}}">
    
                                <select name="section_id" id="section_id">
                                    <option value="">select section</option>
                                    @foreach ($schoolClasses as $schoolClass)
                                        @foreach ($schoolClass->sections as $section)
                                            <option value="{{$section->id}}">
                                                {{$schoolClass->class_name .' ' .$schoolClass->group .' : ' .$section->section_name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
    
                                <select name="semester_id" id="semester_id">
                                    <option value="">select semester</option>
                                    @foreach ($schoolSessions as $schoolSession)
                                        <optgroup label="{{$schoolSession->session_name}}">
                                            @foreach ($schoolSession->semesters as $semester)
                                            <option value="{{$semester->id}}">{{$semester->semester_name}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
    
                                </select>
    
    
                                @else
                                    <h3>no section exists</h3>
                                @endif
                               
                            </div>
    
    
                            <button type="submit" class="btn btn-primary">
                                    {{ __('submit') }}
                            </button>
                        <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">student id</th>
                                    <th scope="col">student name</th>
                                    <th scope="col">select</th>
                                </tr>
                                <tr>
                                    <ul>
                                        
                                    </ul>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <th scope="row">{{$student->id}}</th>
                                            <th scope="row">{{$student->name}}</th>
                                            <th><input type="checkbox" name="students[]" value="{{$student->id}}"></th>
                                        </tr>
                                    @endforeach
                                </tbody> 

                                <div>{{$students->links()}}</div>
                        </table>

                        
                    </form>
                    
                </div>     
            @else
                <h3>this section has no students for it yet in ongoing semester</h3>
            @endif
            
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded' , () => {
       
        var status = document.querySelectorAll('input[type=radio]');
       
        for(var i = 0 ; i < status.length ; i++){
            status[i].addEventListener('click' , addSelect , false);
        }//end of loop 

        function addSelect(e){
            if(e.target.checked){

                switch (e.target.value) {
                    case 'left':
                    case 'graduated':
                        document.getElementById('semester_id').style.display = 'none';
                        document.getElementById('section_id').style.display = 'none';

                        document.getElementById('semester_id').value = '';
                        document.getElementById('section_id').value = '';
                        break;

                    case 'promoted':
                    case 'demoted':
                        document.getElementById('semester_id').style.display = 'inline-block';
                        document.getElementById('section_id').style.display = 'inline-block';
                        break;

                    case 'repeat':
                        document.getElementById('semester_id').style.display = 'inline-block';
                        document.getElementById('section_id').style.display = 'none';

                        document.getElementById('section_id').value = '';
                        break;

                    default:
                        break;
                }
            }

        }
       
    });
</script>
@endsection
