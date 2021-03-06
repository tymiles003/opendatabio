@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('messages.person_details')
                </div>

		<div class="panel-body">
<p>
	<strong>
	@lang('messages.full_name')
:</strong>
	{{ $person->full_name }}
</p>
<p>
	<strong>
	@lang('messages.abbreviation')
:</strong>
	{{ $person->abbreviation }}
</p>
<p>
	<strong>
	@lang('messages.email')
:</strong>
	{{ $person->email }}
</p>
@if ($person->institution)
<p>
	<strong>
	@lang('messages.institution')
:</strong>
	{{ $person->institution }}
</p>
@endif
@if ($person->herbarium)
<p>
	<strong>
	@lang('messages.herbarium')
:</strong>
<a href="{{url('herbaria/'. $person->herbarium->id)}}">{{ $person->herbarium->acronym }}</a>
@endif
</p>

@if ($person->taxons->count())
<p>
	<strong>
	@lang('messages.specialist_in')
	</strong>
<ul>
@foreach ($person->taxons as $taxon)
<li><a href="{{url('taxons/'. $taxon->id)}}">{{ $taxon->fullname }}</a></li>
@endforeach
</ul>
</p>
@endif
@can ('update', $person)
				<a class="btn btn-success" href="{{url ('persons/' . $person->id . '/edit')}}">
				    <i class="fa fa-btn fa-plus"></i>
@lang('messages.edit_person')
				</a>
@endcan
            </div>
</div>
@if ($collected->count())
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('messages.collector')
                </div>

		<div class="panel-body">
<p>
<ul>
@foreach ($collected as $scollected)
@if ($scollected->object)
<li><a href="{{url('plants/' . $scollected->object->id)}}">{{$scollected->object->fullname}}</a>
    (<em>{{$scollected->object->identification->taxon->fullname}}</em>)</li>
@endif
@endforeach
</ul>
            </div>
@endif
            
<!-- Other details (specialist, collects, etc?) -->
    </div>
@endsection
